<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            $table->string('default_theme', 16)->default('warm')->after('show_footer');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            $table->dropColumn('default_theme');
        });
    }
};
