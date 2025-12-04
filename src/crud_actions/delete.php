<?php
require_once __DIR__ . '/../auth/auth_required.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../query.php';

auth_required('../../public/admin/login_page.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entity = $_POST['entity'] ?? '';

    $query = new Query();

    // Delete the specified entity
    try {
        switch ($entity) {
            case 'device':
                // Deletes the device specified by device_id
                $device_id = $_POST['device_id'];

                $query->delete(TABLE_DEVICES, [
                    COLUMNS_DEVICES['id'] => $device_id
                ]);

                header('Location: ../../public/admin/crud/devices/list_devices.php?locale=' . $_POST['locale']);
                break;
            case 'question':
                // Deletes the question specified by question_id
                $question_id = $_POST['question_id'];

                $query->delete(TABLE_QUESTIONS, [
                    COLUMNS_QUESTIONS['id'] => $question_id
                ]);

                header('Location: ../../public/admin/crud/questions/list_questions.php?locale=' . $_POST['locale']);
                break;
            case 'sector':
                // Deletes the sector specified by sector_id
                $sector_id = $_POST['sector_id'];

                $query->delete(TABLE_SECTORS, [
                    COLUMNS_SECTORS['id'] => $sector_id
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
