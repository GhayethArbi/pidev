<?php

namespace App\Form;

use App\Entity\FeedBack;
use App\Entity\Produitfitness;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire')
            ->add('dateAvis')
            ->add('Evaluation')
            ->add('ref')
            ->add('ref',EntityType::class,[
                'class' => Produitfitness::class,
                'choice_label' =>function(Produitfitness $refp){
                
                    return sprintf('%s', $refp->getReferenceP());
                },

                'expanded' => false,
                'multiple' =>false
            ])
            
        

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeedBack::class,
        ]);
    }
}
