<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CategorieRepository $repository)
    {
        $categorie = $repository->findAll();

        return $this->render('base.html.twig', [
            'user' => $this->getUser(),
            'categorie' => $categorie,
        ]);
    }

    /**
     * @Route("/question/{id}", name="question")
     */
    public function showQuestion(QuestionRepository $questionRepository, ReponseRepository $reponseRepository, $id)
    {
        $question = $questionRepository->findBy(['id_categorie' => $id]);

        $reponse = [];
        foreach ($question as $value) {
            $reponse[$value->getId()] = $reponseRepository->findBy(['id_question' => $value->getId()]);
        }

        return $this->render('quiz/question.html.twig', [
            'question' => $question,
            'reponse' => $reponse,
        ]);
    }

    /**
     * @Route("/reponse", name="reponse", methods={"GET", "POST"})
     */
    public function checkReponse(Request $request)
    {
        foreach ($request->request as $key => $value) {
            $req[$key] = trim(stripslashes(htmlspecialchars($value)));
        }

        return $this->render('quiz/reponse.html.twig', [
            'request' => $req,
        ]);
    }
}
