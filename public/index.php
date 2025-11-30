<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/model/question.php';

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
$columns_json = json_encode(COLUMNS_QUESTIONS);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Questions</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div id="form-container">
        <!-- Display form progress indicator -->
        <div id="progress-bar">
            <span id="progress-text">Question <span id="current-step">1</span> of <span id="total-steps">0</span></span>
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
            <h2>Additional Feedback (Optional)</h2>
            <textarea id="feedback-text" rows="6" placeholder="Leave your feedback here..."></textarea>
        </div>

        <!-- Navigation buttons -->
        <div id="navigation">
            <button id="btn-prev" style="display: none;">Previous</button>
            <button id="btn-next" disabled>Next</button>
            <button id="btn-submit" style="display: none;">Submit</button>
        </div>

        <!-- Message container -->
        <div id="message-container" style="display: none;"></div>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const questions = <?= $questions_json ?>;
        const device_id = <?= $device_id ?>;
        const sector_id = <?= $sector_id ?>;
        const COLUMNS = <?= $columns_json ?>;
    </script>
    <script src="js/index.js"></script>
</body>
<footer>
    <h1>Your spontaneous review is anonymous, no personal information is requested or stored.</h1>
</footer>

<a href="admin/login_page.php" id="admin-login-link">
    <img src="assets/adm.svg" alt="Admin Login" class="admin-login-icon" />
</a>

</html>