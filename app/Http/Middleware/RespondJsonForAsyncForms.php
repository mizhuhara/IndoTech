<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RespondJsonForAsyncForms
{
    /**
     * Turn redirect responses into JSON when the request expects JSON,
     * so forms marked with data-async can save without a page reload.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->wantsJson() || ! $response instanceof RedirectResponse) {
            return $response;
        }

        $flash = $response->getSession()?->all() ?? [];
        $errors = $response->getSession()?->get('errors');

        if ($errors && $errors->any()) {
            return response()->json([
                'message' => $errors->getBag('default')->first(),
                'errors' => $errors->getBag('default')->toArray(),
            ], 422);
        }

        if (! empty($flash['error']) && is_string($flash['error'])) {
            return response()->json(['message' => $flash['error']], 422);
        }

        $message = $flash['success'] ?? $flash['status'] ?? null;

        if (! $message) {
            foreach ($flash as $key => $value) {
                if (is_string($value) && (str_contains($key, 'success') || str_contains($key, 'status'))) {
                    $message = $value;
                    break;
                }
            }
        }

        return response()->json([
            'message' => $message,
            'redirect' => $response->getTargetUrl(),
        ]);
    }
}
