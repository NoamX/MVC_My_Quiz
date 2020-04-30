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
            'id' => $id,
        ]);
    }

    /**
     * @Route("/reponse/{id}", name="reponse", methods={"GET", "POST"})
     */
    public function checkReponse(QuestionRepository $questionRepository, ReponseRepository $reponseRepository, Request $request, $id)
    {
        foreach ($request->request as $key => $value) {
            $req[$key] = trim(stripslashes(htmlspecialchars($value)));
        }

        $reponse = $reponseRepository->findBy(['id_question' => $id]);

        $question = $questionRepository->findBy(['id_categorie' => $id]);
        $reponse = [];
        foreach ($question as $value) {
            $reponse[$value->getId()] = $reponseRepository->findBy(['id_question' => $value->getId()]);
        }

        // echo '<pre>';
        // var_dump($reponse);
        // echo '</pre>';

        foreach ($reponse as $value) {
            foreach ($value as $reponse) {
                if ($reponse->getReponseExpected()) {
                    echo $reponse->getReponse();
                    echo ' - ';
                    echo $reponse->getReponseExpected();
                    echo '<br>';
                }
            }
        }

        return $this->render('quiz/reponse.html.twig', [
            'request' => $req,
        ]);
    }
}
