<?php
require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/functions/postgres.php';
require_once __DIR__ . '/../src/functions/questions.php';

// Query all questions from the database
$questions = get_all_questions();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Questions</title>
</head>

<body>
    <h1>Questions</h1>

    <?php if (!empty($questions)) : ?>
        <ul>
            <?php foreach ($questions as $question) : ?>
                <li><?= htmlspecialchars($question[COLUMNS_QUESTIONS['text']]); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No questions found in the database.</p>
    <?php endif;
    ?>
</body>

</html>