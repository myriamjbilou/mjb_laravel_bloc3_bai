<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;

    // Définir le nom de la table
    protected $table = 'ideas'; 

    // Colonnes modifiables
    protected $fillable = ['title', 'description', 'user_id'];

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
