<x-filament-panels::page>
    <div class="space-y-4">
        @php
            $content = $this->getLogContent();
            $sizeLabel = $this->getLogSizeLabel();
        @endphp

        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
            <span>
                Последние 500 строк
                @if ($sizeLabel)
                    &bull; Размер файла: <strong>{{ $sizeLabel }}</strong>
                @endif
            </span>
            <span class="text-xs">{{ storage_path('logs/laravel.log') }}</span>
        </div>

        <div class="overflow-auto rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-950">
            <pre
                class="p-4 text-xs leading-5 font-mono whitespace-pre-wrap break-all"
                style="max-height: 75vh; color: #d1d5db;"
            >{!! e($content) !!}</pre>
        </div>
    </div>

    <script>
        // Автоскролл вниз при загрузке
        document.addEventListener('DOMContentLoaded', function () {
            const pre = document.querySelector('pre');
            if (pre) {
                pre.scrollTop = pre.scrollHeight;
            }
        });
    </script>
</x-filament-panels::page>
