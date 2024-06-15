<?php

namespace App\Form;

use App\Entity\CompanyDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName')
            ->add('companyWebsite')

            ->add('faviconLive', FileType::class, [
                'label' => 'Favicon Live',
                'mapped' => false,
                'required' => false
            ])
            ->add('faviconDev', FileType::class, [
                'label' => 'Favicon Dev',
                'mapped' => false,
                'required' => false
            ])
            ->add('companyEmail')
            ->add('companyEmailPassword')
            ->add('companyEmailImportDirectory')
            ->add('companyEmailImportProcessedDirectory')
            ->add('companyTel')
            ->add('companyMobile')
            ->add('companySkype')
            ->add('companyQrCode', FileType::class,[
                'label' => 'QR',
                'mapped' => false,
                'required' => false
            ])
            ->add('companyAddressStreet')
            ->add('companyAddressTown')
            ->add('companyAddressCity')
            ->add('companyAddressPostalCode')
            ->add('companyAddressCountry')
            ->add('companyTimeZone')
            ->add('currency')
            ->add('weatherLocation')
            ->add('companyAddressMapLink')
            ->add('companyAddressLongitude')
            ->add('companyAddressLatitude')
            ->add('companyAddressInstructions')
            ->add('facebook')
            ->add('twitter')
            ->add('instagram')
            ->add('linkedIn')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyDetails::class,
        ]);
    }
}
