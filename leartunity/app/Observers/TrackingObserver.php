<?php

namespace App\Observers;
use App\Models\Tracker;
use App\Services\CourseCertificate;
use Illuminate\Support\Facades\File;

class TrackingObserver
{
    public function __construct(
        protected CourseCertificate $certificate 
    ) {}
}
