<?php
require_once __DIR__ . '/../../../../src/auth/auth_required.php';
require_once __DIR__ . '/../../../../src/model/sector.php';

// Enforce authentication
auth_required('../../login_page.php');

$sector = Sector::find_by_id($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sector</title>
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
            <h1>Edit Sector</h1>
            <form action="../../../../src/crud_actions/update.php" method="POST">
                <input type="hidden" name="entity" value="sector">
                <input type="hidden" name="sector_id" value="<?= $_GET['id'] ?>">

                <div class="form-group">
                    <label for="sector_name">Sector Name:</label>
                    <input type="text" id="sector_name" name="sector_name" value="<?= htmlspecialchars($sector->get_name()) ?>" required>
                </div>

                <div class="form-group">
                    <label for="sector_status">Status:</label>
                    <select id="sector_status" name="sector_status" required>
                        <option value="1" <?php if ($sector->is_active()) echo 'selected'; ?>>Active</option>
                        <option value="0" <?php if (!$sector->is_active()) echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Update Sector</button>
                    <a href="list_sectors.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>