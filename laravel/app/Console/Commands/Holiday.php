<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Holiday as Liburan;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Carbon\Carbon;

class Holiday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holiday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Holiday from Google Calendar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Please wait for getting public holiday in Indonesia');
        $now = Carbon::now('Asia/Jakarta');
        $startingdate = '2019-01-01T10:00:00Z';
        $today = $now->toIso8601ZuluString(); 
        $client = new Client();
        try {
            $result = $client->request(
                'GET',
                config('services.google.link'),
                [
                    'query' => [
                        'key' => config('services.google.key'),
                        'timeMin' => $today
                    ]
                ]
            );

            $response = json_decode($result->getBody()->getContents());
            $count = 0;
            $liburan = array();
            foreach( $response->items as $item ) {
                $holiday = Liburan::firstOrCreate(
                    ['google_event_id' => $item->id],
                    [
                        'name'            => $item->summary,
                        'start'           => $item->start->date,
                        'end'             => $item->end->date,
                        'link'            => $item->htmlLink,
                        'status'          => $item->status,
                        'google_event_id' => $item->id
                    ]
                );

                if($holiday->wasRecentlyCreated){
                    $count++;
                    array_push($liburan, $item->summary );
                }
            }

            $this->info('There is (are) ' . $count . ' event(s) added.');
            foreach( $liburan as $libur ) {
                $this->line($libur);
            }
        } catch (GuzzleException $e) {
            $this->info('Exception: ' . $e->getResponse()->getBody(true));
        }
    }
}
