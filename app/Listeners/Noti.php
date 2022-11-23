<?php

namespace App\Listeners;

use App\Events\Imported;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Noti
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Imported  $event
     * @return void
     */
    public function handle(Imported $event)
    {
        Storage::prepend('log.txt', $event->data['time'] .' - '.$event->data['action'] .' - '.$event->data['count'].' Record' );
    }
}
