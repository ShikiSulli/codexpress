<?php

namespace App\Controller;

use OpenAI;
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
    ): Response {
        // On créer une requête pour récupérer les snippets
        $query = $snippets->findBy(
            ['isPublished' => true, 'isPublic' => true], // Pour sélectionner les snippets publics et publiés
            ['createdAt' => 'DESC'], // Pour trier
            100 // Pour limiter l'affichage
        );

        // On utilise le paginator pour paginer les snippets
        $pagination = $paginator->paginate(
            $query, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            9 // Nombre de résultats par page
        );

        return $this->render('page/index.html.twig', [
            'snippets' => $pagination
        ]);
    }

    // Route de test pour OpenAI PHP Package
    #[Route('/test', name: 'test')]
    public function openai()
    {
        // On va initialiser la clé API
        $yourApiKey = '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';

        // On va initialiser le client
        $client = OpenAI::client($yourApiKey);

        // On va créer une requête et récupérer le résultat
        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo-16k',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'La capital de la France est ?'
                ],
            ],
        ]);

        // On affiche le résultat
        dd($result['choices'][0]['message']['content']);
    }
}
