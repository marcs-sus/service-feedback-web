<?php
require_once __DIR__ . '/../../../../src/auth/auth_required.php';
require_once __DIR__ . '/../../../../src/model/sector.php';
require_once __DIR__ . '/../../../../src/model/question.php';

// Enforce authentication
auth_required('../../login_page.php');

$sectors = Sector::find_all();
$question = Question::find_by_id($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="stylesheet" href="../../../css/admin.css">
</head>

<body>
    <!-- Navigation -->
    <nav>
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="../../dashboard.php">Dashboard</a></li>
            <li><a href="../../evaluation_summary.php">Evaluation Summary</a></li>
            <li><a href="../sectors/list_sectors.php">Sectors</a></li>
            <li><a href="../devices/list_devices.php">Devices</a></li>
            <li><a href="list_questions.php">Questions</a></li>
            <li><a href="../../../../src/auth/logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="form-container">
            <h1>Edit Question</h1>
            <form action="../../../../src/crud_actions/update.php" method="POST">
                <input type="hidden" name="entity" value="question">
                <input type="hidden" name="question_id" value="<?= $_GET['id'] ?>">

                <div class="form-group">
                    <label for="question_sector">Sector:</label>
                    <select id="question_sector" name="question_sector" required>
                        <?php foreach ($sectors as $sector) : ?>
                            <option value="<?= $sector->get_id() ?>" <?php if ($sector->get_id() == $question->get_sector()->get_id()) echo 'selected'; ?>>
                                <?= htmlspecialchars($sector->get_name()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="question_text">Question Text:</label>
                    <textarea id="question_text" name="question_text" rows="4" required><?= htmlspecialchars($question->get_text()) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="question_status">Status:</label>
                    <select id="question_status" name="question_status" required>
                        <option value="1" <?php if ($question->is_active()) echo 'selected'; ?>>Active</option>
                        <option value="0" <?php if (!$question->is_active()) echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Update Question</button>
                    <a href="list_questions.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>