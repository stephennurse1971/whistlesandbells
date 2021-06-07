<?php

namespace App\Form;

use App\Entity\TennisCourtAvailability;
use App\Entity\TennisVenues;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisCourtAvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('venue', EntityType::class, [
                'class'=>TennisVenues::class,
                'choice_label'=>'venue',
                'label'=>'Tennis court'
            ])
            ->add('date', DateTimeType::class, [
                'label' => "Date",
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker datetime'
                ],
            ])
            ->add('hour')
            ->add('available')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisCourtAvailability::class,
        ]);
    }
}
