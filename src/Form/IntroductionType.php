<?php

namespace App\Form;

use App\Entity\Introduction;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IntroductionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $this->userRepository->findByRole('ROLE_JOB_APPLICANT'),
                'required' => true,
                'empty_data' => null,
            ])
            ->add('region')
            ->add('areaOfInterest')
            ->add('subjectLine')
            ->add('introductoryEmail')
            ->add('attachment', FileType::class, [
                'label' => 'CV',
                'mapped' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Introduction::class,
        ]);
    }

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
