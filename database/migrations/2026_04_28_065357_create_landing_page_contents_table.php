<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('landing_page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_badge')->default('Гештальт-терапевт');
            $table->string('hero_title')->default('Здравствуйте, я Александр');
            $table->text('hero_description')->nullable();
            $table->string('contact_handle')->default('@AlexanderP_V');
            $table->string('telegram_url')->default('https://t.me/AlexanderP_V');
            $table->string('whatsapp_url')->default('https://wa.me/message/AlexanderP_V');
            $table->string('location_text')->default('Владивосток, Артём');
            $table->string('seo_title')->default('Александр Психолог | Гештальт-терапия');
            $table->text('seo_description')->nullable();
            $table->string('seo_keywords')->default('психолог, гештальт-терапия, психотерапия, консультация психолога, Владивосток, онлайн психолог');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_contents');
    }
};
