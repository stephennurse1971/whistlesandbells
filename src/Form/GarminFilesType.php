<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\GarminFiles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarminFilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'country',
                'required' => true,
                'empty_data' => null,
            ])
            ->add('startingPoint')
            ->add('kilometres')
            ->add('climb')
            ->add('description')
            ->add('gpxFile', FileType::class, [
                'label' => 'GPX File',
                'mapped' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GarminFiles::class,
        ]);
    }
}
