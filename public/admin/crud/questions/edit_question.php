<?php
require_once __DIR__ . '/../../../../src/model/sector.php';
require_once __DIR__ . '/../../../../src/model/question.php';

$base_path = '../../';
$page_title_i18n = "edit_question";

$sectors = Sector::find_all();
$question = Question::find_by_id($_GET['id']);

require_once __DIR__ . '/../../shared/header.php';
?>

<!-- Main Content -->
<div class="container">
    <div class="form-container">
        <h1 data-i18n="edit_question"></h1>
        <form action="../../../../src/crud_actions/update.php" method="POST">
            <input type="hidden" name="locale" value="<?= $current_locale ?>">
            <input type="hidden" name="entity" value="question">
            <input type="hidden" name="question_id" value="<?= $_GET['id'] ?>">

            <div class="form-group">
                <label for="question_sector" data-i18n="question_sector"></label>
                <select id="question_sector" name="question_sector" required>
                    <?php foreach ($sectors as $sector): ?>
                        <option value="<?= $sector->get_id() ?>"
                            <?php if ($sector->get_id() == $question->get_sector()->get_id()) echo 'selected'; ?>>
                            <?= htmlspecialchars($sector->get_name()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="question_text" data-i18n="question_text"></label>
                <textarea id="question_text" name="question_text" rows="4"
                    required><?= htmlspecialchars($question->get_text()) ?></textarea>
            </div>

            <div class="form-group">
                <label for="question_status" data-i18n="device_status"></label>
                <select id="question_status" name="question_status" required>
                    <option value="1" <?php if ($question->is_active()) echo 'selected'; ?> data-i18n="active"></option>
                    <option value="0" <?php if (!$question->is_active()) echo 'selected'; ?> data-i18n="inactive">
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit" data-i18n="update_question"></button>
                <a href="list_questions.php?<?= $locale_query ?>" class="btn-cancel" data-i18n="cancel"></a>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../../shared/footer.php';
?>
</body>

</html>