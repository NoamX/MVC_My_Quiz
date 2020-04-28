<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use App\Repository\CategorieRepository;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        // echo '<pre>';
        // var_dump($reponse);
        // echo '</pre>';

        // foreach ($question as $value1) {
        //     echo $value1->getQuestion() . '<br>';
        // }
        foreach ($reponse as $value2) {
            echo $value2->getReponse() . ' ';
        }

        return $this->render('quiz/question.html.twig', [
            'question' => $question,
            // 'reponse' => $reponse,
        ]);
    }
}
