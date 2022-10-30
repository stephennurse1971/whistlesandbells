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
            ->add('salutation')
            ->add('firstName')
            ->add('lastName')
            ->add('jobTitle')
            ->add('linkedIn')
            ->add('company')

            ->add('businessStreet')
            ->add('businessCity')
            ->add('businessPostalCode')
            ->add('businessCountry')

            ->add('homeStreet')
            ->add('homeCity')
            ->add('homePostalCode')
            ->add('homeCountry')

            ->add('recruitingArea')
            ->add('areasOfInterestList', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Asset Management' => 'AM',
                    'Investment Banking' => 'IB',
                    'Fixed Income' => 'FI',
                    'Equities' => 'Eq',
                    'Hedge Funds' => 'HF',
                    'Risk' => 'Risk',
                    'Private Equity' => 'PE',
                    'CEOs' => 'CEOs',
                    'Compliance' => 'Compl'
                ], ])


            ->add('email')
            ->add('email2')
            ->add('email3')
            ->add('mobile', TextType::class, [
                'required' => false
            ])
            ->add('mobile2', TextType::class, [
                'required' => false
            ])
            ->add('businessPhone', TextType::class, [
                'required' => false
            ])
            ->add('homePhone', TextType::class, [
                'required' => false
            ])
            ->add('homePhone2', TextType::class, [
                'required' => false
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('webPage')
            ->add('notes')
            ->add('inviteDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text'
            ])

            ->add('role', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Super-Admin' => 'ROLE_SUPER_ADMIN',
                    'Admin' => 'ROLE_ADMIN',
                    'Family' => 'ROLE_FAMILY',
                    'HMRC' => 'ROLE_HMRC',
                    'Accountant' => 'ROLE_ACCOUNTANT',
                    'Contact' => 'ROLE_CONTACT',
                    'Recruiter' => 'ROLE_RECRUITER',
                    'Job applicant' => 'ROLE_JOB_APPLICANT',
                    'Guest' => 'ROLE_GUEST'
                ],
                'mapped' => false
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false,
            ])
            ->add('sendEmail', HiddenType::class, [
                'mapped' => false,
                'required' => false
            ]);;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'email1' => null,
            'email2' => null,

        ]);
    }
}
