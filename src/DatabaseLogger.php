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

        $handler = new DatabaseHandler($config['level'] ?? 'debug');
        $handler->setConnection($config['connection'] ?? 'mysql');
        $handler->setTable($config['table'] ?? 'logs');
        $handler->setEncryption($config['encrypt'] ?? false);
        $handler->setEncryptionKey($config['encrypt_key'] ?? '');

        $logger->pushHandler($handler);

        return $logger;
    }
}
