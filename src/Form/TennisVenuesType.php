<?php

namespace App\Form;

use App\Entity\TennisVenues;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('bookingEngine',ChoiceType::class,[
                'multiple'=>false,
                'choices'=>[
                    'TowerHamlets'=>'TowerHamlets',
                    'WillToWin'=>'WillToWin',
                ]
            ])
            ->add('towerHamletsId')
            ->add('londonRegion',ChoiceType::class,[
                'multiple'=>false,
                'choices'=>[
                    'North'=>'North',
                    'North-East'=>'North-East',
                    'East'=>'East',
                    'South-East'=>'South-East',
                    'South'=>'South',
                    'South-West'=>'South-West',
                    'West'=>'West',
                    'North-West'=>'North-West',
                ]
            ])
            ->add('comment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisVenues::class,
        ]);
    }
}
