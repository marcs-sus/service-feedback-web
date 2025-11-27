<?php
require_once __DIR__ . '/../../../../src/functions/auth_required.php';
require_once __DIR__ . '/../../../../src/model/sector.php';

// Enforce authentication
auth_required('../../login.php');

// Fetch all sectors from the database
$sectors = Sector::find_all();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sectors</title>
</head>

<body>

    <h1>Sectors</h1>
    <a href="create_sector.php">Create New Sector</a>
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
            <?php foreach ($sectors as $sector) : ?>
                <tr>
                    <td><?= htmlspecialchars($sector->get_id()) ?></td>
                    <td><?= htmlspecialchars($sector->get_name()) ?></td>
                    <td><?= $sector->is_active() ? 'Active' : 'Inactive' ?></td>
                    <td>
                        <a href="edit_sector.php?id=<?= urlencode($sector->get_id()) ?>">
                            Edit
                        </a>
                        <form action="../../../../src/actions/sector_actions.php"
                            method="POST" style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this sector?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="sector_id" value="<?= $sector->get_id() ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>