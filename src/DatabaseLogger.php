<?php

namespace VisualAppeal\DatabaseLogger;

use Monolog\Logger;

class DatabaseLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param array $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger('laravel.database');
        $logger->pushHandler(new DatabaseHandler($config['level'] ?? 'debug'));
        return $logger;
    }
}
