<?php
require_once __DIR__ . '/../../src/model/sector.php';
require_once __DIR__ . '/../../src/model/evaluation.php';
require_once __DIR__ . '/../../src/model/feedback.php';

$base_path = './';
$page_title_i18n = "evaluation_summary";
$styles = ['../css/evaluation_summary.css'];

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

require_once __DIR__ . '/shared/header.php';
?>


<!-- Main Content -->
<div class="container">
    <div class="admin-header">
        <h1 data-i18n="evaluations_feedback"></h1>
    </div>

    <!-- Sector Filter -->
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <input type="hidden" name="locale" value="<?= $current_locale ?>">
            <label for="sector_filter" data-i18n="filter_by_sector"></label>
            <select id="sector_filter" name="sector" onchange="this.form.submit()">
                <option value="" data-i18n="all_sectors"></option>
                <?php foreach ($sectors as $sector): ?>
                    <option value="<?= $sector->get_id() ?>"
                        <?= $selected_sector_id == $sector->get_id() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sector->get_name()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <!-- Evaluations Section -->
    <div class="evaluation-summary-section">
        <div class="section-header">
            <h2 data-i18n="evaluations"></h2> <span class="count">(<?= count($evaluations) ?>)</span>
        </div>
        <?php if (count($evaluations) > 0) : ?>
            <div class="evaluations-grid">
                <?php foreach ($evaluations as $evaluation) : ?>
                    <div class="evaluation-card">
                        <div class="card-header">
                            <div class="question-info">
                                <h3><?= htmlspecialchars($evaluation->get_question()->get_text()) ?></h3>
                                <p class="sector-name">
                                    <?= htmlspecialchars($evaluation->get_question()->get_sector()->get_name()) ?></p>
                            </div>
                            <div class="score-badge" data-score="<?= $evaluation->get_score() ?>">
                                <?= $evaluation->get_score() ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span class="device"><?= htmlspecialchars($evaluation->get_device()->get_name()) ?></span>
                            <span
                                class="timestamp"><?= date($locale_manager->get('date_format'), strtotime($evaluation->get_created_at())) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="empty-state">
                <p data-i18n="no_evaluations"></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Feedbacks Section -->
    <div class="evaluation-summary-section">
        <div class="section-header">
            <h2 data-i18n="feedback"></h2><span class="count">(<?= count($feedbacks) ?>)</span>
        </div>
        <?php if (count($feedbacks) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th data-i18n="sectors"></th>
                        <th data-i18n="device"></th>
                        <th data-i18n="feedback"></th>
                        <th data-i18n="date_time"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $feedback) : ?>
                        <tr class="feedback-row" onclick="toggleFeedbackExpand(this)">
                            <td><?= htmlspecialchars($feedback->get_sector()->get_name()) ?></td>
                            <td><?= htmlspecialchars($feedback->get_device()->get_name()) ?></td>
                            <td class="feedback-cell">
                                <span
                                    class="feedback-preview"><?= htmlspecialchars(substr($feedback->get_feedback_text(), 0, 100)) ?><?= strlen($feedback->get_feedback_text()) > 100 ? '...' : '' ?></span>
                                <div class="feedback-full" style="display: none;">
                                    <?= htmlspecialchars($feedback->get_feedback_text()) ?>
                                </div>
                            </td>
                            <td><?= date($locale_manager->get('date_format'), strtotime($feedback->get_created_at())) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="empty-state">
                <p data-i18n="no_feedback"></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$scripts = ['../js/evaluation_summary.js'];
require_once __DIR__ . '/shared/footer.php';
?>
</body>

</html>