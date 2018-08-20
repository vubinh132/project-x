<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Services\CommonService;
use App\Services\LazadaService;
use App\Models\Log;


class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $day = (float)CommonService::getSettingChosenValue('SYNC_TIME');
        $startDay = Carbon::now()->subDay($day - 1)->startOfDay();
        $endDay = Carbon::now()->endOfDay();
        $res = LazadaService::syncOrders($startDay, $endDay);
        $success = $res['success'];
        if ($success) {
            $insert = $res['data']['insert'];
            $update = $res['data']['update'];
            $fail = $res['data']['fail'];
            $mess = "Sync orders from Lazada $insert insert, $update update, $fail fail";
            CommonService::writeLog(Log::CATEGORY['JOB'], $mess);
            if ($fail > 0)
                CommonService::writeLog(Log::CATEGORY['ERROR'], "sync lazada orders fail: $fail");
        } else {
            $message = $res['message'];
            $mess = "Sync orders from Lazada is failed. $message";
            CommonService::writeLog(Log::CATEGORY['ERROR'], $mess);
        }
    }
}
