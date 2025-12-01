<?php
require_once __DIR__ . '/../../src/auth/auth_required.php';
require_once __DIR__ . '/../../src/model/sector.php';
require_once __DIR__ . '/../../src/model/evaluation.php';
require_once __DIR__ . '/../../src/model/feedback.php';

// Enforce authentication
auth_required('login_page.php');

// Get sector filter from URL parameter
$selected_sector_id = isset($_GET['sector']) ? (int) $_GET['sector'] : null;

// Fetch all sectors for dropdown
$sectors = Sector::find_all();

// Fetch evaluations and feedbacks based on filter
if ($selected_sector_id) {
    $evaluations = Evaluation::find_all_by_sector($selected_sector_id);
    $feedbacks = Feedback::find_all_by_sector($selected_sector_id);
} else {
    $evaluations = Evaluation::find_all();
    $feedbacks = Feedback::find_all();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluations & Feedback</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/evaluation_summary.css">
</head>

<body>
    <!-- Navigation -->
    <nav>
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="evaluation_summary.php">Evaluation Summary</a></li>
            <li><a href="crud/sectors/list_sectors.php">Sectors</a></li>
            <li><a href="crud/devices/list_devices.php">Devices</a></li>
            <li><a href="crud/questions/list_questions.php">Questions</a></li>
            <li><a href="../../src/auth/logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="admin-header">
            <h1>Evaluations & Feedback</h1>
        </div>

        <!-- Sector Filter -->
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <label for="sector_filter">Filter by Sector:</label>
                <select id="sector_filter" name="sector" onchange="this.form.submit()">
                    <option value="">-- All Sectors --</option>
                    <?php foreach ($sectors as $sector) : ?>
                        <option value="<?= $sector->get_id() ?>" <?php if ($selected_sector_id == $sector->get_id()) echo 'selected'; ?>>
                            <?= htmlspecialchars($sector->get_name()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <!-- Evaluations Section -->
        <div class="evaluation-summary-section">
            <div class="section-header">
                <h2>Evaluations <span class="count">(<?= count($evaluations) ?>)</span></h2>
            </div>

            <?php if (count($evaluations) > 0) : ?>
                <div class="evaluations-grid">
                    <?php foreach ($evaluations as $evaluation) : ?>
                        <div class="evaluation-card">
                            <div class="card-header">
                                <div class="question-info">
                                    <h3><?= htmlspecialchars($evaluation->get_question()->get_text()) ?></h3>
                                    <p class="sector-name"><?= htmlspecialchars($evaluation->get_question()->get_sector()->get_name()) ?></p>
                                </div>
                                <div class="score-badge" data-score="<?= $evaluation->get_score() ?>">
                                    <?= $evaluation->get_score() ?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span class="device"><?= htmlspecialchars($evaluation->get_device()->get_name()) ?></span>
                                <span class="timestamp"><?= date('d/m/Y H:i', strtotime($evaluation->get_created_at())) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="empty-state">
                    <p>No evaluations found.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Feedbacks Section -->
        <div class="evaluation-summary-section">
            <div class="section-header">
                <h2>Feedback <span class="count">(<?= count($feedbacks) ?>)</span></h2>
            </div>

            <?php if (count($feedbacks) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Sector</th>
                            <th>Device</th>
                            <th>Feedback</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedbacks as $feedback) : ?>
                            <tr class="feedback-row" onclick="toggleFeedbackExpand(this)">
                                <td><?= htmlspecialchars($feedback->get_sector()->get_name()) ?></td>
                                <td><?= htmlspecialchars($feedback->get_device()->get_name()) ?></td>
                                <td class="feedback-cell">
                                    <span class="feedback-preview"><?= htmlspecialchars(substr($feedback->get_feedback_text(), 0, 100)) ?><?= strlen($feedback->get_feedback_text()) > 100 ? '...' : '' ?></span>
                                    <div class="feedback-full" style="display: none;">
                                        <?= htmlspecialchars($feedback->get_feedback_text()) ?>
                                    </div>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($feedback->get_created_at())) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="empty-state">
                    <p>No feedback found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="../js/evaluation_summary.js"></script>
</body>

</html>