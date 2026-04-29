<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            $table->boolean('show_pricing')->default(true)->after('show_services');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            $table->dropColumn('show_pricing');
        });
    }
};
