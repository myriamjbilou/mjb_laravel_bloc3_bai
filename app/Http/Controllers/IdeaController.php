<?php

namespace App\Http\Controllers;

use App\Models\idea;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('idea.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifie si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour soumettre une idée.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Récupère l'ID de l'utilisateur authentifié
        $userId = Auth::id();

        Idea::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'users' => $validated['users'],
        ]);

         return redirect()->route('ideas.index')->with('success', 'Idée soumise avec succès.');


    }

    /**
     * Display the specified resource.
     */
    public function show(idea $idea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(idea $idea)
    {
        //
    }
}
