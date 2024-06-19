<?php

namespace App\Form\ProjectSpecific;

use App\Entity\ProjectSpecific\FxRates;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FxRatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fx')
            ->add('currentFxRate')
            ->add('reciprocal')
            ->add('liveRateLink')
            ->add('updatedDate', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FxRates::class,
        ]);
    }
}
