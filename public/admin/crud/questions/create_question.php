<?php
require_once __DIR__ . '/../../../../src/functions/auth_required.php';
require_once __DIR__ . '/../../../../src/model/sector.php';


// Enforce authentication
auth_required('../../login.php');

$sectors = Sector::find_all();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Question</title>
</head>

<body>
    <h1>Create New Question</h1>
    <form action="../../../../src/actions/question_actions.php" method="POST">
        <input type="hidden" name="action" value="create">
        <label for="question_sector">Sector:</label>
        <select id="question_sector" name="question_sector">
            <?php foreach ($sectors as $sector) : ?>
                <option value="<?= $sector->get_id() ?>">
                    <?= htmlspecialchars($sector->get_name()) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label for="question_text">Question Text:</label>
        <input type="text" id="question_text" name="question_text" required>
        <br><br>
        <label for="question_type">Question Type:</label>
        <select id="question_type" name="question_type">
            <option value="10">10</option>
            <option value="5">5</option>
        </select>
        <br><br>
        <label for="question_status">Status:</label>
        <select id="question_status" name="question_status">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
        <br><br>
        <input type="submit" value="Create Sector">
    </form>

</body>

</html>