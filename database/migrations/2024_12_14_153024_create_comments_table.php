<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->text('content'); // Contenu du commentaire
            $table->foreignId('idea_id')->constrained('idea')->onDelete('cascade'); // Clé étrangère
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
