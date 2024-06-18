<?php

namespace App\Form\Project_Specific;

use App\Entity\Project_Specific\ProspectEmployer;
use App\Entity\Project_Specific\User;
use App\Repository\Project_Specific\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProspectEmployerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('employer')
            ->add('recruiter', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $this->userRepository->findByRole('ROLE_RECRUITER'),
                'required' => true,
                'empty_data' => null,
            ])
            ->add('applicant', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $this->userRepository->findByRole('ROLE_JOB_APPLICANT'),
                'required' => true,
                'empty_data' => null,
            ])


            ->add('interviewer1', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $this->userRepository->findByCompany($options['employer']),
                'required' => false,
                'empty_data' => null,
            ])

            ->add('interviewer2', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $this->userRepository->findByCompany($options['employer']),
                'required' => false,
                'empty_data' => null,
            ])

            ->add('interviewer3', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $this->userRepository->findByCompany($options['employer']),
                'required' => false,
                'empty_data' => null,
            ])



            ->add('interviewDate1', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker datetime'
                ],
            ])
            ->add('interviewDate2', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker datetime'
                ],
            ])
            ->add('interviewDate3', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker datetime'
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProspectEmployer::class,
            'employer'=>null
        ]);
    }
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
