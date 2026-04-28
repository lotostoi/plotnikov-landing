<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now()->toDateTimeString();

        DB::table('landing_blocks')->updateOrInsert(
            ['section_code' => 'contacts', 'block_key' => 'telegram_channel'],
            [
                'block_type'   => 'card',
                'label'        => 'newspaper',
                'title'        => 'Читайте обо мне в Telegram',
                'subtitle'     => 'Статьи, заметки и мысли о терапии и отношениях',
                'body'         => null,
                'button_text'  => 'Открыть канал',
                'button_url'   => 'https://t.me/plotnikov_aleksander',
                'badge'        => null,
                'sort_order'   => 34,
                'is_visible'   => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        );

        DB::table('landing_blocks')
            ->where('section_code', 'contacts')
            ->where('block_key', 'cta_telegram')
            ->update([
                'button_url'  => 'https://t.me/AlexanderP_V',
                'button_text' => 'Telegram',
                'updated_at'  => $now,
            ]);

        DB::table('landing_blocks')
            ->where('section_code', 'contacts')
            ->where('block_key', 'nickname')
            ->update([
                'title'       => '@AlexanderP_V',
                'label'       => 'Ник в Telegram',
                'updated_at'  => $now,
            ]);
    }

    public function down(): void
    {
        DB::table('landing_blocks')
            ->where('section_code', 'contacts')
            ->where('block_key', 'telegram_channel')
            ->delete();
    }
};
