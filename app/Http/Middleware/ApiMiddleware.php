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
            $apiData = ApiData::get();
            $path = $request->path();
            $data = null;
            foreach ($apiData as $element) {
                $regex = str_replace('/', '\/', $element->path);
                $regex = '/^' . preg_replace('/{[a-zA-Z0-9-]+}/', '[a-zA-Z0-9-]+', $regex) . '$/';
                if (preg_match($regex, $path)) {
                    $data = $element;
                    break;
                }
            }
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
