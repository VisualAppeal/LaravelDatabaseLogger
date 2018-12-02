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
     * Encrypt the context.
     *
     * @param mixed $data
     * @return string
     * @throws \Exception
     */
    public function encrypt($data): string
    {
        $nonce = random_bytes(
            SODIUM_CRYPTO_SECRETBOX_NONCEBYTES
        );

        $cipher = base64_encode(
            $nonce.
            sodium_crypto_secretbox(
                $data,
                $nonce,
                $this->encryptionKey
            )
        );
        sodium_memzero($data);
        sodium_memzero($this->encryptionKey);

        return $cipher;
    }

    /**
     * Decrypt the context.
     *
     * @param $data
     * @return bool|string
     * @throws \Exception
     */
    public function decrypt($data)
    {
        $decoded = base64_decode($data);

        if ($decoded === false) {
            throw new \Exception('The encoding failed');
        }
        if (mb_strlen($decoded, '8bit') < (SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES)) {
            throw new \Exception('The message was truncated');
        }
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');

        $plain = sodium_crypto_secretbox_open(
            $ciphertext,
            $nonce,
            $this->encryptionKey
        );

        if ($plain === false) {
            throw new \Exception('The message was tampered with in transit');
        }

        sodium_memzero($ciphertext);
        sodium_memzero($this->encryptionKey);

        return $plain;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if (is_object($record['context']) && ($record['context'] instanceof \Closure)) {
            $context = 'Closure';
        } else {
            try {
                if ($this->encryption) {
                    $context = $this->encrypt($record['context']);
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
