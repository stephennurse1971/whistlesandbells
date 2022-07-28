<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('company')
            ->add('businessAddress')
            ->add('homeAddress')
            ->add('email')
            ->add('email2')
            ->add('email3')
            ->add('mobile',TextType::class,[
                'required'=>false
            ])
            ->add('mobile2')
            ->add('businessPhone')
            ->add('homePhone')
            ->add('homePhone2')
            ->add('birthday', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('webPage')
            ->add('notes')
            ->add('inviteDate', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('calendarInviteEmail',ChoiceType::class,[
                'choices'=>[
                    $options['email1']=>$options['email1'],
                    $options['email2']=>$options['email2']
                ],
            ])
            ->add('role',ChoiceType::class,[
                'multiple'=>true,
                'expanded'=>true,
                'choices'=>[
                    'Super-Admin'=>'ROLE_SUPER_ADMIN',
                    'Admin'=>'ROLE_ADMIN',
                    'Family'=>'ROLE_FAMILY',
                    'HMRC' =>'ROLE_HMRC',
                    'Serpentine' =>'ROLE_SERPENTINE',
                    'Accountant' =>'ROLE_ACCOUNTANT',
                    'Contact' =>'ROLE_CONTACT',
                    'Guest' => 'ROLE_GUEST'
                ],
                'mapped'=>false
            ])

            ->add('password',PasswordType::class,[
                'mapped'=>false,
            ])

            ->add('sendEmail',HiddenType::class,[
                'mapped' => false,
                'required'=>false
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'email1'=>null,
            'email2'=>null,

        ]);
    }
}
