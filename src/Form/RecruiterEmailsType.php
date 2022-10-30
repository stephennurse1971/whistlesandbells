<?php

namespace App\Form;

use App\Entity\RecruiterEmails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecruiterEmailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('SendTo')
            ->add('SendCC')
            ->add('SendBcc')
            ->add('subject')
            ->add('body')
            ->add('attachment')
            ->add('SendDate',DateTimeType::class , [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('sendAuthor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RecruiterEmails::class,
        ]);
    }
}
