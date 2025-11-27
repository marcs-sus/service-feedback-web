<?php
require_once __DIR__ . '/../../../../src/functions/auth_required.php';
require_once __DIR__ . '/../../../../src/model/sector.php';
require_once __DIR__ . '/../../../../src/model/question.php';

// Enforce authentication
auth_required('../../login.php');

$sectors = Sector::find_all();
$question = Question::find_by_id($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
</head>

<body>
    <h1>Edit Question</h1>
    <form action="../../../../src/actions/question_actions.php" method="POST">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="question_id" value="<?= $_GET['id'] ?>">
        <label for="question_sector">Sector:</label>
        <select id="question_sector" name="question_sector">
            <?php foreach ($sectors as $sector) : ?>
                <option value="<?= $sector->get_id() ?>" <?php if ($sector->get_id() == $question->get_sector()->get_id()) echo 'selected'; ?>>
                    <?= htmlspecialchars($sector->get_name()) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label for="question_text">Question Text:</label>
        <input type="text" id="question_text" name="question_text" value="<?= htmlspecialchars($question->get_text()) ?>">
        <br><br>
        <label for="question_type">Scale Type:</label>
        <select id="question_type" name="question_type">
            <option value="10" <?php if ($question->get_scale_type() == '10') echo 'selected'; ?>>10</option>
            <option value="5" <?php if ($question->get_scale_type() == '5') echo 'selected'; ?>>5</option>
        </select>
        <br><br>
        <label for="question_status">Status:</label>
        <select id="question_status" name="question_status">
            <option value="1" <?php if ($question->is_active()) echo 'selected'; ?>>Active</option>
            <option value="0" <?php if (!$question->is_active()) echo 'selected'; ?>>Inactive</option>
        </select>
        <br><br>
        <input type="submit" value="Update Question">
    </form>

</body>

</html>