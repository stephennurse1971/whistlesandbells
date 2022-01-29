<?php

namespace App\Form;

use App\Entity\ChaveyDown;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChaveyDownType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('vendor', TextType::class, [
                'label' =>'Supplier/contractor',
            ])
            ->add('amount')
            ->add('serpentimeComments', TextType::class, [
                'label' =>'Developer comments',
                'required' => false
            ])
            ->add('hmrcComments',TextType::class, [
                'label' =>'HMRC comments',
                'required' => false
            ])
            ->add('attachments',FileType::class,[
                'label'=>'Document',
                'mapped'=>false,
                'required'=>false,
                'multiple'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChaveyDown::class,
        ]);
    }
}
