<?php

namespace App\Form;

use App\Entity\TaxDocuments;
use App\Entity\TaxSupportingDocs;
use App\Entity\TaxYear;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxSupportingDocsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateTimeType::class,[
                'widget'=>'single_text',
                'attr'=>[
                    'class'=>'datetime'
                ]
            ])
            ->add('comments')
            ->add('detailedComments')
            ->add('attachment',FileType::class,[
                'label'=>'Attachments',
                'mapped'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>$options['tax_supporting_doc']
                ]
            ])
            ->add('taxYear',EntityType::class,[
                'class'=>TaxYear::class,
                'choice_label'=>'taxYearRange'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaxSupportingDocs::class,
            'tax_supporting_doc'=>null,
            'allow_extra_fields' => true,
        ]);
    }
}
