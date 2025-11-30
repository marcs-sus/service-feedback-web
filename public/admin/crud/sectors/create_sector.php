<?php
require_once __DIR__ . '/../../../../src/auth/auth_required.php';

// Enforce authentication
auth_required('../../login_page.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Sector</title>
    <link rel="stylesheet" href="../../../css/admin.css">
</head>

<body>
    <!-- Navigation -->
    <nav>
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="../../dashboard.php">Dashboard</a></li>
            <li><a href="list_sectors.php">Sectors</a></li>
            <li><a href="../devices/list_devices.php">Devices</a></li>
            <li><a href="../questions/list_questions.php">Questions</a></li>
            <li><a href="../../../../src/auth/logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="form-container">
            <h1>Create New Sector</h1>
            <form action="../../../../src/crud_actions/create.php" method="POST">
                <input type="hidden" name="entity" value="sector">

                <div class="form-group">
                    <label for="sector_name">Sector Name:</label>
                    <input type="text" id="sector_name" name="sector_name" required>
                </div>

                <div class="form-group">
                    <label for="sector_status">Status:</label>
                    <select id="sector_status" name="sector_status" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Create Sector</button>
                    <a href="list_sectors.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>