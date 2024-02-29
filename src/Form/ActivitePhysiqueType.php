<?php

namespace App\Form;

use App\Entity\ActivitePhysique;
use App\Entity\Objectif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitePhysiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder    
            ->add('Duree_Activite')
            ->add('Calories_Brules')
            ->add('Nb_Series')
            ->add('Nb_Rep_Series')
            ->add('Poids_Par_Serie') ;     
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActivitePhysique::class,
        ]);
    }
}
