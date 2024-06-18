<?php

namespace App\Form\Project_Specific;

use App\Entity\Project_Specific\AssetClasses;
use App\Entity\Project_Specific\MarketData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarketDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shareCompany')
            ->add('isActive')
            ->add('companiesHouse')
            ->add('weblink')
            ->add('login')
            ->add('password')
            ->add('investorSite')
            ->add('assetClass', EntityType::class, [
                'class' => AssetClasses::class,
                'choice_label' => 'assetClass',
                'label' => 'Asset Class',
                'required' => false
            ])
            ->add('comment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MarketData::class,
        ]);
    }
}
