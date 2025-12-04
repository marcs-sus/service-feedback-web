<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/locales.php';
require_once __DIR__ . '/../src/model/question.php';

// Get locale from URL or default
$requested_locale = $_GET['locale'] ?? null;
$locale_manager = new LocaleManager($requested_locale);
$current_locale = $locale_manager->get_current_locale();

// Get device and sector from URL parameters, default to 1
$device_id = isset($_GET['device']) ? (int) $_GET['device'] : 1;
$sector_id = isset($_GET['sector']) ? (int) $_GET['sector'] : 1;

// Keep $_GET values in sync in case other code relies on them
$_GET['device'] = $device_id;
$_GET['sector'] = $sector_id;

// Query all questions from the database using the resolved sector id
$questions = Question::find_all_by_sector($sector_id);

// Convert questions to JSON for JavaScript
$questions_json = json_encode($questions);
$question_columns = json_encode(COLUMNS_QUESTIONS);

// Convert locale data to JSON for JavaScript
$translations = json_encode($locale_manager->get_all_translations());
$locales = json_encode($locale_manager->get_supported_locales());
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="feedback_questions"></title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <!-- Locale selector -->
    <div style="position: fixed; top: 10px; right: 10px; z-index: 999;">
        <select id="locale-selector" onchange="changeLocale(this.value)">
            <?php foreach ($locale_manager->get_supported_locales() as $code => $name): ?>
                <option value="<?= $code ?>" <?= $code === $current_locale ? 'selected' : '' ?>>
                    <?= htmlspecialchars($name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Form container -->
    <div id="form-container">
        <!-- Display form progress indicator -->
        <div id="progress-bar">
            <span id="progress-text"><span data-i18n="question"></span> <span id="current-step">1</span> <span
                    data-i18n="of"></span> <span id="total-steps">0</span></span>
            <div id="progress-bar-container">
                <div id="progress-bar-fill"></div>
            </div>
        </div>

        <!-- Question container -->
        <div id="question-container">
            <h2 id="question-text"></h2>
            <div id="scale-container"></div>
        </div>

        <!-- Feedback container -->
        <div id="feedback-container" style="display: none;">
            <h2 data-i18n="additional_feedback"></h2>
            <textarea id="feedback-text" rows="6" data-i18n-attr="placeholder"
                data-i18n-placeholder="leave_your_feedback"></textarea>
        </div>

        <!-- Navigation buttons -->
        <div id="navigation">
            <button id="btn-prev" style="display: none;" data-i18n="previous"></button>
            <button id="btn-next" disabled data-i18n="next"></button>
            <button id="btn-submit" style="display: none;" data-i18n="submit"></button>
        </div>

        <!-- Message container -->
        <div id="message-container" style="display: none;"></div>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const questions = <?= $questions_json ?>;
        const device_id = <?= $device_id ?>;
        const sector_id = <?= $sector_id ?>;
        const questionColumns = <?= $question_columns ?>;

        // Pass locale data to JavaScript
        const translations = <?= $translations ?>;
        const locales = <?= $locales ?>;
        const currentLocale = '<?= $current_locale ?>';
    </script>
    <script src="js/index.js"></script>
    <script src="js/locale.js"></script>

    <script>
        // Set translated text on page load
        document.addEventListener('DOMContentLoaded', updatePageTranslations);
    </script>
</body>
<footer>
    <h1 data-i18n="anonymous_feedback"></h1>
    <h2 data-i18n="improving_services"></h2>
</footer>

<a href="admin/login_page.php?locale=<?= $current_locale ?>" id="admin-login-link">
    <img src="assets/adm.svg" class="admin-login-icon" data-i18n-attr="alt" data-i18n-alt="admin_login" />
</a>

</html>