<?php

namespace App\Form\ProjectSpecific;

use App\Entity\ProjectSpecific\Health;
use App\Entity\ProjectSpecific\User;
use App\Repository\ProjectSpecific\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HealthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $this->userRepository->findByRole('ROLE_HEALTH'),
                'required' => true,
                'empty_data' => null,
            ])
            ->add('date', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('weight')
            ->add('diastolic')
            ->add('systolic')
            ->add('heartRate');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Health::class,
        ]);
    }
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
