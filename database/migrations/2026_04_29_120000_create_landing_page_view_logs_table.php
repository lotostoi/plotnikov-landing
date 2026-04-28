<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_page_view_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('landing_page_content_id')->constrained('landing_page_contents')->cascadeOnDelete();
            $table->timestamp('viewed_at');
            $table->timestamps();

            $table->index('viewed_at');
            $table->index(['landing_page_content_id', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_page_view_logs');
    }
};
