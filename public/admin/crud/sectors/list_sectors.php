<?php
require_once __DIR__ . '/../../../../src/model/sector.php';

$base_path = '../../';
$page_title_i18n = "sectors_management";

// Fetch all sectors from the database
$sectors = Sector::find_all();

require_once __DIR__ . '/../../shared/header.php';

$confirm_delete_message = $locale_manager->get('confirm_delete_sector');
?>

<!-- Main Content -->
<div class="container">
    <div class="admin-header">
        <h1 data-i18n="sectors_management"></h1>
        <a href="create_sector.php?<?= $locale_query ?>" class="btn-primary" data-i18n="create_new_sector"></a>
    </div>

    <?php if (count($sectors) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th data-i18n="id"></th>
                    <th data-i18n="name"></th>
                    <th data-i18n="status"></th>
                    <th data-i18n="actions"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sectors as $sector): ?>
                    <tr>
                        <td><?= htmlspecialchars($sector->get_id()) ?></td>
                        <td><?= htmlspecialchars($sector->get_name()) ?></td>
                        <td>
                            <span style="color: <?= $sector->is_active() ? '#28a745' : '#dc3545' ?>;"
                                data-i18n="<?= $sector->is_active() ? 'active' : 'inactive' ?>">
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="edit_sector.php?<?= $locale_query ?>&id=<?= urlencode($sector->get_id()) ?>" class="btn-edit"
                                    data-i18n="edit"></a>
                                <form action="../../../../src/crud_actions/delete.php" method="POST" style="margin: 0;">
                                    <input type="hidden" name="locale" value="<?= $current_locale ?>">
                                    <input type="hidden" name="entity" value="sector">
                                    <input type="hidden" name="sector_id" value="<?= $sector->get_id() ?>">
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
            <p><span data-i18n="no_sectors"></span> <a href="create_sector.php?<?= $locale_query ?>" data-i18n="create_one_now"></a></p>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../../shared/footer.php';
?>
</body>

</html>