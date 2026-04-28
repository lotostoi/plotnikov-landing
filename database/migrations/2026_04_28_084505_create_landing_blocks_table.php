<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_blocks', function (Blueprint $table): void {
            $table->id();
            $table->string('section_code');
            $table->string('block_key');
            $table->string('block_type')->default('item');
            $table->string('label')->nullable();
            $table->string('badge')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('body')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->unsignedInteger('sort_order')->default(100);
            $table->boolean('is_visible')->default(true);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['section_code', 'sort_order']);
            $table->index(['section_code', 'block_type']);
            $table->index(['section_code', 'is_visible']);
            $table->unique(['section_code', 'block_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_blocks');
    }
};
