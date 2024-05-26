<?php

namespace App\Form;

use App\Entity\UsefulLinks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsefulLinksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category',ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'ATS' => 'ATS',
                    'Finance' => 'Finance',
                    'Health' => 'Health',
                    'Cyprus Estate Agent' => 'Cyprus Estate Agent',
                    'Other Estate Agent' => 'Other Estate Agent',
                    'Shopping' => 'Shopping',
                    'Gwenny' => 'Gwenny',
                    'AX' => 'AX',
                    'IT' => 'IT',
                    'Recruitment' => 'Recruitment',
                    'RT'=>'RT'
                ],])
            ->add('name')
            ->add('link')
            ->add('login')
            ->add('password')
            ->add('notes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UsefulLinks::class,
        ]);
    }
}
