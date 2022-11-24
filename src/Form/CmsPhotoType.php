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
            ->add('sitePage', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'HomePage' => 'HomePage',
                    'AboutSN' => 'AboutSN',
                    'Portfolio Career' => 'Portfolio Career',
                    'WebDesign' => 'WebDesign',
                    'Tennis' => 'Tennis',
                    'Flying' => 'Flying',
                    'Cyprus' => 'Cyprus',
                    'Volunteering' => 'Volunteering',
                ],])
            ->add('heading')
            ->add('photo', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'Title (English)'
            ])
            ->add('titleFR', TextType::class, [
                'required' => false,
                'label' => 'Title (French)'
            ])
            ->add('titleDE', TextType::class, [
                'required' => false,
                'label' => 'Title (German)'
            ])
            ->add('link');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CmsPhoto::class,
        ]);
    }
}
