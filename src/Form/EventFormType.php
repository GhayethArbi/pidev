<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('image', FileType::class, [
                'label' => ' (des fichiers image uniquement)',
    
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
    
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
    
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/gif',
                            'application/jpeg',
                            'application/jpg',
                            'application/png',
                            'application/PNG',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide',
                    ])
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
