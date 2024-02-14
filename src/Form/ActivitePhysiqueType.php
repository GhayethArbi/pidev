<?php

namespace App\Form;

use App\Entity\ActivitePhysique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitePhysiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom_activite')
            ->add('typeActivite', ChoiceType::class, [
                'choices' => [
                    'Cardiovasculaire' => 'cardiovasculaire',
                    'Musculation' => 'musculation',
                ]])
            ->add('calories_brules')
            ->add('duree_activite')
            ->add('nb_serie')
            ->add('nb_rep_serie')
            ->add('poids_par_serie')
            ->add('objectif')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActivitePhysique::class,
        ]);
    }
}
