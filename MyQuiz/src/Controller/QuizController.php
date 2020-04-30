<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
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

        $question = $questionRepository->findBy(['id_categorie' => $id]);
        $reponse = [];
        foreach ($question as $value) {
            $reponse[$value->getId()] = $reponseRepository->findBy(['id_question' => $value->getId()]);
        }

        foreach ($reponse as $value) {
            foreach ($value as $reponse) {
                if ($reponse->getReponseExpected()) {
                    $rep[] = $reponse->getReponse();
                }
            }
        }

        echo '<pre>';
        echo 'Reponse Utilisateur :<br>';
        print_r($req);
        echo 'Reponse Attendue :<br>';
        print_r($rep);
        $res = array_diff($req, $rep);
        print_r($res);
        echo '</pre>';

        return $this->render('quiz/reponse.html.twig', [
            'request' => $req,
        ]);
    }
}
