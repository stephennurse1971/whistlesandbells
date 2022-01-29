<?php

namespace App\Form;

use App\Entity\Investments;
use Symfony\Component\Form\AbstractType;
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
            ->add('investmentEIS', TextType::class, [
                'label' =>'Is the investment EIS?',
            ])
            ->add('investmentSoldPrice')
            ->add('investmentSaleDate', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('shareCert',FileType::class,[
                'label'=>'Share Certificate',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('eisCert',FileType::class,[
                'label'=>'EIS Form 3',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('otherDocs',FileType::class,[
                'label'=>'Other Docs',
                'mapped'=>false,
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Investments::class,
        ]);
    }
}
