<?php
require_once __DIR__ . '/../src/locales.php';

// Get locale from URL or default
$requested_locale = $_GET['locale'] ?? null;
$locale_manager = new LocaleManager($requested_locale);
$current_locale = $locale_manager->get_current_locale();

// Get device and sector from URL parameters, with defaults
$device_id = $_GET['device'] ?? 1;
$sector_id = $_GET['sector'] ?? 1;

// Build the redirect URL with the parameters
$redirect_url = "index.php?" .
    "device=" . urlencode($device_id) .
    "&sector=" . urlencode($sector_id) .
    "&locale=" . urlencode($current_locale);

// Convert locale data to JSON for JavaScript
$translations = json_encode($locale_manager->get_all_translations());
$locales = json_encode($locale_manager->get_supported_locales());
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="thank_you">Thank You!</title>
    <link rel="stylesheet" href="css/thank.css">
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

    <!-- Thank You Container -->
    <div class="thank-container">
        <h1 data-i18n="thank_you"></h1>
        <h2 data-i18n="improving_services"></h2>
    </div>

    <script>
        // Pass locale data to JavaScript
        const translations = <?= $translations ?>;
        const locales = <?= $locales ?>;
        const currentLocale = '<?= $current_locale ?>';

        setTimeout(function() {
            window.location.href = '<?= $redirect_url ?>';
        }, 5000);
    </script>
    <script src="js/locale.js"></script>
    <script>
        // Set translated text on page load
        document.addEventListener('DOMContentLoaded', updatePageTranslations);
    </script>
</body>

</html>