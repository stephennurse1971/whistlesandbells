<?php

namespace App\Form;

use App\Entity\TennisVenues;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisVenuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('venue')
            ->add('address')
            ->add('mapLink')
            ->add('webLink')
            ->add('telNumber')
            ->add('email')
            ->add('bookingEngine')
            ->add('londonRegion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisVenues::class,
        ]);
    }
}
