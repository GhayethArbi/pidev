<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('currentPassword', PasswordType::class,[
        'constraints' => [
            new Assert\Length([
                'min' => 8,
                'minMessage' => 'Your password must be at least {{ limit }} characters long.',
            ]),],])
        ->add('password', PasswordType::class,[
            'constraints' => [
                new Assert\Length([
                    'min' => 8,
                    'minMessage' => 'Your password must be at least {{ limit }} characters long.',
                ]),],
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => ['label' => 'New Password'],
            'second_options' => ['label' => 'Confirm Password'],
            'constraints' => [
                new Assert\Length([
                    'min' => 8,
                    'minMessage' => 'Your password must be at least {{ limit }} characters long.',
                ]),],
            
        ])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
