<?php
require_once __DIR__ . '/../config.php';

class LocaleManager
{
    private const SUPPORTED_LOCALES = [
        'en_US' => 'English',
        'pt_BR' => 'Português (Brasil)',
    ];

    private array $translations = [];
    private string $current_locale;

    public function __construct(?string $locale = null)
    {
        $this->current_locale = $this->validate_locale($locale ?? $this->get_default_locale());
        $this->load_translations();
    }

    // Validate if locale is supported
    private function validate_locale(string $locale): string
    {
        return isset(self::SUPPORTED_LOCALES[$locale]) ? $locale : $this->get_default_locale();
    }

    // Load words/phrases translations from json file
    public function load_translations(): void
    {
        $file = __DIR__ . "/locales/{$this->current_locale}.json";

        if (file_exists($file)) {
            $this->translations = json_decode(file_get_contents($file), true) ?? [];
        }
    }

    // Get translation
    public function get(string $key, string $default = ''): string
    {
        return $this->translations[$key] ?? $default;
    }

    // Get the current active locale
    public function get_current_locale(): string
    {
        return $this->current_locale;
    }

    // Get all supported locales
    public function get_supported_locales(): array
    {
        return self::SUPPORTED_LOCALES;
    }

    // Get all translations for all locales
    public function get_all_translations(): array
    {
        return $this->translations;
    }

    // Get default locale specified in config
    public static function get_default_locale(): string
    {
        return defined('DEFAULT_LOCALE') ? DEFAULT_LOCALE : 'en_US';
    }
}
