<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../query.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $query = new Query();

    try {
        switch ($action) {
            case 'create':
                // Creates a new question with data from the form
                $question_sector = $_POST['question_sector'];
                $question_text = $_POST['question_text'];
                $question_type = $_POST['question_type'];
                $question_status = $_POST['question_status'];

                $query->insert(TABLE_QUESTIONS, [
                    COLUMNS_QUESTIONS['sector_id'] => $question_sector,
                    COLUMNS_QUESTIONS['text'] => $question_text,
                    COLUMNS_QUESTIONS['type'] => $question_type,
                    COLUMNS_QUESTIONS['status'] => $question_status
                ]);

                break;
            case 'update':
                // Updates an existing question with data from the form
                $question_id = $_POST['question_id'];
                $question_sector = $_POST['question_sector'];
                $question_text = $_POST['question_text'];
                $question_type = $_POST['question_type'];
                $question_status = $_POST['question_status'];

                $query->update(TABLE_QUESTIONS, [
                    COLUMNS_QUESTIONS['sector_id'] => $question_sector,
                    COLUMNS_QUESTIONS['text'] => $question_text,
                    COLUMNS_QUESTIONS['type'] => $question_type,
                    COLUMNS_QUESTIONS['status'] => $question_status
                ], [
                    COLUMNS_QUESTIONS['id'] => $question_id
                ]);
                break;
            case 'delete':
                // Deletes the question specified by question_id
                $question_id = $_POST['question_id'];

                $query->delete(TABLE_QUESTIONS, [
                    COLUMNS_QUESTIONS['id'] => $question_id
                ]);
                break;
            default:
                throw new Exception('Invalid action specified.');
        }
    } catch (Exception $e) {
        die('An error occurred: ' . $e->getMessage());
    }

    // Redirect back to the list of questions
    header('Location: ../../public/admin/crud/questions/list_questions.php');
    exit;
}
