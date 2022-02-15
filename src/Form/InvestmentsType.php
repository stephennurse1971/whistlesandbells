<?php

namespace App\Form;

use App\Entity\Investments;
use App\Entity\TaxDocuments;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvestmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('investmentName')
            ->add('investmentDate', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('investmentAmount')
            ->add('investmentEIS', CheckboxType::class, [
                'label' => 'Is the investment EIS?',
                'required' => false
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
            ->add('eISPurchaseYear1', EntityType::class,[
                'class'=>TaxDocuments::class,
                'choice_label'=>'Year',
                'label' => 'EIS Purchase Tax Year 1',
                'required' => false
            ])
            ->add('eISPurchaseYear2', EntityType::class,[
                'class'=>TaxDocuments::class,
                'choice_label'=>'Year',
                'label' => 'EIS Purchase Tax Year 2',
                'required' => false
            ])
            ->add('eISPurchaseYear1Percentage',TextType::class,[
                'label' =>'%'
            ])
            ->add('eISPurchaseYear2Percentage',TextType::class,[
                'label' =>'%'
            ])

            ->add('eISSaleYear1', EntityType::class,[
                'class'=>TaxDocuments::class,
                'choice_label'=>'Year',
                'label' => 'EIS Sale Tax Year',
                'required' => false
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Investments::class,
            'share_cert' => null,
            'eis_cert' => null,
            'other_docs' => null

        ]);
    }
}
