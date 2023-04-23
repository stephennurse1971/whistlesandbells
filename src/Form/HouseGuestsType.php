<?php

namespace App\Form;

use App\Entity\HouseGuests;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HouseGuestsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder
            ->add('guestName', EntityType::class,[
                'class' => User::class,
                'choice_label'=> 'fullName',
                'choices' => $options['user_list']
                ])

            ->add('dateDeparture', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Departure date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('notes',TextareaType::class,[
                'required'=>false
            ])
            ->add('arrivalNotes',TextareaType::class,[
                'required'=>false
            ])
            ->add('departureNotes',TextareaType::class,[
                'required'=>false
            ])
            ->add('dateArrival', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Arrival date',
                'required' => false,
                'widget' => 'single_text',

            ])
            ->add('flightFromLondon')
            ->add('flightToLondon')

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HouseGuests::class,
            'user_list'=>null,

        ]);
    }

}
