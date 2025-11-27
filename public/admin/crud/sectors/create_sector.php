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
    <title>Create Sector</title>
</head>

<body>
    <h1>Create New Sector</h1>
    <form action="../../../../src/actions/sector_actions.php" method="POST">
        <input type="hidden" name="action" value="create">
        <label for="sector_name">Sector Name:</label>
        <input type="text" id="sector_name" name="sector_name" required>
        <br><br>
        <label for="sector_status">Status:</label>
        <select id="sector_status" name="sector_status">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
        <br><br>
        <input type="submit" value="Create Sector">
    </form>

</body>

</html>