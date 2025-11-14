<?php
// Functions for managing questions
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../db.php';

function get_all_questions()
{
    global $pdo;
    try {


        $sql = "SELECT * FROM " . TABLE_QUESTIONS .
            " WHERE " . COLUMNS_QUESTIONS['status'] . " = TRUE" .
            " AND " . COLUMNS_QUESTIONS['sector_id'] . " = " . $_GET['sector'] .
            " ORDER BY " . COLUMNS_QUESTIONS['id'] . " ASC;";

        return pgsql_query_all($pdo, $sql);
    } catch (Exception $ex) {
        error_log("Error fetching questions: " . $ex->getMessage());
        return null;
    }
}
