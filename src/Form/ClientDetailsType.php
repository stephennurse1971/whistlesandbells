<?php

namespace App\Form;

use App\Entity\ClientDetails;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'fullName'
            ])
            ->add('addressStreet')
            ->add('addressTown')
            ->add('addressCounty')
            ->add('addressPostCode')
            ->add('addresslongitude')
            ->add('addresslatitude')
            ->add('mobile')
            ->add('childrenInHome')
            ->add('communicationVerbally')
            ->add('communicationEmail')
            ->add('communicationWhatsApp')
            ->add('communicationWhatsAppGroup')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClientDetails::class,
        ]);
    }
}
