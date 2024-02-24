<?php

namespace App\Form;

use App\Entity\Objectif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ObjectifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date_objectif', DateTimeType::class, [
                'widget' => 'single_text', // You can customize the widget according to your preference
            ])
            ->add('note')
            ->add('total_duree')
            ->add('total_calories')
            ->add('NomObjectif', ChoiceType::class, [
                'choices' => [
                    'Perte de poids' => 'perte de poids',
                    'Renforcement musculaire' => 'renforcement musculaire',
                    'Amélioration endurance'=>'amelioration endurance',
                    'Réduction du stress'=>'reduction du stress',
                    'Augmentation de la masse musculaire'=>'augmentation de la masse musculaire',
                    "Maintien de la forme physique"=>"maintien de la forme physique",
                ]])
               
                ;   
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objectif::class,
        ]);
    }
}
