<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_likes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete()->index();
            $table->string('visitor_token', 36)->index();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['article_id', 'visitor_token']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_likes');
    }
};
