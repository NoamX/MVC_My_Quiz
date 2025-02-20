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
    public function index(CategorieRepository $categorieRepository)
    {
        $categorie = $categorieRepository->findAll();

        return $this->render('base.html.twig', [
            'user' => $this->getUser(),
            'categorie' => $categorie,
        ]);
    }

    /**
     * @Route("/quiz/question/{id}", name="question")
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
     * @Route("/quiz/reponse/{id}", name="reponse", methods={"GET", "POST"})
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

        $res = array_diff($req, $rep);
        $res2 = array_diff($rep, $req);

        foreach ($res as $key => $value) {
            $test[] = $questionRepository->findBy(['id' => $key]);
        }

        $abc = [];
        foreach ($test as $value) {
            foreach ($value as $q) {
                $abc[] = $q;
            }
        }

        $total = count($question) - count($res);

        return $this->render('quiz/reponse.html.twig', [
            'request' => $req,
            'question' => $abc,
            'bad_reponse' => $res,
            'reponse_expected' => $res2,
            'nbrQuestion' => count($question),
            'total' => $total,
        ]);
    }

    /**
     * @Route("quiz/create", name="quiz_create")
     */
    public function createQuiz(CategorieRepository $categorieRepository, Request $request)
    {
        $categories = $categorieRepository->findAll();

        foreach ($request->request as $key => $value) {
            echo "$key => $value<br>";
        }

        return $this->render('quiz/create.html.twig', [
            'categories' => $categories,
        ]);
    }
}
