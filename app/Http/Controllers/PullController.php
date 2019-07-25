<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PullHistory;
use App\Jobs\PullRepository;
use Carbon\Carbon;
use Artisan;

class PullController extends Controller
{
    public function pull(Request $request, $key, $branch = 'master') {
        if( $key == 'kmzwa88wav' ){
            // Artisan::call('pull', ['branch' => $branch]);
            // Artisan::queue('pull', ['branch' => $branch, '--queue' => 'default']);
            $pull = new PullHistory(['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            PullRepository::dispatchNow($pull);
            echo "Pull from $branch is in queue.";
        } else 
            echo 'Please define your key';
    }
}
