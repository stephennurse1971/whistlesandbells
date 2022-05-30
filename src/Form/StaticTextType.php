<?php

namespace App\Form;

use App\Entity\StaticText;
use Symfony\Component\Form\AbstractType;
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
            ->add('homepage1')
            ->add('homepage2')
            ->add('aboutSN')
            ->add('webDesign')
            ->add('emailFamily')
            ->add('emailAccountant')
            ->add('emailContact')
            ->add('emailGuest')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StaticText::class,
        ]);
    }
}
