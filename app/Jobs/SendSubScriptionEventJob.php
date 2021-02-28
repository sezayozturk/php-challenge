<?php

namespace App\Jobs;

use App\Models\Subscription;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendSubScriptionEventJob implements ShouldQueue
{
    use Dispatchable,InteractsWithQueue,Queueable,SerializesModels;

    private $subscription;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url    = $this->subscription->device->app->callback_url;
        $params = [
            'app_id'    => $this->subscription->device->os == 'ios' ? $this->subscription->device->app->ios_app_id : $this->subscription->device->app->android_app_id,
            'device_id' => $this->subscription->device->u_id,
            'event'     => $this->subscription->status
        ];
        try{
            $response = Http::post($url,$params);
            if ($response->successful()) {
                Log::info('3party App Send Event - Successful');
            }else {
                Log::info('3party App Send Event - Failed');
                throw new Exception('Failed');
            }
        }catch (Throwable $exception){
            $this->release(90);
        }
    }

    public function retryUntil()
    {
        return now()->addHours(1);
    }
}
