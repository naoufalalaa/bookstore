<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Form\SearchLivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/livre')]
class LivreController extends AbstractController
{
    #[Route('/', name: 'livre_index')]
    public function index(LivreRepository $livreRepository,Request $req): Response
    {
        $qb = $livreRepository->getPaginatedLivres($req->query->get("page",1));
        $form = $this->createForm(SearchLivreType::class);
        
        $search = $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){

            $qb = $livreRepository->createQueryBuilder('l')
                             ->where('l.titre LIKE :titre')
                             ->setParameter('titre','%'.$search->get('titre')->getData().'%')
                             ->getQuery()->getResult();
        }

        
            
        return $this->render('livre/index.html.twig', [
            'livres' => $qb,
            'search' => $form->createView(),
            'totalLivres' => $livreRepository->countLivres()
        ]);
    }
    // #[Route('/', name: 'livre_index')]
    // public function seachByTitle(Request $request, LivreRepository $livreRepository): Response
    // {
    //     $livres = $livreRepository->findAll();

    //     $form = $this->createForm(SearchLivreType::class);
        
    //     $search = $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()){

    //         $livres = $livreRepository->search(
    //             $search->get('titre')->getData(),
    //         );
    //     }

    //     return $this->render('livre/index.html.twig', [
    //         'livres' => $livres,
    //         'search' => $form->createView()
    //     ]);
    // }
    #[Route('/new', name: 'livre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();
            $this->addFlash(
                'Success',
                'Your book was added successfully !'
            );
            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'livre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'Success',
                'Your book was updated successfully !'
            );
            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'livre_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
            $this->addFlash(
                'Warning',
                'This Book had been deleted successfully !'
            );
        }

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }
}
