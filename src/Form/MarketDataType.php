<?php

namespace App\Form;

use App\Entity\MarketData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarketDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sharePrice')
            ->add('shareCompany')
            ->add('companiesHouse')
            ->add('weblink')
//            ->add('assetClass', ChoiceType::class, [
//                'choices' => [
//                    'Pubs' => 'Pubs',
//                    'Storage' => 'Storage',
//                    'EIS' => 'EIS',
//                    'Pension' => 'Pension',
//                    'Shares' => 'Shares',
//                    'Bank Account' => 'Bank Account',
//                    'EBT' => 'EBT',
//                    'Loans' => 'Loans'
//                ]
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MarketData::class,
        ]);
    }
}
