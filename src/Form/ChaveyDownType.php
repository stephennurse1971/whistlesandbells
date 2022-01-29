<?php

namespace App\Form;

use App\Entity\ChaveyDown;

use App\Repository\ChaveyDownRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChaveyDownType extends AbstractType
{
    public function __construct(ChaveyDownRepository $chaveyDownRepository)
    {
        $this->chaveyDownRepository = $chaveyDownRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $placeholder='';
        if($options['id']) {
            $chaveyDown = $this->chaveyDownRepository->find($options['id']);
            $attachments = $chaveyDown->getAttachments();
            $fileName = '';
            $count = 1;
            foreach ($attachments as $attachment) {
                $fileName = $fileName . $attachment;
                if ($count < count($attachments)) {
                    $fileName = $fileName . ", ";
                }
                $count++;
            }
            $placeholder = $fileName;
        }
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
                'multiple'=>true,
                'attr'=>[
                    'placeholder'=> $placeholder
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChaveyDown::class,
            'id'=>null
        ]);
    }
}
