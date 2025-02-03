<?php

namespace App\Form;

use App\Entity\Dogs;
use App\Entity\User;
use App\Services\TranslationsWorkerService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DogsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName'
            ])
            ->add('name')
            ->add('photo', FileType::class, [
                'label' => $this->translationsWorker->getTranslations('Photo of dog'),
                'required' => false,
                'data_class' => null,
            ])
            ->add('breed', TextType::class, [
                'label' => $this->translationsWorker->getTranslations('Breed EN'),
                'required' => false
            ])
            ->add('breedChoiceReasons', TextType::class, [
                'label' => $this->translationsWorker->getTranslations('Reasons to choose this breed'),
                'required' => false
            ])
            ->add('dogChoiceReasons', TextType::class, [
                'label' => $this->translationsWorker->getTranslations('Reasons to choose this dog'),
                'required' => false
            ])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'Dogs date of Birth (approx)',
                'widget' => 'single_text',
            ])
            ->add('gender', ChoiceType::class, [
                    'mapped' => true,
                    'label' => $this->translationsWorker->getTranslations('Gender'),
                    'multiple' => false,
                    'expanded' => true,
                    'data' => 'Male',
                    'required' => true,
                    'choices' => [
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ]]
            )
            ->add('neutered', ChoiceType::class, [
                    'mapped' => true,
                    'label' => $this->translationsWorker->getTranslations('Is the dog neutered?'),
                    'multiple' => false,
                    'expanded' => true,
                    'data' => 'No',
                    'required' => true,
                    'choices' => [
                        'Yes' => 'Yes',
                        'No' => 'No',
                    ]]
            )
            ->add('neuteredDate', DateType::class, [
                'label' => 'Date of Neutering (approx)',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('rescueDog', ChoiceType::class, [
                    'mapped' => true,
                    'label' => $this->translationsWorker->getTranslations('Is the dog a rescue dog?'),
                    'multiple' => false,
                    'expanded' => true,
                    'data' => 'No',
                    'required' => true,
                    'choices' => [
                        'Yes' => 'Yes',
                        'No' => 'No',
                    ]]
            )
            ->add('arrivalDate', DateType::class, [
                'label' => 'Date of Arrival (approx)',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dogFood', TextType::class, [
                'label' => $this->translationsWorker->getTranslations('What dog food do you feed the dog?'),
                'required' => false
            ])
            ->add('dailyMealCount', TextType::class, [
                'label' => $this->translationsWorker->getTranslations('How often do you feed the dog?'),
                'required' => false
            ])
            ->add('mealTimes', TextType::class, [
                'label' => $this->translationsWorker->getTranslations('At what meal times?'),
                'required' => false
            ])
            ->add('healthIssues', TextType::class, [
                'label' => $this->translationsWorker->getTranslations('Any health issues?'),
                'required' => false
            ])
            ->add('dogWalkedCount', TextType::class, [
                'label' => $this->translationsWorker->getTranslations('How often do you walk the dog?'),
                'required' => false
            ])
            ->add('dogWalkLength', TextType::class, [
                'label' => $this->translationsWorker->getTranslations('What length of walks?'),
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dogs::class,
        ]);
    }

    public function __construct(TranslationsWorkerService $translationsWorker)
    {
        $this->translationsWorker = $translationsWorker;
    }
}
