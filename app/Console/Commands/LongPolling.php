<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LongPolling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listen:longpolling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '開始監聽 (採取 Long Polling 方式)';

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
        //啟動已綁定的 Polling Worker
        $worker = \App::make("PollingWorker");
        $worker->run();

        $this->comment("PollingWorker is running... <3");

    }
}
