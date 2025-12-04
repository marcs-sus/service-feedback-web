<?php
require_once __DIR__ . '/../../../../src/model/sector.php';

$base_path = '../../';
$page_title_i18n = "create_question";

$sectors = Sector::find_all();

require_once __DIR__ . '/../../shared/header.php';
?>

<!-- Main Content -->
<div class="container">
    <div class="form-container">
        <h1 data-i18n="create_question"></h1>
        <form action="../../../../src/crud_actions/create.php" method="POST">
            <input type="hidden" name="locale" value="<?= $current_locale ?>">
            <input type="hidden" name="entity" value="question">

            <div class="form-group">
                <label for="question_sector" data-i18n="question_sector"></label>
                <select id="question_sector" name="question_sector" required>
                    <option value="" data-i18n="select_sector"></option>
                    <?php foreach ($sectors as $sector): ?>
                        <option value="<?= $sector->get_id() ?>">
                            <?= htmlspecialchars($sector->get_name()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="question_text" data-i18n="question_text"></label>
                <textarea id="question_text" name="question_text" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="question_status" data-i18n="device_status"></label>
                <select id="question_status" name="question_status" required>
                    <option value="1" data-i18n="active"></option>
                    <option value="0" data-i18n="inactive"></option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit" data-i18n="create_question_btn"></button>
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