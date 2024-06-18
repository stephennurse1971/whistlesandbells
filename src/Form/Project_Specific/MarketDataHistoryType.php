<?php

namespace App\Form\Project_Specific;

use App\Entity\Project_Specific\MarketData;
use App\Entity\Project_Specific\MarketDataHistory;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarketDataHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['mode']=='new'){
            $builder
                ->add('date', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'label' => 'Date',
                    'required' => false,
                    'widget' => 'single_text',
                    'data'=>new \DateTime($options['date'])
                ])
                ->add('marketPrice')
                ->add('security', EntityType::class, [
                    'class' => MarketData::class,
                    'choice_label' => 'shareCompany',
                    'choices'=>$options['securities'],
                    'data'=>$options['security']
                ])
            ;
        }
        else{
            $builder
                ->add('date', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'label' => 'Date',
                    'required' => false,
                    'widget' => 'single_text',
                ])
                ->add('marketPrice')
                ->add('security', EntityType::class, [
                    'class' => MarketData::class,
                    'choice_label' => 'shareCompany',
                    'required' => false,
                    'query_builder' => function (EntityRepository $er): \Doctrine\ORM\QueryBuilder {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.shareCompany', 'ASC');
                    },
                ])
            ;
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MarketDataHistory::class,
            'securities'=>null,
            'security'=>null,
            'date'=>null,
            'mode'=>null
        ]);
    }
}
