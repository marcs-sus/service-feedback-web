<?php
require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/functions/postgres.php';
require_once __DIR__ . '/../src/functions/evaluations.php';

// Set JSON response header
header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => 'false', 'message' => 'Method Not Allowed']);
    exit;
}

try {
    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Validate input
    if (!isset($data['responses']) || !is_array($data['responses'])) {
        throw new Exception(('Invalid responses data'));
    }

    if (empty($data['responses'])) {
        throw new Exception('No responses provided');
    }

    // Extract data
    $responses = $data['responses'];
    $feedback = $data['feedback'] ?? null;
    $device_id = $data['device_id'];
    $sector_id = $data['sector_id'];

    // Validade scores
    foreach ($responses as $question_id => $score) {
        if (!is_numeric($score) || $score < 0 || $score > 10) {
            throw new Exception('Invalid score value');
        }
    }

    // Save evaluation
    $result = save_evaluation($responses, $feedback, $device_id, $sector_id);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Evaluation saved successfully'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error saving evaluation'
        ]);
    }
} catch (Exception $ex) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $ex->getMessage()
    ]);
}
