<?php

namespace App\Form\ProjectSpecific;

use App\Entity\ProjectSpecific\Airports;
use App\Entity\ProjectSpecific\Country;
use App\Entity\ProjectSpecific\UkDays;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UkDaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('flightDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('departCountry', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'country',
                'required'=>false
            ])
            ->add('departureAirport', EntityType::class, [
                'class' => Airports::class,
                'choice_label' => 'city'
            ])
            ->add('arrivalCountry', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'country',
                'required'=>false
            ])
            ->add('arrivalAirport', EntityType::class, [
                'class' => Airports::class,
                'choice_label' => 'city'
            ])
            ->add('airline')
            ->add('comment')
            ->add('travelDocs', FileType::class, [
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UkDays::class,
            'allow_extra_fields' => true,
        ]);
    }
}
