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
    <link rel="stylesheet" href="../../../css/admin.css">
</head>

<body>
    <!-- Navigation -->
    <nav>
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="../../dashboard.php">Dashboard</a></li>
            <li><a href="../sectors/list_sectors.php">Sectors</a></li>
            <li><a href="list_devices.php">Devices</a></li>
            <li><a href="../questions/list_questions.php">Questions</a></li>
            <li><a href="../../../../src/auth/logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="form-container">
            <h1>Edit Device</h1>
            <form action="../../../../src/crud_actions/update.php" method="POST">
                <input type="hidden" name="entity" value="device">
                <input type="hidden" name="device_id" value="<?= $_GET['id'] ?>">

                <div class="form-group">
                    <label for="device_name">Device Name:</label>
                    <input type="text" id="device_name" name="device_name" value="<?= htmlspecialchars($device->get_name()) ?>" required>
                </div>

                <div class="form-group">
                    <label for="device_status">Status:</label>
                    <select id="device_status" name="device_status" required>
                        <option value="1" <?php if ($device->is_active()) echo 'selected'; ?>>Active</option>
                        <option value="0" <?php if (!$device->is_active()) echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Update Device</button>
                    <a href="list_devices.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>