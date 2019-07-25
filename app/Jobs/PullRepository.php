<?php

namespace App\Jobs;

use App\PullHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Artisan;

class PullRepository implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pullhistory;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PullHistory $pullhistory)
    {
        $this->pullhistory = $pullhistory;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PullHistory $pullhistory)
    {
        Artisan::call('pull', ['branch' => 'dev']);
        // $pull = exec('php artisan pull master');
        // if ( $pull ) {
        $message = exec('git log --oneline -n 1');
        $result = PullHistory::create(['message' => $message]);
        // }
    }
}
