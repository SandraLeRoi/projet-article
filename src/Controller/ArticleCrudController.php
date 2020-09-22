<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleCrudController extends AbstractController
{
    /**
     * @Route("/article/crud", name="article_crud")
     */
    public function index()
    {
        return $this->render('article_crud/index.html.twig', [
            'controller_name' => 'ArticleCrudController',
        ]);
    }
}
