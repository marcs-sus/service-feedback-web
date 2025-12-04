<?php
require_once __DIR__ . '/../../../../src/model/device.php';

$base_path = '../../';
$page_title_i18n = "devices_management";

// Fetch all devices from the database
$devices = Device::find_all();

require_once __DIR__ . '/../../shared/header.php';

$confirm_delete_message = $locale_manager->get('confirm_delete_device');
?>

<!-- Main Content -->
<div class="container">
    <div class="admin-header">
        <h1 data-i18n="devices_management"></h1>
        <a href="create_device.php?<?= $locale_query ?>" class="btn-primary" data-i18n="create_new_device"></a>
    </div>

    <?php if (count($devices) > 0): ?>
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
                <?php foreach ($devices as $device): ?>
                    <tr>
                        <td><?= htmlspecialchars($device->get_id()) ?></td>
                        <td><?= htmlspecialchars($device->get_name()) ?></td>
                        <td>
                            <span style="color: <?= $device->is_active() ? '#28a745' : '#dc3545' ?>;"
                                data-i18n="<?= $device->is_active() ? 'active' : 'inactive' ?>">
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="edit_device.php?id=<?= urlencode($device->get_id()) ?>&<?= $locale_query ?>"
                                    class="btn-edit" data-i18n="edit"></a>
                                <form action="../../../../src/crud_actions/delete.php" method="POST" style="margin: 0;">
                                    <input type="hidden" name="locale" value="<?= $current_locale ?>">
                                    <input type="hidden" name="entity" value="device">
                                    <input type="hidden" name="device_id" value="<?= $device->get_id() ?>">
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
            <p><span data-i18n="no_devices"></span> <a href="create_device.php?<?= $locale_query ?>"
                    data-i18n="create_one_now"></a></p>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../../shared/footer.php';
?>
</body>

</html>