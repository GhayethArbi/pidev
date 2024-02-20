<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TitreE')
            ->add('Date_DebutE')
            ->add('StatusE', ChoiceType::class, [
                'choices'  => [
                    'Status' => null,
                    'En cours' => true,
                    'Terminé' => false,
                ],
                
                ])
            
            ->add('Date_fin_E')
            ->add('Localisation_E')
            ->add('Description_E')
            ->add('Nbr_max_P')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
