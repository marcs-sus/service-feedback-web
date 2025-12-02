<?php
require_once __DIR__ . '/../../src/auth/auth_required.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/model/sector.php';
require_once __DIR__ . '/../../src/model/device.php';
require_once __DIR__ . '/../../src/model/question.php';
require_once __DIR__ . '/../../src/model/evaluation.php';

// Enforce authentication
auth_required('login_page.php');

// Get data for dashboard
$sectors = Sector::find_all();
$devices = Device::find_all();
$questions = Question::find_all();
$evaluations = Evaluation::find_all();

$sectors_count = count($sectors);
$devices_count = count($devices);
$questions_count = count($questions);
$evaluations_count = count($evaluations);

// Prepare data for performance averages
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

// Convert data to JSON for JavaScript
$sectors_json = json_encode($sectors);
$devices_json = json_encode($devices);
$questions_json = json_encode($questions);
$evaluations_json = json_encode($evaluations);

// Convert averages to JSON for JavaScript
$sector_averages_json = json_encode($sector_averages);
$question_averages_json = json_encode($question_averages);

// Convert column names to Json for JavaScript
$sector_columns = json_encode(COLUMNS_SECTORS);
$device_columns = json_encode(COLUMNS_DEVICES);
$question_columns = json_encode(COLUMNS_QUESTIONS);
$evaluation_columns = json_encode(COLUMNS_EVALUATIONS);
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
    <!-- Import Charts.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="charts-header">
                <h2>Charts</h2>
            </div>

            <div class="charts-container">
                <canvas id="scoreDistribution"></canvas>
            </div>
            <div class="charts-container">
                <canvas id="sectorComparison"></canvas>
            </div>
            <div class="charts-container">
                <canvas id="questionPerformance"></canvas>
            </div>
            <div class="charts-container">
                <canvas id="deviceActivity"></canvas>
            </div>
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

    <script>
        // Pass data to JavaScript
        const sectors = <?= $sectors_json ?>;
        const devices = <?= $devices_json ?>;
        const questions = <?= $questions_json ?>;
        const evaluations = <?= $evaluations_json ?>;

        // Pass counts to JavaScript
        const sectorsCount = <?= $sectors_count ?>;
        const devicesCount = <?= $devices_count ?>;
        const questionsCount = <?= $questions_count ?>;
        const evaluationsCount = <?= $evaluations_count ?>;

        // Pass averages to JavaScript
        const sectorAverages = <?= $sector_averages_json ?>;
        const questionAverages = <?= $question_averages_json ?>;

        // Pass column names to JavaScript
        const sectorColumns = <?= $sector_columns ?>;
        const deviceColumns = <?= $device_columns ?>;
        const questionColumns = <?= $question_columns ?>;
        const evaluationColumns = <?= $evaluation_columns ?>;
    </script>
    <script src="../js/charts.js"></script>
</body>

</html>