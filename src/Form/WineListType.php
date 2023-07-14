<?php

namespace App\Form;

use App\Entity\WineList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WineListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('year')
            ->add('colour', ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Red' => 'Red',
                    'White' => 'White',
                    'Rose' => 'Rose'
                ],])
            ->add('grape')
            ->add('labelPicture', FileType::class, [
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('description')
            ->add('price')
            ->add('marks')
            ->add('supermarket', ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Papantoniou' => 'Papantoniou',
                    'Tsiakouris' => 'Tsiakouris',
                    'Village' => 'Village'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WineList::class,
            'allow_extra_fields' => true,
        ]);
    }
}
