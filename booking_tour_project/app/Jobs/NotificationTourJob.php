<?php

namespace App\Jobs;

use App\Models\TourRoute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationTourJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $programs;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($programs)
    {
        $this->programs = $programs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dd('oke');
        TourRoute::insert($this->programs);
    }
}
