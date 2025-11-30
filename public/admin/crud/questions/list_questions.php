<?php
require_once __DIR__ . '/../../../../src/auth/auth_required.php';
require_once __DIR__ . '/../../../../src/model/sector.php';
require_once __DIR__ . '/../../../../src/model/question.php';

// Enforce authentication
auth_required('../../login_page.php');

// Fetch all questions from the database
$questions = Question::find_all();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions</title>
</head>

<body>

    <h1>Questions</h1>
    <a href="create_question.php">Create New Question</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sector Name</th>
                <th>Text</th>
                <th>Scale Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question) : ?>
                <tr>
                    <td><?= htmlspecialchars($question->get_id()) ?></td>
                    <td><?= htmlspecialchars($question->get_sector()->get_name()) ?></td>
                    <td><?= htmlspecialchars($question->get_text()) ?></td>
                    <td><?= htmlspecialchars($question->get_scale_type()) ?></td>
                    <td><?= $question->is_active() ? 'Active' : 'Inactive' ?></td>
                    <td>
                        <a href="edit_question.php?id=<?= urlencode($question->get_id()) ?>">
                            Edit
                        </a>
                        <form action="../../../../src/crud_actions/delete.php"
                            method="POST" style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this question?');">
                            <input type="hidden" name="entity" value="question">
                            <input type="hidden" name="question_id" value="<?= $question->get_id() ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>