<?php

namespace App\Form;

use App\Entity\HouseGuests;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HouseGuestsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add('guestName', EntityType::class,[
                'class' => User::class,
                'choice_label'=> 'fullName',
                'choices' => $this->userRepository->findByRole('ROLE_GUEST')
                ])
            ->add('dateArrival', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Arrival date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('dateDeparture', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Departure date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('notes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HouseGuests::class,
        ]);
    }
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
