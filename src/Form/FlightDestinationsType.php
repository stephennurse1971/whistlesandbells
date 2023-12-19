<?php

namespace App\Form;

use App\Entity\FlightDestinations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightDestinationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departureCity')
            ->add('departureCode')
            ->add('arrivalCity')
            ->add('arrivalCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FlightDestinations::class,
        ]);
    }
}
