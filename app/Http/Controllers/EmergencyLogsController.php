<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class EmergencyLogsController extends Controller
{
    private const LOG_FILE = 'logs/laravel.log';

    private const TAIL_LINES = 1000;

    public function __invoke(): Response
    {
        $path = storage_path(self::LOG_FILE);
        $content = $this->readTail($path);

        $html = $this->render($path, $content);

        return response($html, 200, ['Content-Type' => 'text/html; charset=utf-8']);
    }

    private function readTail(string $path): string
    {
        if (! file_exists($path)) {
            return 'Лог-файл не найден: ' . $path;
        }

        $file = new \SplFileObject($path, 'r');
        $file->seek(PHP_INT_MAX);
        $total = $file->key();

        $startLine = max(0, $total - self::TAIL_LINES);
        $lines = [];
        $file->seek($startLine);

        while (! $file->eof()) {
            $lines[] = rtrim((string) $file->current());
            $file->next();
        }

        return implode("\n", $lines);
    }

    private function colorize(string $text): string
    {
        $text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        $text = preg_replace('/(\\.ERROR.*)/', '<span style="color:#ff6b6b">$1</span>', $text) ?? $text;
        $text = preg_replace('/(\\.WARNING.*)/', '<span style="color:#ffd93d">$1</span>', $text) ?? $text;
        $text = preg_replace('/(\\.CRITICAL.*)/', '<span style="color:#ff4444;font-weight:bold">$1</span>', $text) ?? $text;
        $text = preg_replace('/(\\.INFO.*)/', '<span style="color:#6bcb77">$1</span>', $text) ?? $text;
        $text = preg_replace('/(\\.DEBUG.*)/', '<span style="color:#888">$1</span>', $text) ?? $text;
        $text = preg_replace('/(\[\\d{4}-\\d{2}-\\d{2}[^\]]+\])/', '<span style="color:#a8d8ea">$1</span>', $text) ?? $text;

        return $text;
    }

    private function render(string $path, string $content): string
    {
        $size = file_exists($path) ? $this->formatBytes((int) filesize($path)) : '—';
        $colored = $this->colorize($content);
        $generatedAt = date('Y-m-d H:i:s');

        return <<<HTML
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laravel Log — Emergency Viewer</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { background: #0d1117; color: #c9d1d9; font-family: monospace; font-size: 13px; }
  header { background: #161b22; border-bottom: 1px solid #30363d; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; position: sticky; top: 0; z-index: 10; }
  header h1 { font-size: 15px; color: #f0f6fc; }
  .meta { color: #8b949e; font-size: 12px; }
  .meta strong { color: #c9d1d9; }
  .warn { color: #ffd93d; background: #21262d; border: 1px solid #3d2b00; padding: 8px 12px; margin: 12px 16px; border-radius: 6px; font-size: 12px; }
  pre { padding: 16px; white-space: pre-wrap; word-break: break-all; line-height: 1.6; }
</style>
</head>
<body>
<header>
  <h1>🔥 Laravel Log — Emergency Viewer</h1>
  <div class="meta">
    <strong>{$path}</strong> &bull; размер: <strong>{$size}</strong> &bull; последние <strong>1000</strong> строк &bull; {$generatedAt}
  </div>
</header>
<div class="warn">⚠ Этот URL доступен только по токену. Не делитесь ссылкой. Страница работает без подключения к БД.</div>
<pre id="log">{$colored}</pre>
<script>window.scrollTo(0, document.body.scrollHeight);</script>
</body>
</html>
HTML;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1024 * 1024) {
            return number_format($bytes / 1024 / 1024, 2) . ' MB';
        }

        return number_format($bytes / 1024, 1) . ' KB';
    }
}
