<?php

namespace VisualAppeal\DatabaseLogger;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;

use Monolog\Handler\AbstractProcessingHandler;

class DatabaseHandler extends AbstractProcessingHandler
{
    /**
     * Name of the database connection.
     *
     * @var string
     */
    protected $connection;

    /**
     * connection table name.
     *
     * @var string
     */
    protected $table;

    /**
     * Encrypt the context in database.
     *
     * @var boolean
     */
    protected $encryption;

    /**
     * Key for context encryption.
     *
     * @var string
     */
    protected $encryptionKey;

    /**
     * Set the database connection name.
     *
     * @param string $connection
     * @return \VisualAppeal\DatabaseLogger\DatabaseHandler
     */
    public function setConnection(string $connection): DatabaseHandler
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Set the database table name.
     *
     * @param string $table
     * @return \VisualAppeal\DatabaseLogger\DatabaseHandler
     */
    public function setTable(string $table): DatabaseHandler
    {
        $this->table = $table;

        return $this;
    }

    /**
     * If the context should be encrypted for the database.
     *
     * @param bool $encryption
     * @return \VisualAppeal\DatabaseLogger\DatabaseHandler
     */
    public function setEncryption(bool $encryption): DatabaseHandler
    {
        $this->encryption = $encryption;

        return $this;
    }

    /**
     * Key for context encryption.
     *
     * @param string $encryptionKey
     * @return \VisualAppeal\DatabaseLogger\DatabaseHandler
     */
    public function setEncryptionKey(string $encryptionKey): DatabaseHandler
    {
        $this->encryptionKey = $encryptionKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record): void
    {
        if (is_object($record['context']) && ($record['context'] instanceof \Closure)) {
            $context = 'Closure';
        } else {
            try {
                if ($this->encryption) {
                    $context = Container::getInstance()->make('encrypter')->encrypt($record['context']);
                } else {
                    $context = serialize($record['context']);
                }
            } catch (\Exception $e) {
                $context = null;
            }
        }

        DB::connection($this->connection)->table($this->table)->insert([
            'message' => $record['message'],
            'context' => $context,
            'level' => $record['level'],
            'channel' => $record['channel'],
            'created_at' => $record['datetime'],
            'extra' => serialize($record['extra']),
        ]);
    }
}
