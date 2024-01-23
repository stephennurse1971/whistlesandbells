<?php

namespace App\Form;

use App\Entity\FxRatesHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FxRatesHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('EUR_FX_Rate', TextType::class, [
                'label' => 'EUR FX Rate (to USD)'
            ])
            ->add('GBP_FX_Rate', TextType::class, [
                'label' => 'GBP FX Rate (to USD)'
            ])
            ->add('CHF_FX_Rate', TextType::class, [
                'label' => 'CHF FX Rate (to USD)'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FxRatesHistory::class,
        ]);
    }
}
