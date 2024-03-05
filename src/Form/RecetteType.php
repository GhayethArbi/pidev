<?php

namespace App\Form;

use App\Entity\Recette;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;


class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Name'
            ])
                     
            ->add('category', ChoiceType::class,[
                'label' => 'category',
                'choices'=> [
                    'Breakfast'=> 'Breakfast',
                    'Lunch'=>'Lunch',
                    'Dinner'=>'Dinner',
                    'Snacks'=>'Snacks',
                ],
                'placeholder' => 'Choose an option',
                'required' => true,
            ])
            ->add('description',TextType::class,[
                'label' => 'Description'
            ]);

            if (!$options['exclude_date_field']) {
                $builder->add('date');
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
            'exclude_date_field' => false,
        ]);
    }
}
