<?php

return [
    /*
     * Токен для доступа к аварийному просмотру логов (/logs?token=...).
     * Задаётся в .env: LOGS_TOKEN=your-secret-token
     */
    'token' => env('LOGS_TOKEN', ''),
];
