<?php

namespace App\Listeners;

use App\Events\CandidatePageWasLoaded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class AddCandidateClick
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
     * @param  CandidatePageWasLoaded  $event
     * @return void
     */
    public function handle(CandidatePageWasLoaded $event)
    {
        DB::table('candidate')->where('id', '=', $event->candidate->id)->increment('clicks', 1);
    }
}
