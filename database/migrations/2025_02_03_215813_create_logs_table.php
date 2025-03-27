<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('action');
            $table->timestamp('heure')->useCurrent();
            $table->ipAddress('ip_address')->nullable();
            
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            
            $table->foreignId('idea_id')
                  ->nullable()
                  ->constrained('ideas')
                  ->nullOnDelete();
            
            $table->foreignId('comment_id')
                  ->nullable()
                  ->constrained('comments')
                  ->nullOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};