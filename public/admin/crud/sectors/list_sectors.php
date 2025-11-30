<?php
require_once __DIR__ . '/../../../../src/auth/auth_required.php';
require_once __DIR__ . '/../../../../src/model/sector.php';

// Enforce authentication
auth_required('../../login_page.php');

// Fetch all sectors from the database
$sectors = Sector::find_all();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sectors Management</title>
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
        <div class="admin-header">
            <h1>Sectors</h1>
            <a href="create_sector.php" class="btn-primary">+ Create New Sector</a>
        </div>

        <?php if (count($sectors) > 0) : ?>
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
                    <?php foreach ($sectors as $sector) : ?>
                        <tr>
                            <td><?= htmlspecialchars($sector->get_id()) ?></td>
                            <td><?= htmlspecialchars($sector->get_name()) ?></td>
                            <td>
                                <span style="color: <?= $sector->is_active() ? '#28a745' : '#dc3545' ?>;">
                                    <?= $sector->is_active() ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="edit_sector.php?id=<?= urlencode($sector->get_id()) ?>" class="btn-edit">Edit</a>
                                    <form action="../../../../src/crud_actions/delete.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="entity" value="sector">
                                        <input type="hidden" name="sector_id" value="<?= $sector->get_id() ?>">
                                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this sector?');">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="empty-state">
                <p>No sectors found. <a href="create_sector.php">Create one now.</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>