<?php

namespace VisualAppeal\DatabaseLogger;

use Illuminate\Support\Facades\DB;

use Monolog\Handler\AbstractProcessingHandler;

class DatabaseHandler extends AbstractProcessingHandler
{
    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        DB::table('logs')->insert([
            'message' => $record['message'],
            'context' => serialize($record['context']),
            'level' => $record['level'],
            'channel' => $record['channel'],
            'created_at' => $record['datetime'],
            'extra' => serialize($record['extra']),
        ]);
    }
}
