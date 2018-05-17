<?php

namespace Onex\NatsPackage;

use Illuminate\Console\Command;

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
    protected $signature = 'nats:listen {param=default}';

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
        set_time_limit(0);
        //$config = config('nats');
        $param = $this->argument('param');
        try {
            MessageBroker2::setConfig(config('nats'));
            $broker = MessageBroker2::getInstance();
        } catch (\Exception $e) {
            //todo необходимо логирование
            exit('Problem with connection');
        }
        $broker->reSubscribeTo($param);
        while (true) {
            try {
                if ($message = $broker->waitForOneMessage($param)) {
                    call_user_func(config('nats.facade.class').'::'.config('nats.facade.method'), $message);
                }
            } catch (\Exception $e) {
                //todo необходимо логирование
                exit($e->getMessage());
            }

        }
        //$this->info('Listening channel was interrupted!');
    }
}
