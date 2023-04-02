<?php

namespace App\Form;

use App\Entity\TaxInputs;
use App\Entity\TaxYear;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxInputsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', EntityType::class, [
                'class' => TaxYear::class,
                'choice_label' => 'tax_year_range',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.taxYearRange', 'ASC');
                },
            ])
            ->add('employmentEarnings', TextType::class, [
                'label' => 'Employment Earnings'
            ])
            ->add('interestEarnings', TextType::class, [
                'label' => 'Interest Earnings'
            ])
            ->add('otherEarnings', TextType::class, [
                'label' => 'Other Earnings'
            ])
            ->add('taxDeductedAtSource', TextType::class, [
                'label' => 'Tax Deducted At Source'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaxInputs::class,
        ]);
    }
}
