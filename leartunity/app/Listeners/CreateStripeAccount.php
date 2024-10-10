<?php

namespace App\Listeners;

use App\Classes\StripeAccountCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateStripeAccount implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    protected StripeAccountCreate $stripeAccount;
    public function __construct(StripeAccountCreate $stripeAccount)
    {
        $this->stripeAccount = $stripeAccount;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $stripe_account_id = $this->stripeAccount->create();
        $event->user->update([
            "stripe_account_id" => $stripe_account_id
        ]);

    }
}
