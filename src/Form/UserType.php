<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName')
            ->add('email')
            ->add('mobile')
            ->add('role',ChoiceType::class,[
                'choices'=>[
                    'Super-Admin'=>'ROLE_SUPER_ADMIN',
                    'Admin'=>'ROLE_ADMIN',
                    'Tennis player'=>'ROLE_TENNIS_PLAYER',
                    'Family'=>'ROLE_FAMILY',
                ],
                'mapped'=>false
            ])
            ->add('password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
