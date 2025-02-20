<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
// use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Validator\Constraints\IsTrue;
// use Symfony\Component\Validator\Constraints\Length;
// use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'required' => true,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe (8 caractères minimum)',
                'attr' => ['minlength' => 8],
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
            ]);
        // $builder
        //     ->add('name')
        //     ->add('email')
        //     ->add('password', PasswordType::class, [
        //         // instead of being set onto the object directly,
        //         // this is read and encoded in the controller
        //         'mapped' => false,
        //         'constraints' => [
        //             new NotBlank([
        //                 'message' => 'Please enter a password',
        //             ]),
        //             new Length([
        //                 'min' => 6,
        //                 'minMessage' => 'Your password should be at least {{ limit }} characters',
        //                 // max length allowed by Symfony for security reasons
        //                 'max' => 4096,
        //             ]),
        //         ],
        //     ])
        //     ->add('submit', SubmitType::class, [
        //         'label' => 'S\'inscrire',
        //     ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
