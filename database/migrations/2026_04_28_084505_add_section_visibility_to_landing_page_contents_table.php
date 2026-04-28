<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            $table->boolean('show_header')->default(true)->after('aggregate_rating_count');
            $table->boolean('show_hero')->default(true)->after('show_header');
            $table->boolean('show_about')->default(true)->after('show_hero');
            $table->boolean('show_services')->default(true)->after('show_about');
            $table->boolean('show_education')->default(true)->after('show_services');
            $table->boolean('show_reviews')->default(true)->after('show_education');
            $table->boolean('show_blog')->default(true)->after('show_reviews');
            $table->boolean('show_faq')->default(true)->after('show_blog');
            $table->boolean('show_contacts')->default(true)->after('show_faq');
            $table->boolean('show_footer')->default(true)->after('show_contacts');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_contents', function (Blueprint $table): void {
            $table->dropColumn([
                'show_header',
                'show_hero',
                'show_about',
                'show_services',
                'show_education',
                'show_reviews',
                'show_blog',
                'show_faq',
                'show_contacts',
                'show_footer',
            ]);
        });
    }
};
