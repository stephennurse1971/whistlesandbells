<?php

namespace App\Form;

use App\Entity\TaxYear;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxYearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taxYearRange')
            ->add('start_date',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('end_date',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('taxBand1PersonalAllowance', NumberType::class, [
                'label' => 'Tax Band 1 (Personal Allowance)'
            ])
            ->add('taxBand2BasicRate', NumberType::class, [
                'label' => 'Tax Band 2 (Basic Rate)'
            ])
            ->add('taxBand3HigherRate', NumberType::class, [
                'label' => 'Tax Band 3 (Higher Rate)'
            ])
            ->add('taxBand1Rate', NumberType::class, [
                'label' => 'Tax Band 1 Rate'
            ])
            ->add('taxBand2Rate', NumberType::class, [
                'label' => 'Tax Band 2 Rate'
            ])
            ->add('taxBand3Rate', NumberType::class, [
                'label' => 'Tax Band 3 Rate'
            ])
            ->add('taxBand4Rate', NumberType::class, [
                'label' => 'Tax Band 4 Rate'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaxYear::class,
        ]);
    }
}
