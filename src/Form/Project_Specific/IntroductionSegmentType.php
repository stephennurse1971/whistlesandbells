<?php

namespace App\Form\Project_Specific;

use App\Entity\Project_Specific\IntroductionSegment;
use App\Entity\Project_Specific\User;
use App\Repository\Project_Specific\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IntroductionSegmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $this->userRepository->findByRole('ROLE_JOB_APPLICANT'),
                'required' => true,
                'empty_data' => null,
            ])
            ->add('country')
            ->add('emailSegment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IntroductionSegment::class,
        ]);
    }
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
}
