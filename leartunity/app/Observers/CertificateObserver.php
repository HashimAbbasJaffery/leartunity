<?php

namespace App\Observers;
use App\Events\NotificationEvent;
use App\Models\Certificate;
use App\Notifications\MessageNotification;

class CertificateObserver
{
    public function created(Certificate $certificate) {
        $user = \App\Models\User::find(auth()->id());
        NotificationEvent::dispatch(auth()->id(), "You have been awarded a certificate!");
        $user->notify(new MessageNotification("You have been awarded a certificate!"));
    }
}
