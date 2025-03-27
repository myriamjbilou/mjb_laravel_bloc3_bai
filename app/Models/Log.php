<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
    protected $fillable = [
        'name', 
        'action', 
        'ip_address', 
        'user_id', 
        'idea_id', 
        'comment_id'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Utilisateur inconnu'
        ]);
    }
    public function idea()
    {
        return $this->belongsTo(Idea::class)->withDefault([
            'title' => 'Idée supprimée'
        ]);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class)->withDefault([
            'content' => 'Commentaire supprimé'
        ]);
    }

    // Attributs sécurisés pour éviter les erreurs de propriété null
    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    public function getIdeaTitleAttribute()
    {
        return $this->idea->title;
    }

    public function getCommentContentAttribute()
    {
        return $this->comment->content;
    }
    
    // Méthode pour enregistrer un log
    public static function record($name, $action, $idea_id = null, $comment_id = null)
    {
        return self::create([
            'name' => $name,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_id' => auth::id(),
            'idea_id' => $idea_id,
            'comment_id' => $comment_id
        ]);
    }

    // Supprime les logs plus anciens que la date limite
    public static function deleteOldLogs($days = 180)
    {
        $thresholdDate = now()->subDays($days);

        
        return self::where('created_at', '<', $thresholdDate)->delete();
    }
}