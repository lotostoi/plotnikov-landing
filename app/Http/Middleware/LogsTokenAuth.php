<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogsTokenAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = env('LOGS_TOKEN', '');

        if ($expected === '' || ! hash_equals($expected, (string) $request->query('token', ''))) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
