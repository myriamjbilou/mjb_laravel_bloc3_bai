<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RedirectController extends Controller
{
    public function redirect(Request $request)
    {
        $url = $request->input('url');

        // Vérifie l'URL 
        if (!Str::startsWith($url, '/')) {
            abort(403, 'Redirection non autorisée');
        }

        return redirect($url);
    }
}
