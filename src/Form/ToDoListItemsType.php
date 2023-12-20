<?php

namespace App\Form;

use App\Entity\ToDoList;
use App\Entity\ToDoListItems;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToDoListItemsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('project',EntityType::class,[
                'class' => ToDoList::class,
                'choice_label'=> 'project',
                'choices'=>$options['project']
            ])
            ->add('task',TextType::class,[
                'required'=>false
            ])
            ->add('priority')
            ->add('status', ChoiceType::class, [
                'multiple' => false,
                'required' =>true,
                'expanded' => false,
                'data'=>'Pending',
                'choices' => [
                    'Complete' => 'Complete',
                    'Pending' => 'Pending',
                    'Blocked' => 'Blocked',
                ],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ToDoListItems::class,
            'project'=>null
        ]);
    }
}
