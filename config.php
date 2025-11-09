<?php
// File used to store configuration settings
// Values defined here are used across the application

// Database configuration
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'feedback_system');
define('DB_USER', 'postgres');
define('DB_PASSWORD', 'postgres');

// Database table names
define('TABLE_SECTORS', 'sectors');
define('TABLE_DEVICES', 'devices');
define('TABLE_QUESTIONS', 'questions');
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
        'sector_id' => 'sector_id',
        'status' => 'status'
    ]
);
define(
    'COLUMNS_QUESTIONS',
    [
        'id' => 'question_id',
        'text' => 'question_text',
        'type' => 'scale_type',
        'status' => 'status'
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
        'password' => 'password_hash'
    ]
);
