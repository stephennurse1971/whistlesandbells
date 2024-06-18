<?php

namespace App\Form\Project_Specific;
use App\Entity\Project_Specific\Introduction;
use App\Entity\Project_Specific\User;
use App\Repository\Project_Specific\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
               // 'empty_data' => null,
            ])
            ->add('region', TextType::class, [
                'required' => true
            ])
            ->add('areaOfInterest', TextType::class, [
                'required' => false
            ])
            ->add('subjectLine', TextType::class, [
                'required' => false
            ])
            ->add('introductoryEmail', TextareaType::class, [
                'required' => false
            ])
            ->add('introductoryEmail2', TextareaType::class, [
                'required' => false
            ])
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
          //  'allow_extra_fields' => true,
        ]);
    }

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
