<?php
require_once __DIR__ . '/../../src/auth/auth_required.php';
require_once __DIR__ . '/../../src/model/sector.php';
require_once __DIR__ . '/../../src/model/device.php';
require_once __DIR__ . '/../../src/model/question.php';
require_once __DIR__ . '/../../src/model/evaluation.php';

// Enforce authentication
auth_required('login_page.php');

// Get counts for dashboard
$sectors = Sector::find_all();
$devices = Device::find_all();
$questions = Question::find_all();

$sectors_count = count($sectors);
$devices_count = count($devices);
$questions_count = count($questions);

// Prepare data for analytics
$sector_averages = [];
$question_averages = [];

foreach ($sectors as $sector) {
    try {
        $avg = Evaluation::calc_average_score_by_sector($sector->get_id());
        $sector_averages[] = [
            'sector' => $sector,
            'average' => round($avg, 2)
        ];
    } catch (Exception $ex) {
        // Handle case where sector has no evaluations
        $sector_averages[] = [
            'sector' => $sector,
            'average' => 0
        ];
    }
}

foreach ($questions as $question) {
    try {
        $avg = Evaluation::calc_average_score_by_question($question->get_id());
        $question_averages[] = [
            'question' => $question,
            'average' => round($avg, 2)
        ];
    } catch (Exception $ex) {
        // Handle case where question has no evaluations
        $question_averages[] = [
            'question' => $question,
            'average' => 0
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/dashboard.css">
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
            <h1>Dashboard</h1>
        </div>

        <!-- Analytics Section -->
        <div class="analytics-section">
            <div class="analytics-header">
                <h2>Performance Averages</h2>
                <div class="view-switcher">
                    <button class="switcher-btn active" data-view="sectors">By Sector</button>
                    <button class="switcher-btn" data-view="questions">By Question</button>
                </div>
            </div>

            <!-- Sector Averages View -->
            <div class="analytics-view active" id="view-sectors">
                <?php if (count($sector_averages) > 0) : ?>
                    <table class="analytics-table">
                        <thead>
                            <tr>
                                <th>Sector</th>
                                <th>Average Score</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sector_averages as $data) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($data['sector']->get_name()) ?></td>
                                    <td>
                                        <div class="score-display">
                                            <span class="score-value"><?= $data['average'] ?></span>
                                            <span class="score-max">/10</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="score-bar">
                                            <div class="score-fill" style="width: <?= ($data['average'] / 10) * 100 ?>%; background-color: <?= $data['average'] >= 7 ? '#80de6b' : ($data['average'] >= 5 ? '#ffd93d' : '#ff6b6b') ?>;">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="empty-state">
                        <p>No evaluation data available for sectors yet.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Question Averages View -->
            <div class="analytics-view" id="view-questions">
                <?php if (count($question_averages) > 0) : ?>
                    <table class="analytics-table">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Sector</th>
                                <th>Average Score</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($question_averages as $data) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($data['question']->get_text()) ?></td>
                                    <td><?= htmlspecialchars($data['question']->get_sector()->get_name()) ?></td>
                                    <td>
                                        <div class="score-display">
                                            <span class="score-value"><?= $data['average'] ?></span>
                                            <span class="score-max">/10</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="score-bar">
                                            <div class="score-fill" style="width: <?= ($data['average'] / 10) * 100 ?>%; background-color: <?= $data['average'] >= 7 ? '#80de6b' : ($data['average'] >= 5 ? '#ffd93d' : '#ff6b6b') ?>;">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="empty-state">
                        <p>No evaluation data available for questions yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h2><?= $sectors_count ?></h2>
                <p>Total Sectors</p>
                <a href="crud/sectors/list_sectors.php">Manage Sectors</a>
            </div>

            <div class="dashboard-card">
                <h2><?= $devices_count ?></h2>
                <p>Total Devices</p>
                <a href="crud/devices/list_devices.php">Manage Devices</a>
            </div>

            <div class="dashboard-card">
                <h2><?= $questions_count ?></h2>
                <p>Total Questions</p>
                <a href="crud/questions/list_questions.php">Manage Questions</a>
            </div>
        </div>
    </div>

    <script src="../js/dashboard.js"></script>
</body>

</html>