<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
    }

    /**
     * @Route("/register", name="register")
     */
    public function register_form()
    {
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('name', TextType::class, ['required' => true, 'label' => 'Nom :'])
            ->add('email', EmailType::class, ['required' => true, 'label' => 'Email :'])
            ->add('password', PasswordType::class, ['required' => true, 'label' => 'Mot de passe :'])
            ->add('submit', SubmitType::class, ['label' => 'S\'inscrire'])
            ->getForm();
        return $this->render('user/register.html.twig', ['user' => $form->createView()]);
    }
}
