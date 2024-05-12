<?php
// src/Form/ProductType.php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
$builder
->add('name', TextType::class, [
'constraints' => [
new Assert\Regex([
'pattern' => '/^[a-zA-Z\s]*$/',
'message' => 'Le nom ne peut contenir que des lettres et des espaces.'
]),
new Assert\Length([
'max' => 12,
'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
]),
],
])
->add('slug', TextType::class, [
'constraints' => [
new Assert\Regex([
'pattern' => '/^[a-zA-Z0-9-]+$/',
'message' => 'Le slug ne peut contenir que des lettres, des chiffres et des tirets.'
]),
],
'required' => false, // We'll set it manually
'disabled' => true,  // Disable the slug field
])
->add('illustrationFile', FileType::class, [
'mapped' => false, // This tells Symfony not to try to map this field to any entity property
'label' => 'Illustration (Image file)',
'required' => false,
])
->add('subtitle', TextType::class, [
'constraints' => [
new Assert\Regex([
'pattern' => '/^[a-zA-Z\s]*$/',
'message' => 'Le nom ne peut contenir que des lettres et des espaces.'
]),
new Assert\Length([
'max' => 12,
'maxMessage' => 'Le sous-titre ne peut pas dépasser {{ limit }} caractères.',
]),
],
])
->add('description', TextareaType::class, [
'label' => 'Description',
])
->add('price', MoneyType::class, [
'label' => 'Price',
'currency' => 'USD', // or any other currency you want to use
])
->add('quantite', TextType::class, [
'label' => 'Quantity',
'attr' => [
'maxlength' => 3, // Maximum length of 3 characters
'oninput' => 'this.value = this.value.replace(/[^0-9]/g, \'\').substring(0, 3);', // Allow only numbers and limit to 3 characters
'onkeyup' => 'if(parseInt(this.value) >= 100) { this.blur(); }', // Disable keyboard input when value reaches 100
],
'constraints' => [
new Assert\LessThanOrEqual([
'value' => 100,
'message' => 'La quantité ne peut pas dépasser 100.',
]),
],
])
->add('category');
}

public function configureOptions(OptionsResolver $resolver): void
{
$resolver->setDefaults([
'data_class' => Product::class,
]);
}
}
