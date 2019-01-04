<?php

namespace App\Http\Controllers;

use App\Models\ActivityHistory;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Log, Mail, Auth;
use Exception;
use App\Mail\SimpleEmailSender;


class GeneralSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $startDate = CommonService::getSettingChosenValue('START_DATE');
        $version = explode('|', CommonService::getSettingChosenValue('VERSION_DETAILS'));
        $mailServer = env('MAIL_USERNAME');
        $day = CommonService::getSettingChosenValue('SYNC_TIME');
        $apiKey = CommonService::getSettingChosenValue('API_KEY');

        return view('general_settings.index', compact('startDate', 'version', 'mailServer', 'day', 'apiKey'));
    }

    public function update(Request $request)
    {

    }

    public function sendEmail(Request $request)
    {
        try {
            $email = $request->get('email');
            Mail::to($email)->send(new SimpleEmailSender('test', 'emails.template', ['content' => 'just test'], null));

            return response()->json([
                'success' => true
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'massage' => $e->getMessage()
            ]);
        }
    }

    public function updateSyncTime(Request $request)
    {
        try {
            $day = $request->get('day');
            CommonService::updateSettingValue('SYNC_TIME', $day);
            return response()->json([
                'success' => true
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'massage' => $e->getMessage()
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = Auth::user();
            $user->password = bcrypt($request->get('newPassword'));
            $user->save();
            return response()->json([
                'success' => true
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'massage' => $e->getMessage()
            ]);
        }
    }

    public function changeAPIKey(Request $request)
    {
        try {
            $newAPIKey = $request->get('newAPIKey');
            CommonService::updateSettingValue('API_KEY', $newAPIKey);
            return response()->json([
                'success' => true,
                'newAPIKey' => $newAPIKey
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'massage' => $e->getMessage()
            ]);
        }
    }
}
