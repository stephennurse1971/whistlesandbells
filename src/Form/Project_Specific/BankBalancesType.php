<?php

namespace App\Form\Project_Specific;

use App\Entity\Project_Specific\BankAccounts;
use App\Entity\Project_Specific\BankBalances;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BankBalancesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bank', EntityType::class, [
                'class' => BankAccounts::class,
                'choice_label' => 'bank',
                'required' => true,
                'empty_data' => null,
            ])
            ->add('date', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('BalanceGbp',NumberType::class,[
              'label'=>'GBP Balance'
            ])
            ->add('BalanceUsd',NumberType::class,[
                'label'=>'USD Balance'
            ])
            ->add('BalanceEur',NumberType::class,[
                'label'=>'EUR Balance'
            ])
            ->add('BalanceChf',NumberType::class,[
                'label'=>'CHF Balance'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BankBalances::class,
        ]);
    }
}
