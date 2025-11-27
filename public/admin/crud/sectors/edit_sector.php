<?php
require_once __DIR__ . '/../../../../src/functions/auth_required.php';
require_once __DIR__ . '/../../../../src/model/sector.php';

// Enforce authentication
auth_required('../../login.php');

$sector = Sector::find_by_id($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sector</title>
</head>

<body>
    <h1>Edit Sector</h1>
    <form action="../../../../src/actions/sector_actions.php" method="POST">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="sector_id" value="<?= $_GET['id'] ?>">
        <label for="sector_name">Sector Name:</label>
        <input type="text" id="sector_name" name="sector_name" value="<?= $sector->get_name() ?>" required>
        <br><br>
        <label for="sector_status">Status:</label>
        <select id="sector_status" name="sector_status">
            <option value="1" <?php if ($sector->is_active()) echo 'selected'; ?>>Active</option>
            <option value="0" <?php if (!$sector->is_active()) echo 'selected'; ?>>Inactive</option>
        </select>
        <br><br>
        <input type="submit" value="Update Sector">
    </form>

</body>

</html>