<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Task;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Task controller.
 *
 * @Route("tasks")
 */
class TaskController extends Controller
{
    /**
     * Lists all task entities.
     *
     * @Route("/", name="tasks_all")
     * @Route("/byCategory/{categoryId}", name="tasks")
     * @Method({"GET", "POST"})
     *
     */
    public function indexAction(Request $request, $categoryId = null)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $categories = $this->showCategories();

        $tasks = $em->getRepository('AppBundle:Task')->findBy([
            'user' => $user,
            'category' => $categoryId,
            'isDone' => 0,
        ]);

        //functionalities for category form
        $category = new Category();
        $formCategory = $this->createForm('AppBundle\Form\CategoryType', $category);
        $formCategory->handleRequest($request);
        if ($formCategory->isSubmitted() && $formCategory->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category->setUser($user);
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('tasks');
        }

        //functionalities for task form
        $task = new Task();
        $formTasks = $this->createForm('AppBundle\Form\TaskType', $task);
        $formTasks->handleRequest($request);

        if ($formTasks->isSubmitted() && $formTasks->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $inputDate = new DateTime("now");
            $task->setInputDate($inputDate);
            $task->setUser($this->getUser());
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('tasks');
        }

        $comment = new Comment();
        $formComments = $this->createForm('AppBundle\Form\CommentType', $comment);

        return $this->render('task/index.html.twig', array(
            'tasks' => $tasks,
            'categories' => $categories,
            'formCategory' => $formCategory->createView(),
            'formTask' => $formTasks->createView(),
            'formComment' => $formComments->createView(),
        ));
    }

    /**
     * @Route("/addComment", name="addComment")
     * @Method({"POST"})
     */
    public function addNewComment(Request $request)
    {
        $commentValue = $request->get('commentValue');
        $taskId = $request->get('taskId');
        $task = $this->getDoctrine()->getRepository('AppBundle:Task')->find($taskId);
        $user = $this->getUser();

        $comment = new Comment();
        $comment->setDescription($commentValue)
            ->setUser($user)
            ->setTask($task);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return new JsonResponse(['user' => $user, 'comment' => $comment]);
    }

    /**
     * Creates a new task entity.
     *
     * @Route("/new", name="tasks_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm('AppBundle\Form\TaskType', $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $inputDate = new DateTime("now");
            $task->setInputDate($inputDate);
            $task->setUser($this->getUser());
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('tasks', array('id' => $task->getId(), 'categoryId' => $task->getCategory()->getId()));
        }

        return $this->render('task/new.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a task entity.
     *
     * @Route("/{id}", name="tasks_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Task $task)
    {

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($task, 'json');

        return new Response($data);

    }

    /**
     * Displays a form to edit an existing task entity.
     *
     * @Route("/{id}/edit", name="tasks_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Task $task)
    {
        $deleteForm = $this->createDeleteForm($task);
        $editForm = $this->createForm('AppBundle\Form\TaskType', $task);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tasks');
        }


        return $this->render('task/edit.html.twig', array(
            'task' => $task,
            'edit_form' => $editForm->createView(),
        ));


    }

    /**
     * Deletes a task entity.
     *
     * @Route("/{id}", name="tasks_delete")
     * @Method("")
     */
    public function deleteAction(Request $request, Task $task)
    {
        $form = $this->createDeleteForm($task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
        }

        return $this->redirectToRoute('tasks');
    }

    /**
     * @Route("/{id}/delete", name="taskDelete")
     * @Method("DELETE")
     */
    public function taskDeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $taskIsDeleted = $em->getRepository("AppBundle:Task")->findOneById($id);

        $doctrine = $this->getDoctrine();
        $doctrine->getRepository("AppBundle:Task")->deleteAllStuffConnectWithTask($id);

        $em->remove($taskIsDeleted);
        $em->flush();

//        return $this->redirectToRoute('tasks');
        return new JsonResponse(['delete' => true]);
    }

    /**
     * @Route("/{id}/done", name="taskIsDone")
     */
    public function taskIsDoneAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository("AppBundle:Task")->findOneById($id);
        $doctrine = $this->getDoctrine();
        $taskIsDone = $doctrine->getRepository("AppBundle:Task")->makeTaskDone($id);
        $catId = $task->getCategory()->getId();

        return $this->redirectToRoute('tasks', ['categoryId' => $catId]);
    }

    /**
     * @Route("/byCategory/{categoryId}/showDone", name="showDone")
     * @Method({"GET", "POST"})
     */
    public function showDoneAction(Request $request, $categoryId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $tasks = $em->getRepository('AppBundle:Task')->findBy([
            'user' => $user,
            'category' => $categoryId,
            'isDone' => 1]);

//        dump($tasks);
        return new JsonResponse(['doneTasks' => $tasks]);
//        return $this->render('comment/index.html.twig', array(

//        ));
    }

    /**
     * Creates a form to delete a task entity.
     *
     * @param Task $task The task entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Task $task)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tasks_delete', array('id' => $task->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    private function showCategories()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $categories = $em->getRepository('AppBundle:Category')->findBy(['user' => $user]);

        return $categories;
    }
}
