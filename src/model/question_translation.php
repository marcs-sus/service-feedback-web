<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../query.php';

class QuestionTranslation
{
    private int $id;
    private int $question_id;
    private string $locale;
    private string $translated_text;
    private string $created_at;
    private string $updated_at;

    public function __construct(
        int $id,
        int $question_id,
        string $locale,
        string $translated_text,
        string $created_at,
        string $updated_at
    ) {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->locale = $locale;
        $this->translated_text = $translated_text;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Find a translation by question id and locale statically
    public static function find_by_question_and_locale(int $question_id, string $locale): ?QuestionTranslation
    {
        // Search for the translation with the question id and locale
        $query = new Query();
        $translations = $query->select(
            TABLE_QUESTION_TRANSLATIONS,
            ['*'],
            [
                COLUMNS_QUESTION_TRANSLATIONS['question_id'] => $question_id,
                COLUMNS_QUESTION_TRANSLATIONS['locale'] => $locale
            ]
        );

        // Instantiate a new translation if found
        $translation = $translations[0] ?? null;
        if ($translation) {
            return new QuestionTranslation(
                $translation[COLUMNS_QUESTION_TRANSLATIONS['id']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['question_id']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['locale']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['text']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['created_at']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['updated_at']]
            );
        }

        return null;
    }

    // Find all translations by question id statically
    public static function find_all_by_question(int $question_id): array
    {
        // Search for all translations with the question id
        $query = new Query();
        $translations = $query->select(
            TABLE_QUESTION_TRANSLATIONS,
            ['*'],
            [COLUMNS_QUESTION_TRANSLATIONS['question_id'] => $question_id]
        );

        // Loop through translations and instantiate them
        $result = [];
        foreach ($translations as $translation) {
            $result[] = new QuestionTranslation(
                $translation[COLUMNS_QUESTION_TRANSLATIONS['id']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['question_id']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['locale']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['text']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['created_at']],
                $translation[COLUMNS_QUESTION_TRANSLATIONS['updated_at']]
            );
        }

        return $result;
    }

    // Insert a translation into the database statically
    public static function create(int $question_id, string $locale, string $text): void
    {
        $query = new Query();
        $query->insert(TABLE_QUESTION_TRANSLATIONS, [
            COLUMNS_QUESTION_TRANSLATIONS['question_id'] => $question_id,
            COLUMNS_QUESTION_TRANSLATIONS['locale'] => $locale,
            COLUMNS_QUESTION_TRANSLATIONS['text'] => $text
        ]);
    }

    // Update a translation in the database statically
    public static function update(int $question_id, string $locale, string $text): void
    {
        $query = new Query();
        $query->update(
            TABLE_QUESTION_TRANSLATIONS,
            [COLUMNS_QUESTION_TRANSLATIONS['text'] => $text],
            [
                COLUMNS_QUESTION_TRANSLATIONS['question_id'] => $question_id,
                COLUMNS_QUESTION_TRANSLATIONS['locale'] => $locale
            ]
        );
    }

    // Getters
    public function get_id(): int
    {
        return $this->id;
    }
    public function get_question_id(): int
    {
        return $this->question_id;
    }
    public function get_locale(): string
    {
        return $this->locale;
    }
    public function get_text(): string
    {
        return $this->translated_text;
    }
    public function get_created_at(): string
    {
        return $this->created_at;
    }
    public function get_updated_at(): string
    {
        return $this->updated_at;
    }
}
