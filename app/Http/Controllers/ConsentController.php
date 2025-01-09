<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log; 
use Illuminate\Http\Request;


class ConsentController extends Controller
{
    public function store(Request $request)
    {
        // Récupérez les données du formulaire
        $consentData = $request->all();

        // Stockez ou traitez les données selon vos besoins
        // Exemple : enregistrement dans une table "consents"
        Log::info('Consentement reçu : ', $consentData);

        // Répondez avec un message de succès
        return response()->json(['success' => true, 'message' => 'Consentement enregistré avec succès']);
    }
    
}
