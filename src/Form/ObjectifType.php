<?php

namespace App\Form;

use App\Entity\ActivitePhysique;
use App\Entity\Objectif;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        ->add('Nom_Objectif', ChoiceType::class, [
            'choices' => [
                'Perte de poids' => 'perte de poids',
                'Renforcement musculaire' => 'renforcement musculaire',
                'Amélioration endurance'=>'amelioration endurance',
                'Réduction du stress'=>'reduction du stress',
                'Augmentation de la masse musculaire'=>'augmentation de la masse musculaire',
                "Maintien de la forme physique"=>"maintien de la forme physique",
            ]])
            ->add('Date_objectif', DateTimeType::class, [
                'widget' => 'single_text', // You can customize the widget according to your preference
                ])
            ->add('Total_Calories')
            ->add('Total_Duree')
            ->add('Note')
            ->add('Activites', EntityType::class, [
                'class' => ActivitePhysique::class,
                'choice_label' => function ($activite) {
                    return $activite->getId() . ' - ' . $activite->getNomActivite(); // Modify this according to your Objectif entity properties
                }, // Assuming "nom" is the property to display for objectives/ Assuming "nom" is the property to display for objectives
                'multiple' => true,
                'expanded' => true, // Render checkboxes instead of a select input
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objectif::class,
        ]);
    }
}
