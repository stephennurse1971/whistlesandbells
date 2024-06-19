<?php

namespace App\Form\ProjectSpecific;

use App\Entity\ProjectSpecific\RecruiterEmails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecruiterEmailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('SendToFullName', TextType::class, [
                'label' => 'To (Name)'
            ])
            ->add('SendTo', TextType::class, [
                'label' => 'To (Email)'
            ])
            ->add('SendCCFullName', TextType::class, [
                'label' => 'cc (Name)',
                'required' => false
            ])
            ->add('SendCC', TextType::class, [
                'label' => 'cc (Name)',
                'required' => false
            ])
            ->add('SendBccFullName', TextType::class, [
                'label' => 'bcc (Email)'
            ])
            ->add('SendBcc', TextType::class, [
                'label' => 'bcc (Name)'
            ])
            ->add('subject')
            ->add('body',TextareaType::class)
            ->add('attachment')
            ->add('SendDate', DateTimeType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('AuthorFullName', TextType::class, [
                'label' => 'Sender (Name)'
            ])
            ->add('Author', TextType::class, [
                'label' => 'Sender (Email)'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RecruiterEmails::class,
        ]);
    }
}
