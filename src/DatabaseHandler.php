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
        if (is_object($record['context']) && ($record['context'] instanceof Closure)) {
            $context = 'Closure';
        } else {
            try {
                $context = serialize($record['context']);
            } catch (\Exception $e) {
                $context = null;
            }
        }

        try {
            DB::table('logs')->insert([
                'message' => $record['message'],
                'context' => $context,
                'level' => $record['level'],
                'channel' => $record['channel'],
                'created_at' => $record['datetime'],
                'extra' => serialize($record['extra']),
            ]);
        } catch (\Exception $e) {
        }
    }
}
