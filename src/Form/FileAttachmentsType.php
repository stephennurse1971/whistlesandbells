<?php

namespace App\Form;

use App\Entity\FileAttachments;

use App\Repository\FileAttachmentsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileAttachmentsType extends AbstractType
{
    public function __construct()
    {
      //  $this->chaveyDownRepository = $chaveyDownRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('attachments',FileType::class,[
                'label'=>'Document',
                'mapped'=>false,
                'required'=>false,
                'multiple'=>true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FileAttachments::class,
            'id'=>null
        ]);
    }
}
