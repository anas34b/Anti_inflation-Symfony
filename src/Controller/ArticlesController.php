<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Summary of ArticlesController
 */
class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'articles')]
    public function index(ArticlesRepository $repository): Response
    {
        $aricles = $repository->findAll();
        return $this->render('articles/articles.html.twig', [
            'articles' => $aricles,
        ]);
    }

    #[Route('/articles/ajoutArticle', name: 'ajoutArticle')]
    public function ajoutArticle(Request $request, EntityManagerInterface $om ): Response
    {
        $article= new Articles() ;
        $form = $this->createForm(ArticlesType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om->persist($article);
            $om->flush();
            $this->addFlash("success","l'ajout a été effectuée");
            return $this->redirectToRoute("articles");
        }
        return $this->render('articles/ajoutArticle.html.twig', [
            "form"=> $form->createView()
        ]);
    }
    #[Route('/articles/ajoutArticle/{id}', name: 'suppArticle')]
    public function suppArticle( Articles $article , EntityManagerInterface $om ): Response
    {
        $om->remove($article);
        $om->flush();

        $this->addFlash('success', 'L\'article a été supprimé avec succès.');

        return $this->redirectToRoute('articles');
    }
    
}
