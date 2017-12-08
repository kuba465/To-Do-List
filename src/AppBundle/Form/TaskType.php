<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextType::class, ['attr' => ['required' => false, 'class' => 'form-control']])
            ->add('dateToDone', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker form-control',
                    'required' => false,
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => 'AppBundle:Category',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'required' => true,
                    'class' => 'form-control'
                ]
            ])
            ->add('priority', EntityType::class, [
                'class' => 'AppBundle:Priority',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'required' => false,
                    'class' => 'form-control'
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_task';
    }


}
