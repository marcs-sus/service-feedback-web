<?php
require_once __DIR__ . '/../../../../src/locales.php';
require_once __DIR__ . '/../../../../src/model/question.php';
require_once __DIR__ . '/../../../../src/model/question_translation.php';

$base_path = '../../';
$page_title_i18n = "translate_question";

$question = Question::find_by_id($_GET['id']);
$requested_locale = $_GET['locale'] ?? null;
$locale_manager = new LocaleManager($requested_locale);
$current_locale = $locale_manager->get_current_locale();

// Get all translations for this question
$translations = QuestionTranslation::find_all_by_question($question->get_id());
$existing_translations = [];
foreach ($translations as $trans) {
    $existing_translations[$trans->get_locale()] = $trans->get_text();
}

require_once __DIR__ . '/../../shared/header.php';
?>

<div class="container">
    <div class="form-container">
        <h1 data-i18n="translate_question"></h1>
        <p><strong><?= htmlspecialchars($question->get_text()) ?></strong></p>

        <form action="../../../../src/crud_actions/translate_question.php" method="POST">
            <input type="hidden" name="locale" value="<?= $current_locale ?>">
            <input type="hidden" name="question_id" value="<?= $question->get_id() ?>">

            <?php foreach ($locale_manager->get_supported_locales() as $code => $name): ?>
                <div class="form-group">
                    <label for="translate_<?= $code ?>"><?= htmlspecialchars($name) ?>:</label>
                    <textarea
                        id="translate_<?= $code ?>"
                        name="translate_<?= $code ?>"
                        rows="3"><?= htmlspecialchars($existing_translations[$code] ?? '') ?></textarea>
                </div>
            <?php endforeach; ?>

            <div class="form-actions">
                <button type="submit" class="btn-submit" data-i18n="save_translations"></button>
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