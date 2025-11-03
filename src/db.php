<?php
// File used to connect to the PostgreSQL database
require_once __DIR__ . '/../config.php';

try {
    // Create a new PDO instance
    $pdo = new PDO(
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
