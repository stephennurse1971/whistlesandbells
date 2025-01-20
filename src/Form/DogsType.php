<?php

namespace App\Form;

use App\Entity\Dogs;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DogsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('owner', EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'fullName'
            ])
            ->add('name')
            ->add('photo')
            ->add('breed')
            ->add('breedChoiceReasons')
            ->add('dogChoiceReasons')
            ->add('dateOfBirth', DateType::class, [
                'label'=>'Date of Birth (approx)',
                'widget' => 'single_text',
            ])
            ->add('gender')
            ->add('neutered')
            ->add('neuteredDate', DateType::class, [
                'label'=>'Date of Neutering (approx)',
                'widget' => 'single_text',
            ])
            ->add('rescueDog')
            ->add('arrivalDate', DateType::class, [
                'label'=>'Date of Arrival (approx)',
                'widget' => 'single_text',
            ])
            ->add('dogFood')
            ->add('dailyMealCount')
            ->add('mealTimes')
            ->add('healthIssues')
            ->add('dogWalkedCount')
            ->add('dogWalkLength');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dogs::class,
        ]);
    }
}
