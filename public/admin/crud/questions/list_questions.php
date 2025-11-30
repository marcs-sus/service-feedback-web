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
    <title>Questions Management</title>
    <link rel="stylesheet" href="../../../css/admin.css">
</head>

<body>
    <!-- Navigation -->
    <nav>
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="../../dashboard.php">Dashboard</a></li>
            <li><a href="../sectors/list_sectors.php">Sectors</a></li>
            <li><a href="../devices/list_devices.php">Devices</a></li>
            <li><a href="list_questions.php">Questions</a></li>
            <li><a href="../../../../src/auth/logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="admin-header">
            <h1>Questions</h1>
            <a href="create_question.php" class="btn-primary">+ Create New Question</a>
        </div>

        <?php if (count($questions) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sector</th>
                        <th>Question Text</th>
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
                            <td>
                                <span style="color: <?= $question->is_active() ? '#28a745' : '#dc3545' ?>;">
                                    <?= $question->is_active() ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="edit_question.php?id=<?= urlencode($question->get_id()) ?>" class="btn-edit">Edit</a>
                                    <form action="../../../../src/crud_actions/delete.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="entity" value="question">
                                        <input type="hidden" name="question_id" value="<?= $question->get_id() ?>">
                                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this question?');">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="empty-state">
                <p>No questions found. <a href="create_question.php">Create one now.</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>