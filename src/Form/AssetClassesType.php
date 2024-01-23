<?php

namespace App\Form;

use App\Entity\AssetClasses;
use App\Entity\TaxSchemes;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetClassesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assetClass')
            ->add('taxScheme', EntityType::class, [
                'class' => TaxSchemes::class,
                'choice_label' => 'name',
                'required' => true,
                'empty_data' => null,
            ])
            ->add('includeInStandardInvestmentForm')
            ->add('showDocs')
            ->add('showInvestmentPurchaseAndSaleDates')
            ->add('updatedPriceAvailable')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AssetClasses::class,
        ]);
    }
}
