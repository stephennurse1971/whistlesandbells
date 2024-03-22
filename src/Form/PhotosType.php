<?php

namespace App\Form;

use App\Entity\PhotoLocations;
use App\Entity\Photos;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location', EntityType::class, [
                'class' => PhotoLocations::class,
                'choice_label' => 'location',
                'required' => false,
                'empty_data' => null,
                'data' => $options['location']
            ])
            ->add('photos', FileType::class, [
                'multiple' => true,
                'mapped' => false
            ])
            ->add('uploadedBy', EntityType::class, [
                'class' => User::class,
                'required' => false,
                'choice_label'=>'fullName'
            ])
            ->add('priority')
            ->add('date',DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker datetime'
                ],
            ])
            ->add('email')
            ->add('favourites', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photos::class,
            'location' => null,
          //  'allow_extra_fields' => true,
        ]);
    }
}
