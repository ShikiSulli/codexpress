<?php

namespace App\Controller;
use App\Entity\Snippet;
use App\Service\SnippetAI;
use App\Form\SnippetAIType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Georgehadjisavva\ElevenLabsClient\TextToSpeech;
use Georgehadjisavva\ElevenLabsClient\ElevenLabsClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

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



            // si GPT3.5 a repondu alors on fait le text to speech avec elevenlabs

            if($explication)
            {
                
                  
        $api = "https://api.elevenlabs.io/v1/text-to-speech/CYw3kZ02Hs0563khs1Fj/stream?optimize_streaming_latency=0&output_format=mp3_44100_128";
        $key = $this->getParameter('ELEVEN_API_KEY');
        $text = $explication;
        $headers = [
        'accept: */*',
        'xi-api-key: ' . $key,
        'Content-Type: application/json'
        ];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $api);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
            'text' => $text,
            'model_id' => 'eleven_multilingual_v1',
            'voice_settings' => [
            'stability' => 0,
            'similarity_boost' => 0,
            'style' => 0,
            'use_speaker_boost' => true
            ]
            ]));


            curl_exec($curl);

            if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
            }
            curl_close($curl);


            dd($curl);




                $audio='';
                
                // On affiche le résultat dans le template twig
    
                return $this->render('snippet/snippet.html.twig', [
                    'snippet' => $snippet,
                    'SnippetAI' => $form,
                    'Explication' => $explication, // Cette variable contient la réponse de l'IA
                    'audio' => $eleven->voices()->getVoice('fr-FR-Wavenet-A'),
                    
                ]);
            }
        
            }


        return $this->render('snippet/snippet.html.twig', [
            'snippet' => $snippet,
            'SnippetAI' => $form,
            'Explication' => '',
            'audio' => '',
        ]);
    }
}
