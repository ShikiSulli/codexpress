import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

//Fetch
//paramarage de la requete
const options ={
    method: 'POST',
    headers: {
        'accept': '*/*',
        'xi-api-key': '6d09526d3b429be353755ad64699a25c',
        'content-type': 'application/json',
    },
    body: JSON.stringify(body),
}

//initialisation du body pour la requete
let body = {
'text' : $text,
            'model_id' : 'eleven_multilingual_v1',
            'voice_settings' : {
            'stability' : 0,
            'similarity_boost' : 0,
            'style' : 0,
            'use_speaker_boost' : true
     }
    }

    let url ="https://api.elevenlabs.io/v1/text-to-speech/CYw3kZ02Hs0563khs1Fj/stream?optimize_streaming_latency=0&output_format=mp3_44100_128";
fetch(url, options)
.then(responses =>{

    if (responses.ok){
        return responses.json();
        console.log(responses);
    }
} )