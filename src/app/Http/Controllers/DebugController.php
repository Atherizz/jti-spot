<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DebugController extends Controller
{
    public function showIpForm(): Response
    {
        $html = <<<'HTML'
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Debug — IP Inspector</title>
            <style>
                *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
                body {
                    font-family: 'Segoe UI', system-ui, sans-serif;
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #0f172a;
                    color: #e2e8f0;
                }
                .card {
                    background: #1e293b;
                    border: 1px solid #334155;
                    border-radius: 12px;
                    padding: 2rem 2.5rem;
                    width: 100%;
                    max-width: 380px;
                    box-shadow: 0 20px 40px rgba(0,0,0,.4);
                }
                h1 { font-size: 1.1rem; font-weight: 600; margin-bottom: .25rem; color: #f1f5f9; }
                p  { font-size: .8rem; color: #94a3b8; margin-bottom: 1.5rem; }
                label { display: block; font-size: .78rem; color: #94a3b8; margin-bottom: .4rem; }
                input[type=password] {
                    width: 100%;
                    padding: .6rem .85rem;
                    border-radius: 8px;
                    border: 1px solid #475569;
                    background: #0f172a;
                    color: #f1f5f9;
                    font-size: .9rem;
                    outline: none;
                    margin-bottom: 1rem;
                    transition: border-color .2s;
                }
                input[type=password]:focus { border-color: #6366f1; }
                button {
                    width: 100%;
                    padding: .65rem;
                    border-radius: 8px;
                    border: none;
                    background: #6366f1;
                    color: #fff;
                    font-size: .9rem;
                    font-weight: 600;
                    cursor: pointer;
                    transition: background .2s;
                }
                button:hover { background: #4f46e5; }
                .error {
                    margin-top: .75rem;
                    font-size: .8rem;
                    color: #f87171;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="card">
                <h1>🔍 IP Inspector</h1>
                <p>Masukkan debug password untuk melihat hasil.</p>
                <form method="POST" action="/debug/ip">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <label for="debug_password">Password</label>
                    <input id="debug_password" type="password" name="password" autofocus placeholder="••••••••">
                    <button type="submit">Lihat Debug Info</button>
                </form>
            </div>
        </body>
        </html>
        HTML;

        // Replace the Blade csrf_token placeholder manually since we're returning raw HTML
        $csrfToken = csrf_token();
        $html = str_replace('{{ csrf_token() }}', $csrfToken, $html);

        return response($html);
    }

    public function inspectIp(Request $request): JsonResponse
    {
        $debugPassword = env('DEBUG_PASSWORD');

        if (empty($debugPassword) || $request->input('password') !== $debugPassword) {
            return response()->json(
                ['error' => 'Password salah atau DEBUG_PASSWORD belum di-set di .env.'],
                status: 401
            );
        }

        $userIp = $request->ip();

        $rawAllowedIps = env('ALLOWED_WIFI_IPS', '');
        $allowedIps = array_values(array_filter(
            array_map('trim', explode(',', $rawAllowedIps))
        ));

        $isAllowed = in_array($userIp, $allowedIps, strict: true);

        return response()->json([
            'user_ip'     => $userIp,
            'allowed_ips' => $allowedIps,
            'is_allowed'  => $isAllowed,
            'environment' => app()->environment(),
            'headers'     => [
                'x-forwarded-for' => $request->header('X-Forwarded-For'),
                'x-real-ip'       => $request->header('X-Real-IP'),
                'remote-addr'     => $request->server('REMOTE_ADDR'),
            ],
        ]);
    }
}
