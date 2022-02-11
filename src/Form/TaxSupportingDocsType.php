<?php

namespace App\Form;

use App\Entity\TaxDocuments;
use App\Entity\TaxSupportingDocs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
            ->add('attachment')
            ->add('taxYear',EntityType::class,[
                'class'=>TaxDocuments::class,
                'choice_label'=>'year'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaxSupportingDocs::class,
        ]);
    }
}
