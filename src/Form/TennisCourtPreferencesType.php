<?php

namespace App\Form;

use App\Entity\TennisCourtPreferences;
use App\Entity\TennisVenues;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisCourtPreferencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class, [
                'class' => User::class,
                'choice_label'=> 'fullName'
            ])
            ->add('tennisVenue', EntityType::class, [
                'class'=> TennisVenues::class,
                'choice_label'=> 'venue'
            ])
            ->add('weekdayElection',ChoiceType::class,[
                'expanded'=>true,
                'choices'=>[
                    'Yes'=>'1',
                    'No'=>'0'
                ],
                'mapped'=>false
            ])
            ->add('weekendElection',ChoiceType::class,[
                'expanded'=>true,
                'choices'=>[
                    'Yes'=>'1',
                    'No'=>'0'
                ],
                'mapped'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisCourtPreferences::class,
        ]);
    }
}
