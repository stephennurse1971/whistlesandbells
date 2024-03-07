<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\TouristAttraction;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TouristAttractionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('full_name')
            ->add('mobile')
            ->add('email2')
            ->add('firstName')
            ->add('lastName')
            ->add('company')
            ->add('type', ChoiceType::class, [
                'multiple' => false,
                'required' =>true,
                'expanded' => false,
                'choices' => [
                    'Beach' => 'Beach',
                    'Historical interest' => 'Historical interest',
                    'Hotel' => 'Hotel',
                    'Restaurant' => 'Restaurant',
                    'Cafe' => 'Cafe',
                    'Sport venue' => 'Sport venue',
                    'Cycling Stop' => 'Cycling Stop',
                    'Shop' => 'Shop',
                    'Taxi'=>'Taxi',
                    'TBD'=>'TBD',
                ],])
            ->add('businessPhone')
            ->add('webPage')
            ->add('notes')
            ->add('photo', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false
            ])
            ->add('businessStreet')
            ->add('businessCity')
            ->add('businessPostCode')
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'country',
                'data'=>$this->countryRepository->findOneBy([
                    'country'=>'Cyprus'
                ]),
                'required' => false,
                'empty_data' => null,
            ])
            ->add('gpsLocation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TouristAttraction::class,
            'allow_extra_fields' => true,
        ]);
    }

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository=$countryRepository;
    }
}
