<?php

namespace App\Form;

use App\Entity\FxRates;
use App\Entity\Investments;
use App\Entity\MarketData;
use App\Entity\TaxDocuments;
use App\Entity\TaxSchemes;
use App\Entity\TaxYear;
use App\Repository\FxRatesRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

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
            ->add('purchaseSharePrice')
            ->add('investmentDate', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetime'
                ],
                'html5'=>false,
                'format'=>'d-m-Y'
            ])
            ->add('investmentAmount')
            ->add('taxScheme', EntityType::class, [
                'class' => TaxSchemes::class,
                'choice_label' => 'name',
                'choice_value'=>'name',
                'label' => 'Tax Scheme',
                'required' => true
            ])
            ->add('investmentSoldPrice')
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
                'choice_value'=>'taxYearRange',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.taxYearRange', 'ASC');
                },
                'label' => 'Purchase: Tax Year 1',
                'required' => false
            ])
            ->add('EISPurchaseYear2', EntityType::class, [
                'class' => TaxYear::class,
                'choice_label' => 'taxYearRange',
                'choice_value'=>'taxYearRange',
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
            ]);
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
