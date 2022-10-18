<?php

namespace App\Form;

use App\Entity\TaxYear;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaxYear::class,
        ]);
    }
}
