<?php

namespace App\Form;

use App\Entity\TennisPlayerAvailability;
use App\Entity\TennisPlayers;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisPlayerAvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class,[
                'class'=> User::class,
                'choice_label'=> 'fullName'
            ])
            ->add('date', DateTimeType::class, [
                'label' => "Date",
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker datetime'
                ],
            ])
            ->add('')
            ->add('available')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisPlayerAvailability::class,
        ]);
    }
}
