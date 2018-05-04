<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class ApiHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headerValue = $request->header(config('api.HEADER_KEY'));
        if ($headerValue == config('api.HEADER_VALUE')) {
            return $next($request);
        }

        Log::error('Wrong header key and value');
        return response()->json([
            'success' => false,
            'code' => config('api.code.common.unknown'),
            'message' => __('errors.common.unknown'),
        ]);
    }
}
