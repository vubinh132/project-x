<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Services\CommonService;
use App\Services\LazadaService;
use App\Models\Log;


class SyncData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lazada:sync-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data from lazada by APIs';

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
        $startTime = Carbon::now();
        $day = (float)CommonService::getSettingChosenValue('SYNC_TIME');
        $startDay = Carbon::now()->subDay($day - 1)->startOfDay();
        $endDay = Carbon::now()->endOfDay();
        $syncOrdersRes = LazadaService::syncOrders($startDay, $endDay);
        if ($syncOrdersRes['success']) {
            $insert = $syncOrdersRes['data']['insert'];
            $update = $syncOrdersRes['data']['update'];
            $fail = $syncOrdersRes['data']['fail'];
            $mess = "Sync orders from Lazada $insert insert, $update update, $fail fail";
            CommonService::writeLog(Log::CATEGORY['JOB'], $mess);
            if ($fail > 0)
                CommonService::writeLog(Log::CATEGORY['ERROR'], "sync lazada orders fail: $fail");
        } else {
            $message = $syncOrdersRes['message'];
            $mess = "Sync orders from Lazada is failed. $message";
            CommonService::writeLog(Log::CATEGORY['ERROR'], $mess);
        }
        $this->line('sync orders from lazada: done');


        $syncProductsRes = LazadaService::syncProducts();
        if ($syncProductsRes['success']) {
            $insert = $syncProductsRes['data']['insert'];
            $update = $syncProductsRes['data']['update'];
            $soldOut = $syncProductsRes['data']['soldOut'];
            $delete = $syncProductsRes['data']['delete'];
            $mess = "Sync product from Lazada $insert insert, $update update, $soldOut sold out, $delete delete";
            CommonService::writeLog(Log::CATEGORY['JOB'], $mess);
        } else {
            $message = $syncProductsRes['message'];
            $mess = "Sync products from Lazada is failed. $message";
            CommonService::writeLog(Log::CATEGORY['ERROR'], $mess);
        }
        $this->line('sync product from lazada: done');

        $duration = (Carbon::now())->diffInSeconds($startTime);
        $this->line("the process have finished in " . $duration . "s");
    }
}
