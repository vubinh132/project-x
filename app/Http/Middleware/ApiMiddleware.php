<?php

namespace App\Http\Middleware;

use App\Models\ApiData;
use App\Services\CommonService;
use Closure, Log;
use Carbon\Carbon;

class ApiMiddleware
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
        $headerValue = $request->header('API_KEY');
        if ($headerValue == CommonService::getSettingChosenValue('API_KEY')) {
            $data = ApiData::where('path', $request->path())->firstOrFail();
            $data->update([
                'number_of_uses' => $data->number_of_uses + 1,
                'last_time_called' => Carbon::now()
            ]);
            return $next($request);
        }

        Log::error('wrong api key');
        return response()->json([
            'success' => false,
            'message' => 'wrong api key',
        ], 401);
    }
}
