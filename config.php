<?php
// File used to store configuration settings
// Values defined here are used across the application

// Load the Dotenv library
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Application configuration
define('APP_ENV', $_ENV['APP_ENV']);
define('DEFAULT_LOCALE', $_ENV['DEFAULT_LOCALE']);

// Session configuration
define('SESSION_LIFETIME', $_ENV['SESSION_LIFETIME']);
define('SESSION_SECURE', $_ENV['SESSION_SECURE']);
define('SESSION_HTTPONLY', $_ENV['SESSION_HTTPONLY']);
define('SESSION_SAMESITE', $_ENV['SESSION_SAMESITE']);

// Default IDs
define('DEFAULT_DEVICE_ID', $_ENV['DEFAULT_DEVICE_ID']);
define('DEFAULT_SECTOR_ID', $_ENV['DEFAULT_SECTOR_ID']);

// Database configuration
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_PORT', $_ENV['DB_PORT']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

// Database table names
define('TABLE_SECTORS', 'sectors');
define('TABLE_DEVICES', 'devices');
define('TABLE_QUESTIONS', 'questions');
define('TABLE_QUESTION_TRANSLATIONS', 'question_translations');
define('TABLE_EVALUATIONS', 'evaluations');
define('TABLE_FEEDBACK', 'feedback');
define('TABLE_ADMIN_USERS', 'admin_users');

// Table column names
define(
    'COLUMNS_SECTORS',
    [
        'id' => 'sector_id',
        'name' => 'sector_name',
        'status' => 'status'
    ]
);
define(
    'COLUMNS_DEVICES',
    [
        'id' => 'device_id',
        'name' => 'device_name',
        'status' => 'status'
    ]
);
define(
    'COLUMNS_QUESTIONS',
    [
        'id' => 'question_id',
        'sector_id' => 'sector_id',
        'text' => 'question_text',
        'status' => 'status'
    ]
);
define(
    'COLUMNS_QUESTION_TRANSLATIONS',
    [
        'id' => 'translation_id',
        'question_id' => 'question_id',
        'locale' => 'locale',
        'text' => 'translated_text',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at'
    ]
);
define(
    'COLUMNS_EVALUATIONS',
    [
        'id' => 'evaluation_id',
        'sector_id' => 'sector_id',
        'question_id' => 'question_id',
        'device_id' => 'device_id',
        'score' => 'response_score',
        'created_at' => 'created_at'
    ]
);
define(
    'COLUMNS_FEEDBACK',
    [
        'id' => 'feedback_id',
        'sector_id' => 'sector_id',
        'device_id' => 'device_id',
        'text' => 'feedback_text',
        'created_at' => 'created_at'
    ]
);
define(
    'COLUMNS_ADMIN_USERS',
    [
        'id' => 'admin_id',
        'username' => 'username',
        'password_hash' => 'password_hash'
    ]
);
