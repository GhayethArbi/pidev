<?php

namespace App\Form;
use App\Entity\Event;
use App\Entity\Tickets;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('number')
            ->add('nomx')
            ->add('nomx',EntityType::class,[
              'class' => Event ::class,
              'choice_label' =>function(Event $nomx){
              
               return sprintf('%s',$nomx->getTitreE());
                  
                  
              },
  
              'expanded' => false,
              'multiple' =>false
          ])
          ->add('image', FileType::class, [
            'label' => 'image du tickets (des fichiers image uniquement)',

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
            'data_class' => Tickets::class,
        ]);
    }
}
