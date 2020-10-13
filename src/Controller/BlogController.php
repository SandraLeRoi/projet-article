<?php

namespace App\Controller;

use App\Form\ResearchType;
use App\Repository\ArticleRepository;
use App\Service\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository, MessageGenerator $messageGenerator)
    {
        $message = $messageGenerator->getMessage();
        $titles = $messageGenerator->getLastArticleTitle();
        $articles = $articleRepository->getThisYearArticles();
        return $this->render('blog/index.html.twig.html.twig', [
            'articles' => $articles,
            "message" => $message,
            "title" => $titles
        ]);
    }

    /**
     * @Route("/search", name="blog_search")
     */
    public function search(Request $request, ArticleRepository $articleRepository) {
        $form = $this->createForm(ResearchType::class, null, ["method"=>"GET"]);
        $form ->handleRequest($request);
        //dump($request->query->get("search"));
        //dump($form->get("search")->getData());
        //dump($form->getData());
        $userSearch = $form->get("search")->getData();
        $order = $form->get("order")->getData();
        $articles = $articleRepository->searchArticles($userSearch, $order);
        return $this -> render("blog/search.html.twig",[
            "SearchForm" => $form->createView(),
            "articles" => $articles
        ]);
    }
}
