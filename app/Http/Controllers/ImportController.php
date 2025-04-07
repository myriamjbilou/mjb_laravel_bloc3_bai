<?php

namespace App\Http\Controllers;

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
                
                // Nettoyage de la description
                $cleanedDescription = $this->sanitizeContent($idea->description);
                DB::table('ideas')->where('id', $idea->id)->update([
                    'description' => $cleanedDescription
                ]);

                Log::warning("Idée KO - ID: {$idea->id} - Titre: {$idea->title} - Description nettoyée. Extrait: " . substr($idea->description, 0, 50) . "...");
            } else {
                $validIdeas[] = $idea;
                Log::info("Idée OK - ID: {$idea->id} - Titre: {$idea->title}");
            }
        }

        $validComments = [];
        $invalidComments = [];
        foreach ($comments as $comment) {
            if (!$this->isContentSafe($comment->content)) {
                $invalidComments[] = $comment;

                // Nettoyage du contenu
                $cleanedContent = $this->sanitizeContent($comment->content);
                DB::table('comments')->where('id', $comment->id)->update([
                    'content' => $cleanedContent
                ]);

                Log::warning("Commentaire KO - ID: {$comment->id} - Contenu nettoyé. Extrait: " . substr($comment->content, 0, 50) . "...");
            } else {
                $validComments[] = $comment;
                Log::info("Commentaire OK - ID: {$comment->id}");
            }
        }

        // Log récapitulatif du filtrage
        Log::info("Filtrage terminé : " . count($validIdeas) . " idées OK, " . count($invalidIdeas) . " idées nettoyées, " . count($validComments) . " commentaires OK, " . count($invalidComments) . " commentaires nettoyés.");

        $message = "Filtrage terminé.<br>"
            . count($validIdeas) . " idées OK et " . count($invalidIdeas) . " idées nettoyées.<br>"
            . count($validComments) . " commentaires OK et " . count($invalidComments) . " commentaires nettoyés.";

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
        $patterns = [
            '/<script\b[^>]*>(.*?)<\/script>/is', // Scripts classiques
            '/on\w+="[^"]*"/i',                   // onClick, onLoad, etc.
            '/javascript:/i',                    // URLs javascript:
            '/<iframe\b/i',                      // iframes
            '/<object\b/i',                      // objets embarqués
            '/<embed\b/i',                       // contenu multimédia
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return false;
            }
        }

        return true;
    }

    private function sanitizeContent($content)
    {
        // Supprimer balises dangereuses
        $content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $content);
        $content = preg_replace('/on\w+="[^"]*"/i', '', $content);
        $content = preg_replace('/javascript:/i', '', $content);
        $content = preg_replace('/<iframe\b[^>]*>(.*?)<\/iframe>/is', '', $content);
        $content = preg_replace('/<object\b[^>]*>(.*?)<\/object>/is', '', $content);
        $content = preg_replace('/<embed\b[^>]*>(.*?)<\/embed>/is', '', $content);

        return $content;
    }
}
