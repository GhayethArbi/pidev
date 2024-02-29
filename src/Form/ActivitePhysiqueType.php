<?php

namespace App\Form;

use App\Entity\ActivitePhysique;
use App\Entity\Objectif;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitePhysiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom_Activite')
            ->add('Type_Activite', ChoiceType::class, [
                'choices' => [
                    'Cardiovasculaire' => 'cardiovasculaire',
                    'Musculation' => 'musculation',
                ]])
            ->add('Duree_Activite')
            ->add('Calories_Brules')
            ->add('Nb_Series')
            ->add('Nb_Rep_Series')
            ->add('Poids_Par_Serie')
            ->add('Image_Activite', FileType::class, [
                'mapped' => false,
                'label' => 'Image activité',
                'required' => False,
            ])
            ->add('objectifs', EntityType::class, [
                'class' => Objectif::class,
                'choice_label' => function ($objectif) {
                    return $objectif->getId() . ' - ' . $objectif->getNomObjectif(); // Modify this according to your Objectif entity properties
                }, // Assuming "nom" is the property to display for objectives
                'multiple' => true,
                'expanded' => true, // Render checkboxes instead of a select input
            ]);
          $builder->get('Image_Activite')->addModelTransformer(new class implements DataTransformerInterface {
                public function transform($value)
                {
                    // Transform the File object into a string path
                    if ($value instanceof File) {
                        return $value->getPathname();
                    }
                    return null;
                }
    
                public function reverseTransform($value)
                {
                    // Transform the string path into a File object
                    if ($value instanceof UploadedFile) {
                        return $value;
                    }
                    return null;
                }
            });
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActivitePhysique::class,
        ]);
    }
}
