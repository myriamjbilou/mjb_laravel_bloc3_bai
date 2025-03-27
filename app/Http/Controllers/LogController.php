<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer la date de filtrage (si elle est fournie)
        $filterDate = $request->input('filter_date');

        // Requête de base pour les logs
        $logs = Log::query()
            ->with(['user', 'idea', 'comment']) // Charger les relations
            ->orderBy('created_at', 'desc'); // Trier par date de création

        // Appliquer le filtre de date si une date est fournie
        if ($filterDate) {
            $logs->whereDate('created_at', $filterDate);
        }

        // Paginer les résultats
        $logs = $logs->paginate(10);

        // Retourner la vue avec les logs
        return view('logs.index', compact('logs', 'filterDate'));
    }
}