<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SnippetController extends AbstractController
{
    #[Route('/snippet', name: 'app_snippet')]
    public function index(): Response
    {
        return $this->render('snippet/index.html.twig', [
            'controller_name' => 'SnippetController',
        ]);
    }
}
