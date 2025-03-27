<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Comment;
use App\Models\Log; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;

class IdeaController extends Controller
{
    /**
     * Afficher la liste des idées.
     */
    public function index()
    {
        // Récupérer les idées avec leurs utilisateurs et commentaires, paginées par 10
        $ideas = Idea::with('user', 'comments.user')
            ->latest()
            ->paginate(10);

        return view('idea.index', compact('ideas'));
    }

    /**
     * Afficher le formulaire de création d'une nouvelle idée.
     */
    public function create(): View|RedirectResponse
    {
        // Vérifier si l'utilisateur a déjà soumis 2 idées aujourd'hui
        $ideaCount = Idea::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($ideaCount >= 2) {
            return Redirect::route('idea.index')
                ->with('error', 'Vous avez atteint la limite de 2 idées par jour.');
        }

        return view('idea.create');
    }

    /**
     * Enregistrer une nouvelle idée.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Nettoyer les données pour éviter les XSS
        $validated['title'] = e($validated['title']);
        $validated['description'] = e($validated['description']);

        // Ajouter l'ID de l'utilisateur connecté
        $validated['user_id'] = Auth::id();

        // Créer l'idée dans la base de données
        $idea = Idea::create($validated);

        // Enregistrer un log (échapper les données pour éviter les XSS)
        Log::record(
            'Création d\'une idée', 
            'Idée créée avec le titre : ' . e($idea->title), 
            $idea->id
        );

        return redirect()->back()->with('success', 'Votre idée a été soumise avec succès !');
    }

    /**
     * Afficher une idée spécifique.
     */
    public function show(Idea $idea): View
    {
        return view('idea.show', compact('idea'));
    }

    /**
     * Afficher le formulaire de modification d'une idée.
     */
    public function edit(Idea $idea): View|RedirectResponse
    {
        // Vérifier que l'utilisateur est bien l'auteur de l'idée
        if ($idea->user_id !== Auth::id()) {
            return Redirect::route('idea.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette idée.');
        }

        return view('idea.edit', compact('idea'));
    }

    /**
     * Mettre à jour une idée spécifique.
     */
    public function update(Request $request, Idea $idea): RedirectResponse
    {
        // Vérifier que l'utilisateur est bien l'auteur de l'idée
        if ($idea->user_id !== Auth::id()) {
            return Redirect::route('idea.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette idée.');
        }

        // Valider les données du formulaire
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        // Nettoyer les données pour éviter les XSS
        $validated['title'] = e($validated['title']);
        $validated['description'] = e($validated['description']);

        // Mettre à jour l'idée dans la base de données
        $idea->update($validated);

        // Enregistrer un log (échapper les données pour éviter les XSS)
        Log::record(
            'Mise à jour d\'une idée', 
            'Idée mise à jour avec l\'ID : ' . $idea->id . ' - Titre : ' . e($idea->title), 
            $idea->id
        );

        return Redirect::route('idea.show', $idea)->with('status', 'idée-mise-à-jour');
    }

    /**
     * Supprimer une idée spécifique.
     */
    public function destroy(Idea $idea): RedirectResponse
    {
        // Vérifier que l'utilisateur est bien l'auteur de l'idée
        if ($idea->user_id !== Auth::id()) {
            return Redirect::route('idea.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette idée.');
        }

        // Supprimer l'idée de la base de données
        $idea->delete();

        // Enregistrer un log (échapper les données pour éviter les XSS)
        Log::record(
            'Suppression d\'une idée', 
            'Idée supprimée avec l\'ID : ' . $idea->id . ' - Titre : ' . e($idea->title), 
            $idea->id
        );

        return Redirect::route('idea.index')->with('status', 'idée-supprimée');
    }

    /**
     * Enregistrer un commentaire pour une idée spécifique.
     */
    public function storeComment(Request $request, Idea $idea)
    {
        // Vérifier si l'utilisateur a déjà soumis 3 commentaires aujourd'hui
        $commentsCount = Comment::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($commentsCount >= 3) {
            return redirect()->back()
                ->with('error', 'Vous avez atteint la limite de 3 commentaires par jour.');
        }

        // Valider les données du formulaire
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Nettoyer le contenu du commentaire pour éviter les XSS
        $validated['content'] = e($validated['content']);

        // Créer le commentaire dans la base de données
        $comment = $idea->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        // Enregistrer un log (échapper les données pour éviter les XSS)
        Log::record(
            'Ajout d\'un commentaire', 
            'Commentaire ajouté pour l\'idée ID : ' . $idea->id . ' - Contenu : ' . e($comment->content), 
            $comment->id
        );

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
    }

    /**
     * Mettre à jour un commentaire spécifique.
     */
    public function updateComment(Request $request, Comment $comment): RedirectResponse
    {
        // Vérifier que l'utilisateur est bien l'auteur du commentaire
        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('idea.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce commentaire.');
        }

        // Valider les données du formulaire
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Nettoyer le contenu du commentaire pour éviter les XSS
        $validated['content'] = e($validated['content']);

        // Mettre à jour le commentaire dans la base de données
        $comment->update($validated);

        // Enregistrer un log (échapper les données pour éviter les XSS)
        Log::record(
            'Mise à jour d\'un commentaire', 
            'Commentaire mis à jour avec l\'ID : ' . $comment->id . ' - Contenu : ' . e($comment->content), 
            $comment->id
        );

        return redirect()->back()->with('success', 'Commentaire mis à jour avec succès !');
    }

    /**
     * Supprimer un commentaire spécifique.
     */
    public function destroyComment(Comment $comment)
    {
        // Vérifier que l'utilisateur est bien l'auteur du commentaire
        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('idea.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire.');
        }

        // Supprimer le commentaire de la base de données
        $comment->delete();

        // Enregistrer un log (échapper les données pour éviter les XSS)
        Log::record(
            'Suppression d\'un commentaire', 
            'Commentaire supprimé avec l\'ID : ' . $comment->id . ' - Contenu : ' . e($comment->content), 
            $comment->id
        );

        return redirect()->back()->with('success', 'Commentaire supprimé avec succès !');
    }
}