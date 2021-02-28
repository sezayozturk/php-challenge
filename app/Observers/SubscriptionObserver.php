<?php

namespace App\Observers;

use App\Jobs\SendSubScriptionEventJob;
use App\Models\Subscription;

class SubscriptionObserver
{
    public function created(Subscription $subscription)
    {
        SendSubScriptionEventJob::dispatch($subscription);
    }

    public function updated(Subscription $subscription)
    {
        if ($subscription->status != $subscription->getOriginal('status')) {
            SendSubScriptionEventJob::dispatch($subscription);
        }
    }
}
