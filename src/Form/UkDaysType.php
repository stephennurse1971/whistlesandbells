<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\UkDays;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UkDaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label'=>'country'
            ])
            ->add('travel1Description')
            ->add('travel2Description')
            ->add('comment')
            ->add('travelDocs', FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('travelDocs2', FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UkDays::class,
            'allow_extra_fields' => true,
        ]);
    }
}
