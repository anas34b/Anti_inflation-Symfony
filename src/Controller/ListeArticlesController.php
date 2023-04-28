<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ListesType;
use App\Entity\ListeArticles;
use App\Form\AjoutarticlelisteType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ListeArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListeArticlesController extends AbstractController
{
    #[Route('/', name: 'listes')]
    public function index(ListeArticlesRepository $repository  ): Response
    {
        $listes = $repository->findAll();
        return $this->render('liste_articles/ListeArticles.html.twig', [
            'listes' => $listes,
        ]);
    }
    #[Route('/liste/AjoutListe', name: 'ListeAjout')]
    public function listeAjout(Request $request, EntityManagerInterface $om): Response
    {
        $liste= new ListeArticles() ;
        $form = $this->createForm(ListesType::class,$liste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om->persist($liste);
            $om->flush();
            $this->addFlash("success","l'ajout a été effectuée");
            return $this->redirectToRoute("listes");
        }
        return $this->render('liste_articles/ListesAjout.html.twig', [
            "form"=> $form->createView()
        ]);
    }

    #[Route('/liste/{id}', name: 'afficherliste')]
    public function afficherListe( ListeArticles $liste,ArticlesRepository $repository ): Response
    {
        $relation= $liste->getRelation();
        $totale= $liste->getTotalPrixListe();
        $comptage= $liste->compterArticles($liste);
        $articlechere= $liste->articlesChers($liste);
        $articlepaschere= $liste->articlePasChers($liste);
        return $this->render('liste_articles/afficherListe.html.twig',[
            "liste" =>$liste,
            "relation" => $relation,
            "totale" => $totale,
            "articlechere" => $articlechere,
            "articlepaschere" => $articlepaschere,
            "comptage"=> $comptage
        ]);
    }

    #[Route('/liste/ajout/{id}', name: 'Ajoutarticleliste')]
    public function Ajoutarticleliste( ListeArticles $liste, Request $request, EntityManagerInterface $om, ListeArticlesRepository $rp ): Response
    {
        $form = $this->createForm(AjoutarticlelisteType::class, $liste);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articles = $form->get('relation')->getData();
            foreach ($articles as $article) {
            $liste->addRelation($article);
            $article->addListeArticle($liste);   
            $rp->save($liste);
            }
        $om->flush();
            return $this->redirectToRoute('afficherliste', ['id' => $liste->getId()]);
        }
        return $this->render('liste_articles/ajoutarticleliste.html.twig', [
            'form' => $form->createView(),
            'liste' =>$liste
        ]);
    }

    #[Route('/liste/ajout/{id}/{articleId}', name: 'Supprimerarticleliste')]
    public function Supprimerarticleliste(ListeArticles $liste,int $articleId/*Articles $article*/, EntityManagerInterface $om ): Response
    {
        $article = $om->getRepository(Articles::class)->find($articleId);
        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }
        $liste->removeRelation($article);
        $om->flush();
        return $this->redirectToRoute('afficherliste', ['id' => $liste->getId()]);
        }
    
    
}
