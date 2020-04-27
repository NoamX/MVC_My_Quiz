<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $categorie = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();
        return $this->render('base.html.twig', [
            'user' => $this->getUser(),
            'categorie' => $categorie,
        ]);
    }
}
