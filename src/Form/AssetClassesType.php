<?php

namespace App\Form;

use App\Entity\AssetClasses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetClassesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assetClass')
            ->add('showTaxYearDetails')
            ->add('showSharePrices')
            ->add('showDocs')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AssetClasses::class,
        ]);
    }
}
