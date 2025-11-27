<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../query.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $query = new Query();

    try {
        switch ($action) {
            case 'create':
                // Creates a new device with data from the form
                $device_name = $_POST['device_name'];
                $device_status = $_POST['device_status'];

                $query->insert(TABLE_DEVICES, [
                    COLUMNS_DEVICES['name'] => $device_name,
                    COLUMNS_DEVICES['status'] => $device_status
                ]);
                break;
            case 'update':
                // Updates an existing device with data from the form
                $device_id = $_POST['device_id'];
                $device_name = $_POST['device_name'];
                $device_status = $_POST['device_status'];

                $query->update(TABLE_DEVICES, [
                    COLUMNS_DEVICES['name'] => $device_name,
                    COLUMNS_DEVICES['status'] => $device_status
                ], [
                    COLUMNS_DEVICES['id'] => $device_id
                ]);
                break;
            case 'delete':
                // Deletes the device specified by device_id
                $device_id = $_POST['device_id'];

                $query->delete(TABLE_DEVICES, [
                    COLUMNS_DEVICES['id'] => $device_id
                ]);
                break;
            default:
                throw new Exception('Invalid action specified.');
        }
    } catch (Exception $e) {
        die('An error occurred: ' . $e->getMessage());
    }

    // Redirect back to the list of devices
    header('Location: ../../public/admin/crud/devices/list_devices.php');
    exit;
}
