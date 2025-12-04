<?php
require_once __DIR__ . '/../../src/locales.php';

// Get locale from URL or default
$requested_locale = $_GET['locale'] ?? null;
$locale_manager = new LocaleManager($requested_locale);
$current_locale = $locale_manager->get_current_locale();

// Convert locale data to JSON for JavaScript
$translations = json_encode($locale_manager->get_all_translations());
$locales = json_encode($locale_manager->get_supported_locales());
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="admin_login"></title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <!-- Locale selector -->
    <div style="position: fixed; top: 10px; right: 10px; z-index: 999;">
        <select id="locale-selector" onchange="changeLocale(this.value)">
            <?php foreach ($locale_manager->get_supported_locales() as $code => $name): ?>
                <option value="<?= $code ?>" <?= $code === $current_locale ? 'selected' : '' ?>>
                    <?= htmlspecialchars($name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Form container -->
    <div id="form-container">
        <h2 data-i18n="admin_login"></h2>

        <!-- Login form -->
        <form action="../../src/auth/login.php" method="POST">
            <input type="hidden" name="locale" value="<?= $current_locale ?>">
            <div class="form-group">
                <label for="username" data-i18n="username"></label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password" data-i18n="password"></label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" data-i18n="login"></button>
        </form>

        <!-- Message container -->
        <div id="message-container" style="display: none;"></div>
    </div>

    <script>
        // Pass locale data to JavaScript
        const translations = <?= $translations ?>;
        const locales = <?= $locales ?>;
        const currentLocale = '<?= $current_locale ?>';
    </script>
    <script src="../js/locale.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');
        let loginError = null;
        if (error === 'invalid_credentials') {
            loginError = t('invalid_credentials');
        }
    </script>
    <script src="../js/login.js"></script>
    <script>
        // Set translated text on page load
        document.addEventListener('DOMContentLoaded', updatePageTranslations);
    </script>
</body>

<a href="../index.php?locale=<?= $current_locale ?>" id="form-page-link">
    <img src="../assets/form.svg" class="form-page-icon" data-i18n-attr="alt" data-i18n-alt="form_page" />
</a>

</html>