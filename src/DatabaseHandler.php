<?php

namespace VisualAppeal\DatabaseLogger;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Monolog\Handler\AbstractProcessingHandler;

class DatabaseHandler extends AbstractProcessingHandler
{
    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        try {
            $context = serialize($record['context']);
        } catch (\Exception $e) {
            $context = serialize([]);
            Log::error($e);
        }

        DB::table('logs')->insert([
            'message' => $record['message'],
            'context' => $context,
            'level' => $record['level'],
            'channel' => $record['channel'],
            'created_at' => $record['datetime'],
            'extra' => serialize($record['extra']),
        ]);
    }
}
