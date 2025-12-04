<?php
$base_path = '../../';
$page_title_i18n = "create_sector";

require_once __DIR__ . '/../../shared/header.php';
?>

<!-- Main Content -->
<div class="container">
    <div class="form-container">
        <h1 data-i18n="create_sector"></h1>
        <form action="../../../../src/crud_actions/create.php" method="POST">
            <input type="hidden" name="locale" value="<?= $current_locale ?>">
            <input type="hidden" name="entity" value="sector">

            <div class="form-group">
                <label for="sector_name" data-i18n="sector_name"></label>
                <input type="text" id="sector_name" name="sector_name" required>
            </div>

            <div class="form-group">
                <label for="sector_status" data-i18n="device_status"></label>
                <select id="sector_status" name="sector_status" required>
                    <option value="1" data-i18n="active"></option>
                    <option value="0" data-i18n="inactive"></option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit" data-i18n="create_sector_btn"></button>
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