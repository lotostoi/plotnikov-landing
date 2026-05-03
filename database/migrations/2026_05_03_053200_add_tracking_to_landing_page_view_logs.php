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
            $table->string('ip', 45)->nullable()->after('viewed_at');
            $table->text('user_agent')->nullable()->after('ip');
            $table->string('device', 20)->nullable()->after('user_agent');   // desktop/mobile/tablet/bot
            $table->string('referrer', 500)->nullable()->after('device');
            $table->string('utm_source', 255)->nullable()->after('referrer');
            $table->string('utm_medium', 255)->nullable()->after('utm_source');
            $table->string('utm_campaign', 255)->nullable()->after('utm_medium');
            $table->string('utm_term', 255)->nullable()->after('utm_campaign');
            $table->string('utm_content', 255)->nullable()->after('utm_term');

            $table->index('ip');
            $table->index('device');
            $table->index('utm_source');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_view_logs', function (Blueprint $table): void {
            $table->dropIndex(['ip']);
            $table->dropIndex(['device']);
            $table->dropIndex(['utm_source']);
            $table->dropColumn([
                'ip', 'user_agent', 'device',
                'referrer',
                'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
            ]);
        });
    }
};
