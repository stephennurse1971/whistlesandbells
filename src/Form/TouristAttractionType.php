<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\TouristAttraction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TouristAttractionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('full_name')
            ->add('mobile')
            ->add('email2')
            ->add('firstName')
            ->add('lastName')
            ->add('company')
            ->add('businessPhone')
            ->add('webPage')
            ->add('notes')
            ->add('photo')
            ->add('businessStreet')
            ->add('businessCity')
            ->add('businessPostCode')
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'country',
                'required' => true,
                'empty_data' => null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TouristAttraction::class,
        ]);
    }
}
