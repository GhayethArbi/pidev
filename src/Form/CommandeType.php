<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modeDePaiement', ChoiceType::class, [
                'label' => 'Mode de paiement',
                'choices' => [
                    'Cash' => 'cash',
                    'Credit Card' => 'credit_card',
                    // Add other payment modes as needed
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
            ])
            // You may add more fields here according to your requirements
            ->add('save', SubmitType::class, [
                'label' => 'Valider la commande',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
