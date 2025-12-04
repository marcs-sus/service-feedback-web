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

    public function __construct(int $id, int $question_id, string $locale, string $translated_text, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->locale = $locale;
        $this->translated_text = $translated_text;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function find_by_question_and_locale(int $question_id, string $locale): ?QuestionTranslation
    {
        $query = new Query();
        $translations = $query->select(
            TABLE_QUESTION_TRANSLATIONS,
            ['*'],
            [
                COLUMNS_QUESTION_TRANSLATIONS['question_id'] => $question_id,
                COLUMNS_QUESTION_TRANSLATIONS['locale'] => $locale
            ]
        );

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

    public static function find_all_by_question(int $question_id): array
    {
        $query = new Query();
        $translations = $query->select(
            TABLE_QUESTION_TRANSLATIONS,
            ['*'],
            [COLUMNS_QUESTION_TRANSLATIONS['question_id'] => $question_id]
        );

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

    public static function create(int $question_id, string $locale, string $text): void
    {
        $query = new Query();
        $query->insert(TABLE_QUESTION_TRANSLATIONS, [
            COLUMNS_QUESTION_TRANSLATIONS['question_id'] => $question_id,
            COLUMNS_QUESTION_TRANSLATIONS['locale'] => $locale,
            COLUMNS_QUESTION_TRANSLATIONS['text'] => $text
        ]);
    }

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
