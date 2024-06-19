<?php

namespace App\Form\ProjectSpecific;

use App\Entity\ProjectSpecific\CodingTimesheets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodingTimesheetsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('startTimeProposed', TimeType::class, [
                'label' => 'Start Time  (Proposed)',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('endTimeProposed', TimeType::class, [
                'label' => 'End Time  (Proposed)',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('startTimeActual', TimeType::class, [
                'label' => 'Start Time  (Actual)',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('endTimeActual', TimeType::class, [
                'label' => 'End Time  (Actual)',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('additionalHours')
            ->add('notesSN', TextType::class,[
                'label' => 'Notes - SN'
            ])
            ->add('notesAdmin', TextType::class,[
                'label' => 'Notes - Aman'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CodingTimesheets::class,
        ]);
    }
}
