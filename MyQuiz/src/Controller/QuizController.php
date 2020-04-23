<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        // Affichage des quiz sur la page d'accueil (à faire)
        return $this->render('base.html.twig');
    }
}
