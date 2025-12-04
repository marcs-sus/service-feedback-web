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

    private function validate_locale(string $locale): string
    {
        return isset(self::SUPPORTED_LOCALES[$locale]) ? $locale : $this->get_default_locale();
    }

    public function load_translations(): void
    {
        $file = __DIR__ . "/locales/{$this->current_locale}.json";

        if (file_exists($file)) {
            $this->translations = json_decode(file_get_contents($file), true) ?? [];
        }
    }

    public function get(string $key, string $default = ''): string
    {
        return $this->translations[$key] ?? $default;
    }

    public function get_current_locale(): string
    {
        return $this->current_locale;
    }

    public function get_supported_locales(): array
    {
        return self::SUPPORTED_LOCALES;
    }

    public function get_all_translations(): array
    {
        return $this->translations;
    }

    public static function get_default_locale(): string
    {
        return defined('DEFAULT_LOCALE') ? DEFAULT_LOCALE : 'en_US';
    }
}
