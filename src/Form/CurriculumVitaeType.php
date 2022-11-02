<?php

namespace App\Form;

use App\Entity\CurriculumVitae;
use App\Entity\PhotoLocations;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurriculumVitaeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('candidate', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $this->userRepository->findByRole('ROLE_JOB_APPLICANT'),
                'required' => true,
                'empty_data' => null,
            ])
            ->add('section', ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Job' => 'Job',
                    'Summary' => 'Summary',
                    'Education' => 'Education'
                ],])
            ->add('date', DateType::class, [
                'label' => 'Start date',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('dateFinish', DateType::class, [
                'label' => 'End date',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('title')
            ->add('jobDescription')


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CurriculumVitae::class,
        ]);
    }
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
