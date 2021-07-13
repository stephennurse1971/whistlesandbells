<?php

namespace App\Form;

use App\Entity\Payments;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker datetime'
                ],
            ])
            ->add('amount')
            ->add('user', EntityType::class,[
                'class' => User::class,
                'choice_label' => 'fullName'
               ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payments::class,
        ]);
    }
}
