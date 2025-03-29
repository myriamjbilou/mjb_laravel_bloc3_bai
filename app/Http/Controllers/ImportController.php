<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function filterDump()
    {
        // Récupérer toutes les idées et commentaires depuis la BDD
        $ideas = DB::table('ideas')->get();
        $comments = DB::table('comments')->get();

        $validIdeas = [];
        $invalidIdeas = [];
        foreach ($ideas as $idea) {
            if (!$this->isContentSafe($idea->description)) {
                $invalidIdeas[] = $idea;
                // Log détaillé pour une idée KO
                Log::warning("Idée KO - ID: {$idea->id} - Titre: {$idea->title} - Raison: Contenu non sécurisé détecté dans la description. Extrait: " . substr($idea->description, 0, 50) . "...");
            } else {
                $validIdeas[] = $idea;
                // Log détaillé pour une idée OK
                Log::info("Idée OK - ID: {$idea->id} - Titre: {$idea->title}");
            }
        }

        $validComments = [];
        $invalidComments = [];
        foreach ($comments as $comment) {
            if (!$this->isContentSafe($comment->content)) {
                $invalidComments[] = $comment;
                // Log détaillé pour un commentaire KO
                Log::warning("Commentaire KO - ID: {$comment->id} - Raison: Contenu non sécurisé détecté. Extrait: " . substr($comment->content, 0, 50) . "...");
            } else {
                $validComments[] = $comment;
                // Log détaillé pour un commentaire OK
                Log::info("Commentaire OK - ID: {$comment->id}");
            }
        }

        // Log récapitulatif du filtrage
        Log::info("Filtrage terminé : " . count($validIdeas) . " idées OK, " . count($invalidIdeas) . " idées KO, " . count($validComments) . " commentaires OK, " . count($invalidComments) . " commentaires KO.");

        $message = "Filtrage terminé.<br>"
            . count($validIdeas) . " idées OK et " . count($invalidIdeas) . " idées KO.<br>"
            . count($validComments) . " commentaires OK et " . count($invalidComments) . " commentaires KO.";

        return view('import.filterResult', [
            'message'         => $message,
            'validIdeas'      => $validIdeas,
            'invalidIdeas'    => $invalidIdeas,
            'validComments'   => $validComments,
            'invalidComments' => $invalidComments,
        ]);
    }

    private function isContentSafe($content)
    {
        // On convertit en chaîne au cas où $content soit null
        $content = (string)$content;
        return !preg_match('/<script\b/i', $content);
    }
}
