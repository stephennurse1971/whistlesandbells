<?php

namespace App\Form;

use App\Entity\TaxDocuments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxDocumentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('p11D',FileType::class,[
                'label'=>'P11D',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('p60',FileType::class,[
                'label'=>'P60',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('selfAssessment',FileType::class,[
                'label'=>'Self Assessment',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('comments')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaxDocuments::class,
        ]);
    }
}
