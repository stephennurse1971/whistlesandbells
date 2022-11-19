<?php

namespace App\Form;

use App\Entity\StaticText;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaticTextType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mobileNumber')
            ->add('emailAddress')
            ->add('skype')
            ->add('address')
            ->add('gpsCoordinates')
            ->add('linkedIn')
            ->add('companiesHouseLink')
            ->add('github')
            ->add('facebookLink')
            ->add('twitter')
            ->add('baseCurrency', ChoiceType::class, [
                'multiple' => false,
                'choices' => [
                    'USD' => 'USD',
                    'GBP' => 'GBP',
                    'CHF' => 'CHF',
                    'EUR' => 'EUR'
                ]])
            ->add('photo1', FileType::class, [
                'label' => 'Photo1',
                'mapped' => false,
                'required' => false
            ])
            ->add('photo2', FileType::class, [
                'label' => 'Photo2',
                'mapped' => false,
                'required' => false
            ])
            ->add('photo3', FileType::class, [
                'label' => 'Photo3',
                'mapped' => false,
                'required' => false
            ])
            ->add('photo4', FileType::class, [
                'label' => 'Photo4',
                'mapped' => false,
                'required' => false
            ])
            ->add('photo5', FileType::class, [
                'label' => 'Photo5',
                'mapped' => false,
                'required' => false
            ])
            ->add('photo6', FileType::class, [
                'label' => 'Photo6',
                'mapped' => false,
                'required' => false
            ])
            ->add('photo7', FileType::class, [
                'label' => 'Photo7',
                'mapped' => false,
                'required' => false
            ])
            ->add('photo8', FileType::class, [
                'label' => 'Photo8',
                'mapped' => false,
                'required' => false
            ])
            ->add('photo9', FileType::class, [
                'label' => 'Photo9',
                'mapped' => false,
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StaticText::class,
        ]);
    }
}
