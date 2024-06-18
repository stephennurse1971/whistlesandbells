<?php

namespace App\Form\Project_Specific;

use App\Entity\Project_Specific\Country;
use App\Entity\Project_Specific\GarminFiles;
use App\Entity\Project_Specific\User;
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
            ->add('endPoint')
            ->add('kilometres')
            ->add('climb')
            ->add('description')
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null,
            ])
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
            'allow_extra_fields' => true,
        ]);
    }
}
