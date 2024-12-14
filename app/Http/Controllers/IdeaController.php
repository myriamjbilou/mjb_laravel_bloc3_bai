<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;

class ideacontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ideas = Idea::with('user', 'comments.user')
            ->latest()
            ->paginate(10);

        return view('idea.index', compact('ideas'));
    }

    /**
     * Show the form for creating a new idea.
     */
    public function create(): View|RedirectResponse
    {
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
     * Store a newly created idea.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'required|string',
        ]);

    // Ajoutez l'ID de l'utilisateur aux données validées
        $validated['user_id'] = auth::id();

    // Créez l'idée avec les données validées
        Idea::create($validated);

        return redirect()->back()->with('success', 'Votre idée a été soumise avec succès !');
    }

    /**
     * Display the specified idea.
     */
    public function show(Idea $idea): View
    {
        return view('idea.show', compact('idea'));
    }

    /**
     * Show the form for editing the specified idea.
     */
    public function edit(Idea $idea): View|RedirectResponse
    {
        if ($idea->user_id !== Auth::id()) {
            return Redirect::route('idea.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette idée.');
        }

        return view('idea.edit', compact('idea'));
    }

    /**
     * Update the specified idea.
     */
    public function update(Request $request, Idea $idea): RedirectResponse
    {
        if ($idea->user_id !== Auth::id()) {
            return Redirect::route('idea.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette idée.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $idea->update($validated);

        return Redirect::route('idea.show', $idea)->with('status', 'idea-updated');
    }

    /**
     * Remove the specified idea.
     */
    public function destroy(Idea $idea): RedirectResponse
    {
        if ($idea->user_id !== Auth::id()) {
            return Redirect::route('idea.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette idée.');
        }

        $idea->delete();

        return Redirect::route('idea.index')->with('status', 'idea-deleted');
    }

    public function storeComment(Request $request, Idea $idea)
    {
    // Vérifier le nombre de commentaires du jour
        $commentsCount = Comment::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->count();

         if ($commentsCount >= 3) {
            return redirect()->back()
                ->with('error', 'Vous avez atteint la limite de 3 commentaires par jour.');
        }
         

        $validated = $request->validate([
            'content' => 'required|string|max:500'
        ]);

        $idea->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
    }

    public function updateComment(Request $request, Comment $comment): RedirectResponse
    {
    // Vérifier que l'utilisateur est le propriétaire du commentaire
        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('idea.index')
             ->with('error', 'Vous n\'êtes pas autorisé à modifier ce commentaire.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:500'
        ]);

        $comment->update($validated);

        return redirect()->back()->with('success', 'Commentaire mis à jour avec succès !'); 
    }

    public function destroyComment(Comment $comment)
    {
    // Vérifier que l'utilisateur est le propriétaire du commentaire
        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('idea.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Commentaire supprimé avec succès !');
    }

}
