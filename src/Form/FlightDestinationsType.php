<?php

namespace App\Form;

use App\Entity\Airports;
use App\Entity\FlightDestinations;
use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightDestinationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departureCity', EntityType::class, [
                'class' => Airports::class,
                'choice_label' => 'city',
                'required' => true,
                'empty_data' => null,
                'data'=>$options['oac']
            ])
            ->add('arrivalCity', EntityType::class, [
                'class' => Airports::class,
                'choice_label' => 'city',
                'required' => true,
                'empty_data' => null,
                'data'=>$options['odc']
            ])

            ->add('dateStart', DateType::class, [
                'label' => 'Start date',
                'widget' => 'single_text',
                'required' => false,
                'data'=>$options['ods']
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'End date',
                'widget' => 'single_text',
                'required' => false,
                'data'=>$options['ode']
            ])
            ->add('adminOnly')
            ->add('isActive')
            ->add('returnLeg')
            ->add('lastScraped', DateType::class, [
                'label' => 'Last Scraped',
                'widget' => 'single_text',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FlightDestinations::class,
            'odc'=>null,
            'oac'=>null,
            'ods'=>null,
            'ode'=>null,
            'rt'=>null,
        ]);
    }
}
