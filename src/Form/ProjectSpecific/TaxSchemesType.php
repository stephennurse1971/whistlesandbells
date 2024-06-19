<?php

namespace App\Form\ProjectSpecific;

use App\Entity\ProjectSpecific\TaxSchemes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxSchemesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('purchaseIncomeOffset')
            ->add('purchaseTaxOffset')
            ->add('saleIncomeOffset')
            ->add('saleTaxOffset')
            ->add('cgtRate')
            ->add('includeTaxSummary')
            ->add('showSharePrices')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaxSchemes::class,
        ]);
    }
}
