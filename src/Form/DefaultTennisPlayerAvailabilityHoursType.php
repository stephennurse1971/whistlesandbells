<?php

namespace App\Form;

use App\Entity\DefaultTennisPlayerAvailabilityHours;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DefaultTennisPlayerAvailabilityHoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class, [
                'class' => User::class,
                'choice_label'=>'fullname'
            ])
            ->add('WeekdayOrWeekend',ChoiceType::class,[
                'multiple'=>false,
                'choices'=>[
                    'Weekday'=>'Weekday',
                    'Weekend'=>'Weekend',
                ]
            ])
            ->add('hour')
            ->add('defaultAvailable',ChoiceType::class,[
                'multiple'=>false,
                'choices'=>[
                    'Available'=> 1,
                    'Not available' => 0,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DefaultTennisPlayerAvailabilityHours::class,
        ]);
    }
}
