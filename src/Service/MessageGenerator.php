<?php


namespace App\Service;


use App\Repository\ArticleRepository;
use Psr\Log\LoggerInterface;

class MessageGenerator
{
    private $aRepository;
    private $logger;
    private $logEnabled;
    /**
    * MessageGenerator contructor.
    */
    public function __construct(ArticleRepository $articleRepository, LoggerInterface $logger, $logEnabled){
        $this->logEnabled = $logEnabled;
        $this->logger = $logger;
        $this->aRepository = $articleRepository;
    }


    public function getMessage() {
       $messages = [
            "Salut à tous",
            "Hello World",
            "Bonjour"
       ];
       $message = $messages[rand(0,2)];
       if ($this->logEnabled) {
            $this->logger->notice("un message a été généré: '$message'");
       }
       return $message;
    }

    public function getLastArticleTitle() {
        $titles=[];
        $articles = $this->aRepository->getPublishedArticles();
        foreach($articles as $article) {
            $titles[] = $article->getTitle();
        }
        return $titles;
    }
}
