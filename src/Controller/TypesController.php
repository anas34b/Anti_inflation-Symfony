<?php

namespace App\Controller;
use App\Entity\Types;
use App\Form\TypesType;
use App\Repository\TypesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypesController extends AbstractController
{
    #[Route('/types', name: 'types')]
    public function index(TypesRepository $repository): Response
    {
        $types = $repository->findAll();
        return $this->render('types/types.html.twig', [
            'types' => $types,
        ]);
    }

    #[Route('/ajoutTypes', name: 'ajoutTypes')]
    public function ajoutType(Request $request, EntityManagerInterface $om ): Response
    {
        $type= new Types();
        $form = $this->createForm(TypesType::class,$type);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om->persist($type);
            $om->flush();
            $this->addFlash("success","l'ajout a été effectuée");
            return $this->redirectToRoute("types");
        }
        return $this->render('types/typesajout.html.twig', [
            "form"=> $form->createView()
        ]);
    }

    #[Route('/ajoutTypes/{id}', name: 'Supprimertype')]
    public function Supprimertype(Types $type, EntityManagerInterface $om ): Response
    {
        $om->remove($type);
        $om->flush();

        $this->addFlash('success', 'Le type a été supprimé avec succès.');

        return $this->redirectToRoute('Types');
    }
}
