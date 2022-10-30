<?php

namespace App\Form;

use App\Entity\ProspectEmployer;
use App\Entity\User;
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
            ->add('recruiter', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
//                'choices'=>$this->userRepository->findByRole('ROLE_RECRUITER'),
                'required' => true,
                'empty_data' => null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProspectEmployer::class,
        ]);
    }
}
