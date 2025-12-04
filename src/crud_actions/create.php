<?php
require_once __DIR__ . '/../auth/auth_required.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../query.php';

auth_required('../../public/admin/login_page.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entity = $_POST['entity'] ?? '';

    $query = new Query();

    // Create a new entity
    try {
        switch ($entity) {
            case 'device':
                // Creates a new device with data from the form
                $device_name = $_POST['device_name'];
                $device_status = $_POST['device_status'];

                $query->insert(TABLE_DEVICES, [
                    COLUMNS_DEVICES['name'] => $device_name,
                    COLUMNS_DEVICES['status'] => $device_status
                ]);

                header('Location: ../../public/admin/crud/devices/list_devices.php?locale=' . $_POST['locale']);
                break;
            case 'question':
                // Creates a new question with data from the form
                $question_sector = $_POST['question_sector'];
                $question_text = $_POST['question_text'];

                $question_status = $_POST['question_status'];

                $query->insert(TABLE_QUESTIONS, [
                    COLUMNS_QUESTIONS['sector_id'] => $question_sector,
                    COLUMNS_QUESTIONS['text'] => $question_text,
                    COLUMNS_QUESTIONS['status'] => $question_status
                ]);

                header('Location: ../../public/admin/crud/questions/list_questions.php?locale=' . $_POST['locale']);
                break;
            case 'sector':
                // Creates a new sector with data from the form
                $sector_name = $_POST['sector_name'];
                $sector_status = $_POST['sector_status'];

                $query->insert(TABLE_SECTORS, [
                    COLUMNS_SECTORS['name'] => $sector_name,
                    COLUMNS_SECTORS['status'] => $sector_status
                ]);

                header('Location: ../../public/admin/crud/sectors/list_sectors.php?locale=' . $_POST['locale']);
                break;
            default:
                throw new Exception('Invalid entity specified.');
        }
    } catch (Exception $ex) {
        die('An error occurred: ' . $ex->getMessage());
    }

    exit;
}
