<?php
require_once __DIR__ . '/../../../../src/auth/auth_required.php';
require_once __DIR__ . '/../../../../src/model/device.php';

// Enforce authentication
auth_required('../../login_page.php');

$device = Device::find_by_id($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Device</title>
</head>

<body>
    <h1>Edit Device</h1>
    <form action="../../../../src/crud_actions/update.php" method="POST">
        <input type="hidden" name="entity" value="device">
        <input type="hidden" name="device_id" value="<?= $_GET['id'] ?>">
        <label for="device_name">Device Name:</label>
        <input type="text" id="device_name" name="device_name" value="<?= $device->get_name() ?>" required>
        <br><br>
        <label for="device_status">Status:</label>
        <select id="device_status" name="device_status">
            <option value="1" <?php if ($device->is_active()) echo 'selected'; ?>>Active</option>
            <option value="0" <?php if (!$device->is_active()) echo 'selected'; ?>>Inactive</option>
        </select>
        <br><br>
        <input type="submit" value="Update Device">
    </form>

</body>

</html>