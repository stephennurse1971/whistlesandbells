<?php

namespace App\Form;

use App\Entity\Interests;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterestsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('ranking')
            ->add('isActive')
            ->add('isPublic')
            ->add('accessRoles')
            ->add('menu', ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Interests' => 'Interests',
                    'Cyprus' => 'Cyprus',
                ],])
            ->add('cmsText1')
            ->add('cmsText2')
            ->add('cmsText3')
            ->add('cmsPhoto1')
            ->add('cmsPhoto2')
            ->add('cmsPhoto3')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Interests::class,
        ]);
    }
}
