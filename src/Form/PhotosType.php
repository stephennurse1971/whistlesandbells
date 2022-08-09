<?php

namespace App\Form;

use App\Entity\PhotoLocations;
use App\Entity\Photos;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker datetime'
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => PhotoLocations::class,
                'choice_label' => 'location',
                'required' => false,
                'empty_data' => null,
            ])
            ->add('photos', FileType::class, [
                'multiple' => true,
                'mapped' => false
            ])
            ->add('person', EntityType::class, [
                'class' => User::class,
                'query_builder'=> function (EntityRepository $er) {
                   return $er->createQueryBuilder('u')
                           -> where('u.roles LIKE :role')
                           ->setParameter('role', "%ROLE_GUEST%")
                           ->orderBy('u.fullName', 'ASC')
                    ;

                },
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null,
                'multiple'=>true
            ])
            ->add('description')
            ->add('public');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photos::class,
        ]);
    }
}
