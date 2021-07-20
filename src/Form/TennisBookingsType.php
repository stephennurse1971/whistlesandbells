<?php

namespace App\Form;

use App\Entity\TennisBookings;
use App\Entity\TennisVenues;
use App\Entity\User;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisBookingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker datetime'
                ],
            ])
            ->add('cost')
            ->add('venue', EntityType::class,[
                'class'=> TennisVenues::class,
                'choice_label' => 'venue'
                ])
            ->add('player1',EntityType::class,[
                'class'=> User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->
                        createQueryBuilder('u')
                            ->where('u.roles LIKE :roles')
                            ->setParameter('roles', '%ROLE_TENNIS_PLAYER%')
                             ->orderBy('u.fullName', 'ASC');
                },
                'choice_label'=> 'fullName',
                'required' => false,
                'empty_data' => null,
            ])
            ->add('player2',EntityType::class,[
                'class'=> User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->
                    createQueryBuilder('u')
                        ->where('u.roles LIKE :roles')
                        ->setParameter('roles', '%ROLE_TENNIS_PLAYER%')
                        ->orderBy('u.fullName', 'ASC');
                },
                'choice_label'=> 'fullName',
                'required' => false,
                'empty_data' => null,
            ])
            ->add('player3',EntityType::class,[
                'class'=> User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->
                    createQueryBuilder('u')
                        ->where('u.roles LIKE :roles')
                        ->setParameter('roles', '%ROLE_TENNIS_PLAYER%')
                        ->orderBy('u.fullName', 'ASC');
                },
                'choice_label'=> 'fullName',
                'required' => false,
                'empty_data' => null,
            ])
            ->add('player4',EntityType::class,[
                'class'=> User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->
                    createQueryBuilder('u')
                        ->where('u.roles LIKE :roles')
                        ->setParameter('roles', '%ROLE_TENNIS_PLAYER%')
                        ->orderBy('u.fullName', 'ASC');
                },
                'choice_label'=> 'fullName',
                'required' => false,
                'empty_data' => null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisBookings::class,
        ]);
    }
}
