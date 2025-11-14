<?php
// Functions for managing evaluations
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../db.php';

function save_evaluation($responses, $feedback = null, $device_id, $sector_id): bool
{
    global $pdo;
    try {
        // Begin transaction to ensure all responses are saved
        $pdo->beginTransaction();

        // Build insert query for evaluations
        $sql =
            "INSERT INTO " . TABLE_EVALUATIONS . " (" .
            COLUMNS_EVALUATIONS['question_id'] . ", " .
            COLUMNS_EVALUATIONS['sector_id'] . ", " .
            COLUMNS_EVALUATIONS['device_id'] . ", " .
            COLUMNS_EVALUATIONS['score'] . ") " .
            "VALUES (:question_id, :sector_id, :device_id, :score);";

        $stmt = $pdo->prepare($sql);

        // Insert each question response
        foreach ($responses  as $question_id => $score) {
            $params = [
                ':question_id' => (int)$question_id,
                ':sector_id' => (int)$sector_id,
                ':device_id' => (int)$device_id,
                ':score' => (int)$score,
            ];

            // Execute query
            $stmt->execute($params);
        }

        // If feedback is not empty, save it
        if (!empty($feedback)) {
            // Build insert query for feedback
            $sql =
                "INSERT INTO " . TABLE_FEEDBACK . " (" .
                COLUMNS_FEEDBACK['sector_id'] . ", " .
                COLUMNS_FEEDBACK['device_id'] . ", " .
                COLUMNS_FEEDBACK['text'] . ") " .
                "VALUES (:sector_id, :device_id, :text);";

            $stmt = $pdo->prepare($sql);

            // Insert feedback
            $params = [
                ':sector_id' => (int)$sector_id,
                ':device_id' => (int)$device_id,
                ':text' => $feedback,
            ];

            // Execute query
            $stmt->execute($params);
        }

        // Commit transaction
        $pdo->commit();

        return true;
    } catch (Exception $ex) {
        // Rollback transaction on error
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        error_log("Error saving evaluation: " . $ex->getMessage());
        return false;
    }
}
