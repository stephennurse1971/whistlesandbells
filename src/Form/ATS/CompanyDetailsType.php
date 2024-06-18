<?php

namespace App\Form\ATS;

use App\Entity\ATS\CompanyDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName')
//            ->add('contactFirstName')
//            ->add('contactLastName')
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
                'label' => 'QR Code',
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
