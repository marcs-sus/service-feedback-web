<script>
    // Pass translations to JavaScript
    const translations = <?= $translations_json ?>;
    const currentLocale = '<?= $current_locale ?>';
</script>
<script src="<?= $base_path ?>../js/locale.js"></script>
<?php if (isset($scripts) && is_array($scripts)): ?>
    <?php foreach ($scripts as $script): ?>
        <script src="<?= $script ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
<script>
    document.addEventListener('DOMContentLoaded', updatePageTranslations);
</script>