<?php

namespace App\Form\Project_Specific;

use App\Entity\Project_Specific\AssetClasses;
use App\Entity\Project_Specific\FxRates;
use App\Entity\Project_Specific\Investments;
use App\Entity\Project_Specific\MarketData;
use App\Entity\Project_Specific\TaxYear;
use App\Entity\TaxDocuments;
use App\Repository\Project_Specific\FxRatesRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvestmentsType extends AbstractType

{
    public function __construct(FxRatesRepository $fxRatesRepository)
    {
        $this->fxRatesRepository = $fxRatesRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currency = $this->fxRatesRepository->findOneBy([
            'fx' => 'GBP'
        ]);
        if ($options['edit'] == true) {
            $currency = $options['currency'];
        }
        $builder
            ->add('investmentCompany', EntityType::class, [
                'class' => MarketData::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.shareCompany', 'ASC');
                },
                'choice_label' => 'shareCompany',
                'label' => 'Company',
                'required' => false
            ])
            ->add('numberOfShares')
            ->add('initialInvestmentAmountGBP', TextType::class, [
                'label' => 'Initial investment in GBP',
                'required' => false
            ])
            ->add('currency', EntityType::class, [
                'class' => FxRates::class,
                'choice_label' => 'fx',
                'label' => 'Currency',
                'data' => $currency,
                'required' => false
            ])
            ->add('purchaseSharePrice', TextType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('investmentDate', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('investmentAmount')
            ->add('assetClass', EntityType::class, [
                'class' => AssetClasses::class,
                'choice_label' => 'Asset Class',
                'label' => 'Asset Class',
                'required' => true,
                'query_builder'=>function (EntityRepository $er):QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->where('u.includeInStandardInvestmentForm = 1')
                        ->orderBy('u.assetClass', 'ASC');
                },
            ])
            ->add('saleSharePrice')
            ->add('investmentSaleDate', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('shareCert', FileType::class, [
                'label' => 'Share Certificate',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => $options['share_cert']
                ]
            ])
            ->add('eisCert', FileType::class, [
                'label' => 'EIS Form 3',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => $options['eis_cert']
                ]
            ])
            ->add('otherDocs', FileType::class, [
                'label' => 'Other Docs',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => $options['other_docs']
                ]
            ])
            ->add('EISPurchaseYear1', EntityType::class, [
                'class' => TaxYear::class,
                'choice_label' => 'taxYearRange',
                'choice_value' => 'taxYearRange',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.taxYearRange', 'ASC');
                },
                'label' => 'Purchase: Tax Year 1',
                'required' => false,

            ])
            ->add('EISPurchaseYear2', EntityType::class, [
                'class' => TaxYear::class,
                'choice_label' => 'taxYearRange',
                'choice_value' => 'taxYearRange',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.taxYearRange', 'ASC');
                },
                'label' => 'Purchase: Tax Year (LookBack)',
                'required' => false
            ])
            ->add('eISPurchaseYear1Percentage', TextType::class, [
                'label' => '%',
                'required' => false
            ])
            ->add('eISPurchaseYear2Percentage', TextType::class, [
                'label' => '%',
                'required' => false
            ])
            ->add('eISSaleYear1Percentage', TextType::class, [
                'label' => '%',
                'required' => false
            ])
            ->add('eISSaleYear2Percentage', TextType::class, [
                'label' => '%',
                'required' => false
            ])
            ->add('eISSaleYear1', EntityType::class, [
                'class' => TaxYear::class,
                'choice_label' => 'taxYearRange',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.taxYearRange', 'ASC');
                },
                'label' => 'Sale: Tax Year',
                'required' => false
            ])
            ->add('eISSaleYear2', EntityType::class, [
                'class' => TaxYear::class,
                'choice_label' => 'taxYearRange',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.taxYearRange', 'ASC');
                },
                'label' => 'Sale: Tax LookBack',
                'required' => false
            ])
            ->add('crystallisedGainLossInGBP', TextType::class, [
                'label' => 'Crystallised Gain/Loss in GBP',
                'required' => false
            ])
            ->add('lossDeductibleAgainstIncome', TextType::class, [
                'label' => 'Loss Deductible against Income',
                'required' => false
            ])
            ->add('eisPurchaseYear1SelfAssessmentCheck', ChoiceType::class, [
                'multiple' => false,
                'label'=> 'Self Assessment P1',
                'expanded' => false,
                'choices' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'TBC' => 'TBC'
                ],])
            ->add('eisPurchaseYear2SelfAssessmentCheck', ChoiceType::class, [
                'multiple' => false,
                'label'=> 'Self Assessment P2',
                'expanded' => false,
                'choices' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'TBC' => 'TBC'
                ],])
            ->add('eisSaleYear1SelfAssessmentCheck', ChoiceType::class, [
                'multiple' => false,
                'label'=> 'Self Assessment S1',
                'expanded' => false,
                'choices' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'TBC' => 'TBC'
                ],])
            ->add('eisSaleYear2SelfAssessmentCheck', ChoiceType::class, [
                'multiple' => false,
                'label'=> 'Self Assessment S2',
                'expanded' => false,
                'choices' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'TBC' => 'TBC'
                ],])
            ->add('comment');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Investments::class,
            'share_cert' => null,
            'eis_cert' => null,
            'other_docs' => null,
            'currency' => null,
            'edit' => null

        ]);
    }

}
