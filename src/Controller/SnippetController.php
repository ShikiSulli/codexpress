<?php

namespace App\Controller;

use App\Entity\Snippet;
use App\Form\SnippetAIType;
use App\Service\SnippetAI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SnippetController extends AbstractController
{
    #[Route('/snippet/{id}', name: 'show_code')]
    public function index(
        Snippet $snippet, 
        Request $request,
    ): Response
    {
        $form = $this->createForm(SnippetAIType::class);
        // On récupère les données du formulaire
        $form->handleRequest($request);
        // On vérifie que le formulaire est soumis et valide
        if($form->isSubmitted() && $form->isValid()) {
            // On le code pour l'envoyer à l'IA
            $data = $form->getData('code');
            // On envoie les données à l'IA et elle renvoie une explication
            $explication = SnippetAI::explain($data);
            // On affiche le résultat dans le template twig
            return $this->render('snippet/snippet.html.twig', [
                'snippet' => $snippet,
                'SnippetAI' => $form,
                'Explication' => $explication, // Cette variable contient la réponse de l'IA
            ]);
        }

        return $this->render('snippet/snippet.html.twig', [
            'snippet' => $snippet,
            'SnippetAI' => $form,
            'Explication' => '',
        ]);
    }
}
