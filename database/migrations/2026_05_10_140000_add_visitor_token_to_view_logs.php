<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_page_view_logs', function (Blueprint $table): void {
            $table->string('visitor_token', 36)->nullable()->after('ip')->index();
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_view_logs', function (Blueprint $table): void {
            $table->dropColumn('visitor_token');
        });
    }
};
