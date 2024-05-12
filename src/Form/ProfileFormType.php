<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Validator\Constraints\UniqueEmail;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('profileImage', FileType::class, [
                'mapped' => false,
                'required' => False,
               
            ])
            ->add('name', TextType::class)
            ->add('lastName')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
                'placeholder' => 'Select your gender',

            ])
            ->add('birthDay', BirthdayType::class, [
                'widget' => 'single_text',
            ],)
            ->add('address')

            ->add('phoneNumber')
            ->add('email');
        $builder->get('profileImage')
        ->addModelTransformer(new class implements DataTransformerInterface
        {
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
            'data_class' => User::class,
            'constraints' => [
                new UniqueEntity(fields: ['email'], message: "This email is already in use."),
            ],
        ]);
    }
}
