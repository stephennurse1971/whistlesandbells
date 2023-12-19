<?php

namespace App\Form;

use App\Entity\ToDoList;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
