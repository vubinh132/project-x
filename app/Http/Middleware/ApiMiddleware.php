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
        $headerValue = $request->header('api-key');
        if ($headerValue == CommonService::getSettingChosenValue('API_KEY')) {
            $data = ApiData::where('path', $request->path())->first();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'api data have not been created yet',
                ], 404);
            }
            if ($data->is_locked) {
                return response()->json([
                    'success' => false,
                    'message' => 'this api have been locked',
                ], 401);
            }
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
