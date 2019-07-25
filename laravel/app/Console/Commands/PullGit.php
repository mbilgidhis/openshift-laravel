<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PullGit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull {branch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull source from repository';

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
        exec('git pull origin ' . $this->argument('branch'));
        exec('git checkout ' . $this->argument('branch'));
        exec('composer update');
        exec('npm install');
        exec('npm build dev');
        exec('php artisan reset');
    }
}
