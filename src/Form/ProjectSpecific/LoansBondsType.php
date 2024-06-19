<?php

namespace App\Form\ProjectSpecific;

use App\Entity\ProjectSpecific\LoansBonds;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoansBondsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('currency', ChoiceType::class, [
                'multiple' => false,
                'required' =>true,
                'expanded' => false,
                'choices' => [
                    'GBP' => 'GBP',
                    'EUR' => 'EUR',
                    'USD' => 'USD',
                    'CHF' => 'CHF'
                ],])
            ->add('category', ChoiceType::class, [
                'multiple' => false,
                'label' => 'Category',
                'required' =>false,
                'expanded' => false,
                'choices' => [
                    'Bank Deposit' => 'Bank Deposit',
                    'SME Loan' => 'SME Loan',
                    'Pref Shares' => 'Pref Shares',
                    'EBT 1998' => 'EBT 1998',
                    'EBT 2007' => 'EBT 2007',
                    'EFRB 2010' => 'EFRB 2010',
                ],])
            ->add('notional')
            ->add('interestRate')
            ->add('drawdownDate', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Drawdown Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('repaymentDate', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Repayment Date',
                'required' => false,
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LoansBonds::class,
        ]);
    }
}
