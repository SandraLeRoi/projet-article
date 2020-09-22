<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleCrudController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_index")
     */
    public function index(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();
        return $this->render('article_crud/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/create", name="article_create")
     */
    public function create(Request $request) {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            //le formulaire a été envoyé et est valide
            //je veux sauvegarder mon utilisateur
            $em = $this-> getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            dump($article);
            return $this->redirectToRoute("article_read",["article"=>$article->getId()]);
        }

        return $this ->render("article_crud/create.html.twig", [
            "articleForm"=> $form->createView()
        ]);
    }

    /**
     * @Route("/articles/{article}", name="article_read")
     */
    public function read(Article $article) {
        return $this->render("article_crud/read.html.twig", [
            "article" => $article,
        ]);
    }

    /**
     * @Route("/articles/{article}/update", name="article_update")
     */
    public function update(Article $article, Request $request) {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        dump($article);
        if($form->isSubmitted()&&$form->isValid()){
            //le formulaire a été envoyé et est valide
            //je veux sauvegarder mon utilisateur
            $em = $this-> getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("article_read",["article"=>$article->getId()]);
        }
        return $this ->render("article_crud/update.html.twig", [
            "articleForm"=> $form->createView()
        ]);
    }

    /**
     * @Route("/articles/{article}/delete", name="article_delete")
     */
    public function delete (Article $article) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("articles_index");
    }
}
