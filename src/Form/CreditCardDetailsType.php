<?php

namespace App\Form;

use App\Entity\CreditCardDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditCardDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardNumber')
            ->add('cardExpiry')
            ->add('cardCVC')
            ->add('cardholder')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreditCardDetails::class,
        ]);
    }
}
