<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            $table->unsignedBigInteger('landing_page_views_count')->default(0);
            $table->timestamp('landing_page_last_view_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            $table->dropColumn(['landing_page_views_count', 'landing_page_last_view_at']);
        });
    }
};
