<?php
require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/functions/postgres.php';
require_once __DIR__ . '/../src/functions/questions.php';

// Query all questions from the database
$questions = get_all_questions();

// Convert questions to JSON for JavaScript
$questions_json = json_encode($questions);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Questions</title>
    <link rel="stylesheet" href="css/form.css">
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
        const COLUMNS = {
            id: '<?= COLUMNS_QUESTIONS['id'] ?>',
            text: '<?= COLUMNS_QUESTIONS['text'] ?>',
        };
    </script>
    <script src="js/form.js"></script>
</body>
<footer>
    <h1>Your spontaneous review is anonymous, no personal information is requested or stored.</h1>
</footer>

</html>