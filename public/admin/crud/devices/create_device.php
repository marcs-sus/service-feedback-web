<?php
require_once __DIR__ . '/../../../../src/functions/auth_required.php';

// Enforce authentication
auth_required('../../login.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Device</title>
</head>

<body>
    <h1>Create New Device</h1>
    <form action="../../../../src/actions/device_actions.php" method="POST">
        <input type="hidden" name="action" value="create">
        <label for="device_name">Device Name:</label>
        <input type="text" id="device_name" name="device_name" required>
        <br><br>
        <label for="device_status">Status:</label>
        <select id="device_status" name="device_status">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
        <br><br>
        <input type="submit" value="Create Device">
    </form>

</body>

</html>