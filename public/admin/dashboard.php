<?php
require_once __DIR__ . '/../../src/model/sector.php';
require_once __DIR__ . '/../../src/model/device.php';
require_once __DIR__ . '/../../src/model/question.php';
require_once __DIR__ . '/../../src/model/evaluation.php';

// Define the base path for assets and links
$base_path = './';
$page_title_i18n = "dashboard";
$styles = ['../css/dashboard.css'];

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

require_once __DIR__ . '/shared/header.php';
?>

<!-- Main Content -->
<div class="container">
    <div class="admin-header">
        <h1 data-i18n="dashboard"></h1>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <div class="charts-header">
            <h2 data-i18n="analytics"></h2>
        </div>

        <div class="charts-container">
            <div class="chart-wrapper">
                <h3 data-i18n="score_distribution"></h3>
                <canvas id="scoreDistribution"></canvas>
            </div>
            <div class="chart-wrapper">
                <h3 data-i18n="sector_comparison"></h3>
                <canvas id="sectorComparison"></canvas>
            </div>
            <div class="chart-wrapper">
                <h3 data-i18n="question_performance"></h3>
                <canvas id="questionPerformance"></canvas>
            </div>
            <div class="chart-wrapper">
                <h3 data-i18n="device_activity"></h3>
                <canvas id="deviceActivity"></canvas>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="analytics-section">
        <div class="analytics-header">
            <h2 data-i18n="performance_averages"></h2>
            <div class="view-switcher">
                <button class="switcher-btn active" data-view="sectors" data-i18n="by_sector"></button>
                <button class="switcher-btn" data-view="questions" data-i18n="by_question"></button>
            </div>
        </div>

        <!-- Sector Averages View -->
        <div class="analytics-view active" id="view-sectors">
            <?php if (count($sector_averages) > 0): ?>
                <table class="analytics-table">
                    <thead>
                        <tr>
                            <th data-i18n="sectors"></th>
                            <th data-i18n="average_score"></th>
                            <th data-i18n="status"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sector_averages as $data): ?>
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
                                        <div class="score-fill"
                                            style="width: <?= ($data['average'] / 10) * 100 ?>%; background-color: <?= $data['average'] >= 7 ? '#80de6b' : ($data['average'] >= 5 ? '#ffd93d' : '#ff6b6b') ?>;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p data-i18n="no_evaluation_data_sectors"></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Question Averages View -->
        <div class="analytics-view" id="view-questions">
            <?php if (count($question_averages) > 0): ?>
                <table class="analytics-table">
                    <thead>
                        <tr>
                            <th data-i18n="question"></th>
                            <th data-i18n="sectors"></th>
                            <th data-i18n="average_score"></th>
                            <th data-i18n="status"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($question_averages as $data): ?>
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
                                        <div class="score-fill"
                                            style="width: <?= ($data['average'] / 10) * 100 ?>%; background-color: <?= $data['average'] >= 7 ? '#80de6b' : ($data['average'] >= 5 ? '#ffd93d' : '#ff6b6b') ?>;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p data-i18n="no_evaluation_data_questions"></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h2><?= $evaluations_count ?></h2>
            <p data-i18n="total_evaluations"></p>
            <a href="evaluation_summary.php?<?= $locale_query ?>" data-i18n="view_details"></a>
        </div>

        <div class="dashboard-card">
            <h2><?= $sectors_count ?></h2>
            <p data-i18n="total_sectors"></p>
            <a href="crud/sectors/list_sectors.php?<?= $locale_query ?>" data-i18n="manage_sectors"></a>
        </div>

        <div class="dashboard-card">
            <h2><?= $devices_count ?></h2>
            <p data-i18n="total_devices"></p>
            <a href="crud/devices/list_devices.php?<?= $locale_query ?>" data-i18n="manage_devices"></a>
        </div>

        <div class="dashboard-card">
            <h2><?= $questions_count ?></h2>
            <p data-i18n="total_questions"></p>
            <a href="crud/questions/list_questions.php?<?= $locale_query ?>" data-i18n="manage_questions"></a>
        </div>
    </div>
</div>

<script>
    // Pass data to JavaScript
    const sectors = <?= $sectors_json ?>;
    const devices = <?= $devices_json ?>;
    const questions = <?= $questions_json ?>;
    const evaluations = <?= $evaluations_json ?>;

    // Pass averages to JavaScript
    const sectorAverages = <?= $sector_averages_json ?>;
    const questionAverages = <?= $question_averages_json ?>;

    // Pass column names to JavaScript
    const sectorColumns = <?= $sector_columns ?>;
    const deviceColumns = <?= $device_columns ?>;
    const questionColumns = <?= $question_columns ?>;
    const evaluationColumns = <?= $evaluation_columns ?>;
</script>

<!-- Import Chart.js library -->
<script src="../../node_modules/chart.js/dist/chart.umd.min.js"></script>

<?php
$scripts = ["../js/dashboard.js", "../js/charts.js"];
require_once __DIR__ . '/shared/footer.php';
?>
</body>

</html>