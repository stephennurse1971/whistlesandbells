<?php

namespace App\Form\Project_Specific;

use App\Entity\Project_Specific\Airports;
use App\Entity\Project_Specific\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirportsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('includeInFlightPrices')
            ->add('city')
            ->add('airportCode')
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'country',
                'required' => true,
                'empty_data' => null
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Airports::class,
        ]);
    }
}
