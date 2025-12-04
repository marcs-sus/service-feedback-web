<?php
require_once __DIR__ . '/../config.php';

class DatabaseConnection
{
    private static ?PDO $instance = null;

    // Get the singleton database connection
    public static function get_instance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,
                    DB_USER,
                    DB_PASSWORD,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $ex) {
                die("Database connection failed: " . $ex->getMessage());
            }
        }

        return self::$instance;
    }

    // Prevent direct instantiation
    private function __construct() {}

    // Prevent cloning
    private function __clone() {}

    // Prevent unserializing
    public function __wakeup() {}
}
