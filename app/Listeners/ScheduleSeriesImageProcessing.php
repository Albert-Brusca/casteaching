<?php

namespace App\Listeners;

use App\Jobs\ProcessSeriesImage;
use App\Models\Serie;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ScheduleSeriesImageProcessing
{

    public Serie $serie;
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->serie->image) {
            ProcessSeriesImage::dispatch($event->serie);
        }
    }
}
