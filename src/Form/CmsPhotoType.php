<?php

namespace App\Form;

use App\Entity\CmsPhoto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CmsPhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('photoOrVideo', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'Photo' => 'Photo',
                    'Video' => 'Video',
                ],])


            ->add('photo', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'Title (English)'
            ])

            ->add('link');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CmsPhoto::class,
            'allow_extra_fields' => true,
        ]);
    }
}
