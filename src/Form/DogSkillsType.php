<?php

namespace App\Form;

use App\Entity\DogSkills;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DogSkillsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ranking')
            ->add('skillOrBehaviour', ChoiceType::class, [
                'multiple' => false,
                'label' => 'Skill Or Behaviour',
                'expanded' => FALSE,
                'required' => false,
                'choices' => [
                    'Skill' => 'Skill',
                    'Behaviour' => 'Behaviour',
                ],
            ])
            ->add('description')
            ->add('notes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DogSkills::class,
        ]);
    }
}
