<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/query.php';

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
    try {
        $query = new Query();

        // Insert each response into the evaluations table
        foreach ($responses as $question_id => $score) {
            $query->insert(
                TABLE_EVALUATIONS,
                [
                    COLUMNS_EVALUATIONS['question_id'] => $question_id,
                    COLUMNS_EVALUATIONS['sector_id'] => $sector_id,
                    COLUMNS_EVALUATIONS['device_id'] => $device_id,
                    COLUMNS_EVALUATIONS['score'] => $score,
                ]
            );
        }

        // Insert feedback if provided
        if ($feedback !== null && trim($feedback) !== '') {
            $query->insert(
                TABLE_FEEDBACK,
                [
                    COLUMNS_FEEDBACK['sector_id'] => $sector_id,
                    COLUMNS_FEEDBACK['device_id'] => $device_id,
                    COLUMNS_FEEDBACK['text'] => $feedback
                ]
            );
        }

        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Evaluation saved successfully'
        ]);
    } catch (Exception $ex) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error saving evaluation'
        ]);

        throw new Exception('Database error: ' . $ex->getMessage());
    }
} catch (Exception $ex) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $ex->getMessage()
    ]);
}
