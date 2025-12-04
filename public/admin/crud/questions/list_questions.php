<?php
require_once __DIR__ . '/../../../../src/model/sector.php';
require_once __DIR__ . '/../../../../src/model/question.php';

$base_path = '../../';
$page_title_i18n = "questions_management";

// Fetch all questions from the database
$questions = Question::find_all();

require_once __DIR__ . '/../../shared/header.php';

$confirm_delete_message = $locale_manager->get('confirm_delete_question');
?>

<!-- Main Content -->
<div class="container">
    <div class="admin-header">
        <h1 data-i18n="questions_management"></h1>
        <a href="create_question.php?<?= $locale_query ?>" class="btn-primary" data-i18n="create_new_question"></a>
    </div>

    <?php if (count($questions) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th data-i18n="id"></th>
                    <th data-i18n="sectors"></th>
                    <th data-i18n="question"></th>
                    <th data-i18n="status"></th>
                    <th data-i18n="actions"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?= htmlspecialchars($question->get_id()) ?></td>
                        <td><?= htmlspecialchars($question->get_sector()->get_name()) ?></td>
                        <td><?= htmlspecialchars($question->get_text()) ?></td>
                        <td>
                            <span style="color: <?= $question->is_active() ? '#28a745' : '#dc3545' ?>;"
                                data-i18n="<?= $question->is_active() ? 'active' : 'inactive' ?>">
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="translate_question.php?id=<?= urlencode($question->get_id()) ?>&<?= $locale_query ?>"
                                    class="btn-edit" data-i18n="translate" title="Translate question"></a>
                                <a href="edit_question.php?id=<?= urlencode($question->get_id()) ?>&<?= $locale_query ?>"
                                    class="btn-edit" data-i18n="edit"></a>
                                <form action="../../../../src/crud_actions/delete.php" method="POST" style="margin: 0;">
                                    <input type="hidden" name="locale" value="<?= $current_locale ?>">
                                    <input type="hidden" name="entity" value="question">
                                    <input type="hidden" name="question_id" value="<?= $question->get_id() ?>">
                                    <button type="submit" class="btn-delete"
                                        onclick="return confirm('<?= $confirm_delete_message ?>');" data-i18n="delete"></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <p><span data-i18n="no_questions"></span> <a href="create_question.php?<?= $locale_query ?>"
                    data-i18n="create_one_now"></a></p>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../../shared/footer.php';
?>
</body>

</html>