<?php

namespace App\Form;

use App\Entity\Investments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'label' =>'EIS',
            ])
            ->add('investmentSoldPrice')
            ->add('investmentSaleDate', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('shareCert', TextType::class, [
                'label' =>'Share certificate',
            ])
            ->add('eisCert', TextType::class, [
                'label' =>'EIS Form 3 certificate',
            ])
            ->add('otherDocs', TextType::class, [
                'label' =>'Other Docs',
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
