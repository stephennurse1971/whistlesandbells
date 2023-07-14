<?php

namespace App\Form;

use App\Entity\ToDoList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToDoListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task')
            ->add('priority')
            ->add('assignedTo')
            ->add('completionDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('description')
            ->add('file', FileType::class, [
                'multiple'=>true,
                'mapped' => false,
                'required' =>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ToDoList::class,
            'allow_extra_fields' => true,
        ]);
    }
}
