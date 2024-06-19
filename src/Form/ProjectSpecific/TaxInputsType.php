<?php

namespace App\Form\ProjectSpecific;

use App\Entity\ProjectSpecific\TaxInputs;
use App\Entity\ProjectSpecific\TaxYear;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ])
            ->add('p11D',FileType::class,[
                'label'=>'P11D',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('p60',FileType::class,[
                'label'=>'P60',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('p45',FileType::class,[
                'label'=>'P45',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('selfAssessment',FileType::class,[
                'label'=>'Self Assessment',
                'mapped'=>false,
                'required'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaxInputs::class,
            'p11d_file_name' => null,
            'p60_file_name' => null,
            'p45_file_name' => null,
            'selfAssessment_file_name' => null,
            'allow_extra_fields' => true,
        ]);
    }
}
