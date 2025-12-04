<?php
require_once __DIR__ . '/../../../src/auth/auth_required.php';
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../../src/locales.php';

// Enforce authentication
auth_required('login_page.php');

// Get locale from URL or default
$requested_locale = $_GET['locale'] ?? null;
$locale_manager = new LocaleManager($requested_locale);
$current_locale = $locale_manager->get_current_locale();

// Convert translations to JSON for JavaScript
$translations_json = json_encode($locale_manager->get_all_translations());
$locales_json = json_encode($locale_manager->get_supported_locales());

$base_path = $base_path ?? './';
$locale_query = 'locale=' . $current_locale;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="<?= $page_title_i18n ?? 'admin_panel' ?>"></title>
    <link rel="stylesheet" href="<?= $base_path ?>../css/admin.css">
    <?php if (isset($styles) && is_array($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" href="<?= $style ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
    <!-- Navigation -->
    <nav>
        <h1 data-i18n="admin_panel"></h1>
        <ul>
            <li><a href="<?= $base_path ?>dashboard.php?<?= $locale_query ?>" data-i18n="dashboard"></a></li>
            <li><a href="<?= $base_path ?>evaluation_summary.php?<?= $locale_query ?>"
                    data-i18n="evaluation_summary"></a></li>
            <li><a href="<?= $base_path ?>crud/sectors/list_sectors.php?<?= $locale_query ?>"
                    data-i18n="sectors"></a></li>
            <li><a href="<?= $base_path ?>crud/devices/list_devices.php?<?= $locale_query ?>"
                    data-i18n="devices"></a></li>
            <li><a href="<?= $base_path ?>crud/questions/list_questions.php?<?= $locale_query ?>"
                    data-i18n="questions"></a></li>
            <li><a href="<?= $base_path ?>../../src/auth/logout.php?<?= $locale_query ?>" data-i18n="logout"></a></li>
            <li>
                <select id="locale-selector" onchange="changeLocale(this.value)" style="margin-left: auto;">
                    <?php foreach ($locale_manager->get_supported_locales() as $code => $name): ?>
                        <option value="<?= $code ?>" <?= $code === $current_locale ? 'selected' : '' ?>>
                            <?= htmlspecialchars($name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </li>
        </ul>
    </nav>