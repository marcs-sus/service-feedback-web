<?php
require_once __DIR__ . '/../../../../src/auth/auth_required.php';
require_once __DIR__ . '/../../../../src/model/device.php';

// Enforce authentication
auth_required('../../login_page.php');

// Fetch all devices from the database
$devices = Device::find_all();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devices Management</title>
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
        <div class="admin-header">
            <h1>Devices</h1>
            <a href="create_device.php" class="btn-primary">+ Create New Device</a>
        </div>

        <?php if (count($devices) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($devices as $device) : ?>
                        <tr>
                            <td><?= htmlspecialchars($device->get_id()) ?></td>
                            <td><?= htmlspecialchars($device->get_name()) ?></td>
                            <td>
                                <span style="color: <?= $device->is_active() ? '#28a745' : '#dc3545' ?>;">
                                    <?= $device->is_active() ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="edit_device.php?id=<?= urlencode($device->get_id()) ?>" class="btn-edit">Edit</a>
                                    <form action="../../../../src/crud_actions/delete.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="entity" value="device">
                                        <input type="hidden" name="device_id" value="<?= $device->get_id() ?>">
                                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this device?');">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="empty-state">
                <p>No devices found. <a href="create_device.php">Create one now.</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>s