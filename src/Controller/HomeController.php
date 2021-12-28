<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $req, AuteurRepository $auteurRepository,LivreRepository $livreRepository,GenreRepository $genreRepository): Response
    {
        $livre = $livreRepository->getPaginatedLivres($req->query->get("pageLivre",1));

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'auteurs' => $auteurRepository->findAll(),
            'livres' => $livre,
            'genres' => $genreRepository->findAll(),
            'totalLivre' => $livreRepository->countLivres()
        ]);
    }
}
