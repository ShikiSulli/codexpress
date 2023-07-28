<?php

namespace App\Controller;

use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(Request $request): Response
    {
        $token = $this->$request->request->get('stripeToken');
        Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        Charge::create ([
                "amount" => 10 * 100,
                "currency" => "eur",
                "source" => $token,
                "description" => "Abonnement CodeXpress"
        ]);
        $this->addFlash(
            'success',
            'Paiement validé'
        );
        return $this->redirectToRoute('app_page', [], Response::HTTP_SEE_OTHER);
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
}
