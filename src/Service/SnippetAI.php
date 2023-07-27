<?php

namespace App\Service;

use OpenAI;

class SnippetAI
{
    public function explain($snippet) {
        // On va initialiser la clé API
        $yourApiKey = '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';

        // On initialise le client
        $client = OpenAI::client($yourApiKey);

        // On initialise le préprompt
        $prePrompt = 'Tu agis comme un assistant d\'aide à la programmation pour une application appelée CodeXpress. Les utilisateurs disposent d\'une fonction permettant de comprendre le code d\'une page. Réponds en commençant toujours par "Le code suivant signifie :". Voici le code à expliquer : '; 
        
        // On va créer une requête et récupérer le résultat
        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo-16k',
            'messages' => [
                // On concatène le préprompt et le snippet qui est passé en paramètre
                ['role' => 'user', 'content' => $prePrompt . $snippet,],
            ],
        ]);

        // On va retourner le résultat
        return $result['choices'][0]['message']['content'];
    }
}

