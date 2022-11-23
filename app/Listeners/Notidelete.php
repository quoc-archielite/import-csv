<?php

namespace App\Listeners;

use App\Events\Deleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class Notidelete
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
     * @param  \App\Events\Deleted  $event
     * @return void
     */
    public function handle(Deleted $event)
    {
        Storage::prepend('log.txt', $event->data['time'] .' - '.$event->data['action'] .' - '.$event->data['count'].' Record' );
    }
}
