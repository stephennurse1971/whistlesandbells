<?php

namespace App\Form;

use App\Entity\Flying;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlyingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('instructor',ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Paul Jones' => 'Paul Jones',
                    'George Theodosiou' => 'George Theodosiou'
                ],])
            ->add('aircraft')
            ->add('hots')
            ->add('price')
            ->add('paymentMade')
            ->add('description')
            ->add('lessonsLearnt');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Flying::class,
        ]);
    }
}
