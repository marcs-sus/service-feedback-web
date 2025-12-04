<?php
require_once __DIR__ . '/../../../../src/model/sector.php';

$base_path = '../../';
$page_title_i18n = "edit_sector";

$sector = Sector::find_by_id($_GET['id']);

require_once __DIR__ . '/../../shared/header.php';
?>

<!-- Main Content -->
<div class="container">
    <div class="form-container">
        <h1 data-i18n="edit_sector"></h1>
        <form action="../../../../src/crud_actions/update.php" method="POST">
            <input type="hidden" name="locale" value="<?= $current_locale ?>">
            <input type="hidden" name="entity" value="sector">
            <input type="hidden" name="sector_id" value="<?= $_GET['id'] ?>">

            <div class="form-group">
                <label for="sector_name" data-i18n="sector_name"></label>
                <input type="text" id="sector_name" name="sector_name"
                    value="<?= htmlspecialchars($sector->get_name()) ?>" required>
            </div>

            <div class="form-group">
                <label for="sector_status" data-i18n="device_status"></label>
                <select id="sector_status" name="sector_status" required>
                    <option value="1" <?php if ($sector->is_active()) echo 'selected'; ?> data-i18n="active"></option>
                    <option value="0" <?php if (!$sector->is_active()) echo 'selected'; ?> data-i18n="inactive">
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit" data-i18n="update_sector"></button>
                <a href="list_sectors.php?<?= $locale_query ?>" class="btn-cancel" data-i18n="cancel"></a>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../../shared/footer.php';
?>
</body>

</html>