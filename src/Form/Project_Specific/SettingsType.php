<?php

namespace App\Form\Project_Specific;

use App\Entity\Project_Specific\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('flightStatsStartDate', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('flightStatsDays')
            ->add('flightStatsReturnLegOffset')
            ->add('investmentDate', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Investment "As of" Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('ukDaysStartDate', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Start Date of UK Days Analysis',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('lastOutlookDownload', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Start Date of UK Days Analysis',
                'required' => false,
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Settings::class,
        ]);
    }
}
