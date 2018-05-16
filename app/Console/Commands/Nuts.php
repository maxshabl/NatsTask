<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nats\MessageBroker;

class Nuts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nuts:listen {param}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        try {
            $envPath = base_path().DIRECTORY_SEPARATOR.'.env';
            MessageBroker::setConfig($envPath);
            $broker = MessageBroker::getInstance();
        } catch (\Exception $e) {
            exit('Problem with connection');
        }
        $broker->reSubscribeTo($argv[1]);
        while (true) {
            try {
                if ($message = $broker->waitForOneMessage($argv[1])) {
                    echo $message."\n\n";
                }
            } catch (\Exception $e) {
                exit($e->getMessage());
            }
        }
    }
}
