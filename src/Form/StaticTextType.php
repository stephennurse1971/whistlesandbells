<?php

namespace App\Form;

use App\Entity\StaticText;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('gpsImage')
            ->add('linkedIn')
            ->add('companiesHouseLink')
            ->add('github')
            ->add('facebookLink')
            ->add('twitter')
            ->add('cv', FileType::class, [
                'multiple' => false,
                'mapped' => false,
                'required'=>false
            ])
            ->add('baseCurrency', ChoiceType::class, [
                'multiple' => false,
                'choices' => [
                    'USD' => 'USD',
                    'GBP' => 'GBP',
                    'CHF' => 'CHF',
                    'EUR' => 'EUR'
                ]])
            ->add('lastOutlookDownload', DateType::class, [
                'label' => 'Last Outlook Downland',
                'required' => false,
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StaticText::class,
        ]);
    }
}
