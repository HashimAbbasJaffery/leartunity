<?php

namespace App\Observers;
use App\Events\NotificationEvent;

class CertificateObserver
{
    public function created() {
        NotificationEvent::dispatch(auth()->id(), "You have been awarded a certificate!");
    }
}
