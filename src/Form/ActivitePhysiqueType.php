<?php

namespace App\Form;

use App\Entity\ActivitePhysique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            ->add('Image_Activite', FileType::class, [
                'label' => 'Image activité',
                'required' => false,
            ])
            ->add('objectif') ;
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
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActivitePhysique::class,
        ]);
    }
}
