<?php
require_once __DIR__ . '/../../../../src/model/device.php';

$base_path = '../../';
$page_title_i18n = "edit_device";

$device = Device::find_by_id($_GET['id']);

require_once __DIR__ . '/../../shared/header.php';
?>

<!-- Main Content -->
<div class="container">
    <div class="form-container">
        <h1 data-i18n="edit_device"></h1>
        <form action="../../../../src/crud_actions/update.php" method="POST">
            <input type="hidden" name="locale" value="<?= $current_locale ?>">
            <input type="hidden" name="entity" value="device">
            <input type="hidden" name="device_id" value="<?= $_GET['id'] ?>">

            <div class="form-group">
                <label for="device_name" data-i18n="device_name"></label>
                <input type="text" id="device_name" name="device_name"
                    value="<?= htmlspecialchars($device->get_name()) ?>" required>
            </div>

            <div class="form-group">
                <label for="device_status" data-i18n="device_status"></label>
                <select id="device_status" name="device_status" required>
                    <option value="1" <?php if ($device->is_active()) echo 'selected'; ?> data-i18n="active"></option>
                    <option value="0" <?php if (!$device->is_active()) echo 'selected'; ?> data-i18n="inactive">
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit" data-i18n="update_device"></button>
                <a href="list_devices.php?<?= $locale_query ?>" class="btn-cancel" data-i18n="cancel"></a>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../../shared/footer.php';
?>
</body>

</html>