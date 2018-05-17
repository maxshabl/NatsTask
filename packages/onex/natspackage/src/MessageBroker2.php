<?php
/**
 * Created by PhpStorm.
 * User: Maxim.Shablinsky
 * Date: 17.05.2018
 * Time: 15:18
 */

namespace Onex\NatsPackage;


use Nats\MessageBroker;

class MessageBroker2 extends MessageBroker
{
    /**
     * Set the path to the configuration file
     * @param array $config
     */
    public static function setConfig($config)
    {
        self::setConnectionOption(new \Nats\ConnectionOptions(
            [
                'user' => $config['user'],
                'pass' => $config['pass'],
                'host' => $config['host'],
                'token' => $config['token']
            ]
        ));
    }
}