<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Priority;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskRepository")
 */
class Task implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     * @Assert\NotBlank(message="Add some task")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inputDate", type="datetime")
     * @Assert\DateTime()
     */
    private $inputDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateToDone", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $dateToDone;

    /**
     * @var bool
     *
     * @ORM\Column(name="isDone", type="boolean")
     */
    private $isDone = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="tasks")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="task")
     */
    protected $comments;

    /**
     * @ORM\ManyToOne(targetEntity="Priority", inversedBy="tasks")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id")
     */
    protected $priority;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set inputDate
     *
     * @param \DateTime $inputDate
     *
     * @return Task
     */
    public function setInputDate($inputDate)
    {
        $this->inputDate = $inputDate;

        return $this;
    }

    /**
     * Get inputDate
     *
     * @return \DateTime
     */
    public function getInputDate()
    {
        return $this->inputDate;
    }

    /**
     * Set dateToDone
     *
     * @param \DateTime $dateToDone
     *
     * @return Task
     */
    public function setDateToDone($dateToDone)
    {
        $this->dateToDone = $dateToDone;

        return $this;
    }

    /**
     * Get dateToDone
     *
     * @return \DateTime
     */
    public function getDateToDone()
    {
        return $this->dateToDone;
    }

    /**
     * Set isDone
     *
     * @param boolean $isDone
     *
     * @return Task
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * Get isDone
     *
     * @return bool
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Task
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Task
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set priority
     *
     * @param Priority $priority
     *
     * @return Task
     */
    public function setPriority(Priority $priority = null)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function jsonSerialize()
    {
        $commentsArray = [];
        $comments = $this->getComments();
        foreach ($comments as $comment) {
            $commentsArray[] = [
                'description' => $comment->getDescription(),
                'user' => $comment->getUser()->getUserName(),
            ];
        }

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'inputDate' => $this->getInputDate(),
            'dateToDone' => $this->getDateToDone(),
            'isDone' => $this->getIsDone(),
            'category' => $this->getCategory()->getName(),
            'priority' => $this->getPriority()->getName(),
            'comments' => $commentsArray,
        ];
    }

    public function __toString()
    {
        return $this->getName();
    }
}
