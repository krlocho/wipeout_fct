<?php

namespace App\Listeners;

use App\Events\ReparacionUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\ReparacionUpdatedMail;
use Illuminate\Support\Facades\Mail;


class SendReparacionUpdatedEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReparacionUpdated $event): void
    {
        Mail::to('example@example.com')->send(new ReparacionUpdatedMail($event->reparacion));

    }
}
