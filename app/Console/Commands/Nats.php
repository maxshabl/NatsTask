<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nats\MessageBroker;

/**
 * Class Nats
 * @package App\Console\Commands
 */
class Nats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nats:listen {param}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nats listener';

    /**
     * Create a new command instance.
     * Nats constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $envPath = base_path().DIRECTORY_SEPARATOR.'.env';
        $param = $this->argument('param');
        try {
            MessageBroker::setConfig($envPath);
            $broker = MessageBroker::getInstance();
        } catch (\Exception $e) {
            exit('Problem with connection');
        }
        $broker->reSubscribeTo($param);
        while (true) {
            try {
                if ($message = $broker->waitForOneMessage($param)) {
                    echo $message."\n\n";
                }
            } catch (\Exception $e) {
                exit($e->getMessage());
            }

        }
        //$this->info('Listening channel was interrupted!');
    }
}
