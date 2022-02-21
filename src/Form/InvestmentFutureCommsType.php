<?php

namespace App\Form;

use App\Entity\InvestmentFutureComms;
use App\Entity\Investments;
use App\Entity\MarketData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvestmentFutureCommsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('attachment',FileType::class,[
                'label'=>'Document',
                'mapped'=>false,
                'required'=>false,
                'multiple'=>true,
//                'attr'=>[
//                    'placeholder'=> $placeholder
//                ]
            ])
            ->add('comment')
//            ->add('investment', EntityType::class, [
//                'class' => Investments::class,
//                'choice_label' => 'investmentCompany',
//                'data' => $options['investment']
//            ]);
        ->add('marketData',EntityType::class,[
            'class'=>MarketData::class,
                'choice_label'=>'shareCompany',
                'data'=>$options['marketData']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InvestmentFutureComms::class,
           // 'investment' => null,
            'marketData'=>null
        ]);
    }
}
