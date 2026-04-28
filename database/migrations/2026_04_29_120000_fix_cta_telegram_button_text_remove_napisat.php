<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now()->toDateTimeString();

        DB::table('landing_blocks')
            ->where('section_code', 'contacts')
            ->where('block_key', 'cta_telegram')
            ->whereRaw('LOWER(button_text) LIKE ?', ['написать%'])
            ->update([
                'button_text' => 'Telegram',
                'updated_at'  => $now,
            ]);
    }

    public function down(): void
    {
        // Не восстанавливаем старый маркетинговый текст.
    }
};
