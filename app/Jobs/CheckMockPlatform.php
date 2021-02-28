<?php

namespace App\Jobs;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckMockPlatform implements ShouldQueue
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
        $response     = Http::withBasicAuth($this->subscription->device->app->username,$this->subscription->device->app->password)
                            ->post(route('purchase.verification.'.$this->subscription->device->os),[
                                'app_id'  => $this->subscription->device->app->id,
                                'receipt' => $this->subscription->receipt
                            ]);

        if ($response->successful()) {
            $responseData = $response->json();
            $responseData['expire_date'] = Carbon::createFromFormat('Y-m-d H:i:s',$responseData['expire_date'],'-6')->setTimezone(config('app.timezone'));
            $this->subscription->update([
                'status'      => 'renewed',
                'expire_date' => $responseData['expire_date'],
            ]);
        }else {
            $responseData = $response->json();

            if ($responseData['message'] == 'Rate Limit Error') {
                $this->release(10);
            }else {
                Log::error('Code Canceled');
                $this->subscription->update([
                    'status' => 'canceled',
                ]);
            }
        }
    }
}
