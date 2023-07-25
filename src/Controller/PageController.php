<?php

namespace App\Controller;

use App\Repository\SnippetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    // Route de la page d'accueil
    #[Route('/', name: 'app_page')]
    public function index(
        SnippetRepository $snippets, // Chargement du repository Snippet
        PaginatorInterface $paginator, // Chargement de PaginatorInterface
        Request $request // Chargement de Request
    ): Response
    {
        // On créer une requête pour récupérer les snippets
        $query = $snippets->findBy(
            ['isPublished' => true], // Pour sélectionner
            ['createdAt' => 'DESC'], // Pour trier
            100 // Pour limiter l'affichage
        );

        // On utilise le paginator pour paginer les snippets
        $pagination = $paginator->paginate(
            $query, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            10 // Nombre de résultats par page
        );
        
        return $this->render('page/index.html.twig', [
            'snippets' => $pagination
        ]);
    }
}
