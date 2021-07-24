<?php

namespace App\Form;

use App\Entity\CreditCardDetails;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditCardDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('thLogin')
            ->add('thPassword')
            ->add('firstName')
            ->add('lastName')
            ->add('cardType')
            ->add('cardExpiry')
            ->add('cardExpiry2')
            ->add('cardCVC')
            ->add('address1')
            ->add('address2')
            ->add('town')
            ->add('county')
            ->add('postCode')
            ->add('postCode')
            ->add('telephone')


            ->add('cardholder',EntityType::class,[
                'class' => User::class,
                'choice_label'=> 'fullName'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreditCardDetails::class,
        ]);
    }
}
