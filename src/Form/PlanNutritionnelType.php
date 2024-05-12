<?php

namespace App\Form;
use App\Entity\Recette;
use App\Entity\PlanNutritionnel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PlanNutritionnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class)
            ->add('date')
            ->add('recettes', EntityType::class, [
                'class' => Recette ::class,
                'choice_label' => 'name', 
                'placeholder' => 'Choisir une recette',
                'multiple' => false, 
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlanNutritionnel::class,
        ]);
    }
}