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
            ->add('shareCompany')
            ->add('cashInstrument')
            ->add('sharePrice')
            ->add('companiesHouse')
            ->add('weblink')
            ->add('login')
            ->add('password')
            ->add('investorSite')
            ->add('assetClass', ChoiceType::class, [
                'choices' => [
                    'Pubs' => 'Pubs',
                    'Storage' => 'Storage',
                    'EIS' => 'EIS',
                    'Pension' => 'Pension',
                    'Shares' => 'Shares',
                    'Bank Account' => 'Bank Account',
                    'EBT' => 'EBT',
                    'Loans' => 'Loans'
                ]
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
