<?php

namespace VisualAppeal\DatabaseLogger;

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
     * Set the database connection name.
     *
     * @param string $connection
     */
    public function setConnection(string $connection): void
    {
        $this->connection = $connection;
    }

    /**
     * Set the database table name.
     *
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * If the context should be encrypted for the database.
     *
     * @param bool $encryption
     */
    public function setEncryption(bool $encryption): void
    {
        $this->encryption = $encryption;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if (is_object($record['context']) && ($record['context'] instanceof Closure)) {
            $context = 'Closure';
        } else {
            try {
                if ($this->encryption) {
                    $context = encrypt($record['context']);
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
