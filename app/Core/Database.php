<?php

require_once __DIR__ . '/Logger.php';
require_once __DIR__ . '/DataException.php';

class Database
{
    private $pdo;

    public function __construct(?array $config = null)
    {
        $config = $config ?? require __DIR__ . '/../../config/database.php';

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['dbname'],
            $config['charset'] ?? 'utf8mb4'
        );

        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            Logger::exception($e, 'Database::connect');

            throw new DataException('Koneksi ke database gagal', 0, $e);
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
