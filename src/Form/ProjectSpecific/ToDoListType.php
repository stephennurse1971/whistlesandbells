<?php

namespace App\Form\ProjectSpecific;

use App\Entity\ProjectSpecific\ToDoList;
use App\Entity\ProjectSpecific\User;
use App\Repository\ProjectSpecific\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToDoListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project')
            ->add('accessTo', EntityType::class, [
                'class' => User::class,
                'required' => false,
                'choice_label' => 'fullName',
                'multiple' => true,
                'choices' => $this->userRepository->findByRole('ROLE_IT')
            ])
            ->add('priority');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ToDoList::class,
            'allow_extra_fields' => true,
        ]);
    }

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

}
