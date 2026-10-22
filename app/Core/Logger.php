<?php

class Logger
{
    public static function path(): string
    {
        return dirname(__DIR__, 2) . '/storage/logs/app.log';
    }

    public static function error(string $message): void
    {
        self::write('ERROR', $message);
    }

    public static function exception(Throwable $e, string $context = ''): void
    {
        $file = str_replace(
            [dirname(__DIR__, 2) . DIRECTORY_SEPARATOR, dirname(__DIR__, 2) . '/'],
            '',
            $e->getFile()
        );

        $message = ($context !== '' ? $context . ' - ' : '')
            . $e->getMessage()
            . ' (' . get_class($e) . ' di ' . $file . ':' . $e->getLine() . ')';

        self::write('ERROR', $message);
    }

    private static function write(string $level, string $message): void
    {
        $path = self::path();
        $dir  = dirname($path);

        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $message = preg_replace('/\s+/', ' ', $message);

        $line = date('Y-m-d H:i:s') . " [$level] " . $message . PHP_EOL;

        @error_log($line, 3, $path);
    }
}
