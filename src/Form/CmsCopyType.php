<?php

namespace App\Form;

use App\Entity\CmsCopy;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CmsCopyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('sitePage', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'HomePage' => 'HomePage',
                    'AboutSN' => 'AboutSN',
                    'Risk & Capital Consulting' => 'Risk & Capital Consulting',
                    'PrivateEquity' => 'PrivateEquity',
                    'WebDesign' => 'WebDesign',
                    'Flying' => 'Flying',
                    'Tennis' => 'Tennis',
                    'Cyprus' => 'Cyprus',
                    'Introduction Email - Family' => 'Introduction Email - Family',
                    'Introduction Email - Contact' => 'Introduction Email - Contact',
                    'Introduction Email - Guest' => 'Introduction Email - Guest',
                    'Introduction Email - Job Applicant' => 'Introduction Email - Job Applicant',
                    'Introduction Email - Recruiter' => 'Introduction Email - Recruiter',

                ],])
            ->add('contentTitle', TextType::class, [
                'required' => false,
                'label' => 'Title (English)'
            ])
            ->add('contentText', TextareaType::class, [
                'required' => false,
                'label' => 'Content (English)'
            ])
            ->add('contentTitleFR', TextType::class, [
                'required' => false,
                'label' => 'Title (French)'])
            ->add('contentTextFR', TextareaType::class, [
                'required' => false,
                'label' => 'Content (French)'
            ])
            ->add('contentTitleDE', TextType::class, [
                'required' => false,
                'label' => 'Title (German)'])
            ->add('contentTextDE', TextareaType::class, [
                'required' => false,
                'label' => 'Content (German)'
            ])
            ->add('hyperlinks');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CmsCopy::class,
        ]);
    }
}
