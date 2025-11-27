<?php
require_once __DIR__ . '/../../../../src/functions/auth_required.php';
require_once __DIR__ . '/../../../../src/model/device.php';

// Enforce authentication
auth_required('../../login.php');

// Fetch all devices from the database
$devices = Device::find_all();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devices</title>
</head>

<body>

    <h1>Devices</h1>
    <a href="create_device.php">Create New Device</a>
    <table border="1" cellpadding="5" cellspacing="0">
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
                    <td><?= $device->is_active() ? 'Active' : 'Inactive' ?></td>
                    <td>
                        <a href="edit_device.php?id=<?= urlencode($device->get_id()) ?>">
                            Edit
                        </a>
                        <form action="../../../../src/actions/device_actions.php"
                            method="POST" style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this device?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="device_id" value="<?= $device->get_id() ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>