<?php

namespace App\Form;

use App\Entity\JpmIcHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JpmIcHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('baseSalaryGBP',TextType::class,[
                'label' =>'Base Salary GBP',
                'required'=>false
            ])
            ->add('totalCompUSD',TextType::class,[
                'label' =>'Total compensation USD',
                'required'=>false
            ])
            ->add('icTotal',TextType::class,[
                'label' =>'Total Incentive Compensation USD',
                'required'=>false
            ])
            ->add('icCash',TextType::class,[
                'label' =>'Incentive Compensation in USD Cash',
                'required'=>false
            ])
            ->add('icShares',TextType::class,[
                'label' =>'Incentive Compensation in JPM Shares%',
                'required'=>false
            ])
            ->add('icSharePrice',TextType::class,[
                'label' =>'JPM Share price',
                'required'=>false
            ])
            ->add('icShares1',TextType::class,[
                'label' =>'Number of shares',
                'required'=>false
            ])
            ->add('icShares2',TextType::class,[
                'label' =>'Number of shares',
                'required'=>false
            ])
            ->add('vestingDate1', DateType::class, [
                'label' => 'Vesting Date #1',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('vestingDate2', DateType::class, [
                'label' => 'Vesting Date #2',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('attachmentICFile', FileType::class, [
                'label' => 'JPM IC PDF',
                'mapped' => false,
                'required' => false,
//                'attr' => [
//                    'placeholder' => $options['ic_pdf']
//                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JpmIcHistory::class,
        ]);
    }
}
