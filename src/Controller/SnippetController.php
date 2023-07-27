<?php

namespace App\Controller;

use App\Entity\Snippet;
use App\Form\SnippetAIType;
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
        return $this->render('snippet/snippet.html.twig', [
            'snippet' => $snippet,
            'SnippetAI' => $form,
        ]);
    }
}
