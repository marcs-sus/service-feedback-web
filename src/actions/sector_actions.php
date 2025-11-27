<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../query.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $query = new Query();

    try {
        switch ($action) {
            case 'create':
                // Creates a new sector with data from the form
                $sector_name = $_POST['sector_name'];
                $sector_status = $_POST['sector_status'];

                $query->insert(TABLE_SECTORS, [
                    COLUMNS_SECTORS['name'] => $sector_name,
                    COLUMNS_SECTORS['status'] => $sector_status
                ]);
                break;
            case 'update':
                // Updates an existing sector with data from the form
                $sector_id = $_POST['sector_id'];
                $sector_name = $_POST['sector_name'];
                $sector_status = $_POST['sector_status'];

                $query->update(TABLE_SECTORS, [
                    COLUMNS_SECTORS['name'] => $sector_name,
                    COLUMNS_SECTORS['status'] => $sector_status
                ], [
                    COLUMNS_SECTORS['id'] => $sector_id
                ]);
                break;
            case 'delete':
                // Deletes the sector specified by sector_id
                $sector_id = $_POST['sector_id'];

                $query->delete(TABLE_SECTORS, [
                    COLUMNS_SECTORS['id'] => $sector_id
                ]);
                break;
            default:
                throw new Exception('Invalid action specified.');
        }
    } catch (Exception $e) {
        die('An error occurred: ' . $e->getMessage());
    }

    // Redirect back to the list of sectors
    header('Location: ../../public/admin/crud/sectors/list_sectors.php');
    exit;
}
