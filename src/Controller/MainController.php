<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('main/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    /**
     * @Route("/article/{id}", name="article")
     */
    public function article(Article $article, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        // $user = $userRepository->find(1);
        $user = $this->getUser();

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $commentaire = $form->getData();
            $commentaire->setDate(new DateTime());
            $commentaire->setArticle($article);
            $commentaire->setUser($user);
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('article', ['id' => $article->getId()]);
        }

        return $this->render('main/article.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}
