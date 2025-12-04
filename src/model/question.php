<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../query.php';
require_once __DIR__ . '/sector.php';
require_once __DIR__ . '/question_translation.php';

class Question implements JsonSerializable
{
    private int $id;
    private Sector $sector;
    private string $text;
    private bool $status = true;

    public function __construct(
        int $id,
        Sector $sector,
        string $text,
        bool $status = true
    ) {
        $this->id = $id;
        $this->sector = $sector;
        $this->text = $text;
        $this->status = $status;
    }

    // Find a question by id statically
    public static function find_by_id(int $id): ?Question
    {
        $question_query = new Query();
        $questions = $question_query->select(TABLE_QUESTIONS, ['*'], [COLUMNS_QUESTIONS['id'] => $id]);

        // Instantiate a new question if found
        $question = $questions[0] ?? null;
        if ($question) {
            return new Question(
                $question[COLUMNS_QUESTIONS['id']],
                Sector::find_by_id($question[COLUMNS_QUESTIONS['sector_id']]),
                $question[COLUMNS_QUESTIONS['text']],
                $question[COLUMNS_QUESTIONS['status']]
            );
        }

        return null;
    }

    // Find all questions statically
    public static function find_all(): array
    {
        $question_query = new Query();
        $questions = $question_query->select(TABLE_QUESTIONS);

        // Loop through questions and instantiate them
        foreach ($questions as $key => $value) {
            $questions[$key] = new Question(
                $value[COLUMNS_QUESTIONS['id']],
                Sector::find_by_id($value[COLUMNS_QUESTIONS['sector_id']]),
                $value[COLUMNS_QUESTIONS['text']],
                $value[COLUMNS_QUESTIONS['status']]
            );
        }

        return $questions;
    }

    // Find all questions by sector statically
    public static function find_all_by_sector(int $sector_id): array
    {
        // Search for active questions by sector
        $question_query = new Query();
        $questions_result = $question_query->select(
            TABLE_QUESTIONS,
            ['*'],
            [COLUMNS_QUESTIONS['status'] => true, COLUMNS_QUESTIONS['sector_id'] => $sector_id]
        );

        // Loop through questions and instantiate them
        $questions = [];
        foreach ($questions_result as $key => $value) {
            $questions[$key] = new Question(
                $value[COLUMNS_QUESTIONS['id']],
                Sector::find_by_id($value[COLUMNS_QUESTIONS['sector_id']]),
                $value[COLUMNS_QUESTIONS['text']],
                $value[COLUMNS_QUESTIONS['status']]
            );
        }

        return $questions;
    }

    // Get the translated text for a specific question with the determined locale
    public function get_translated_text(string $locale): string
    {
        // Find the translation for the question
        $translation = QuestionTranslation::find_by_question_and_locale($this->id, $locale);

        // Return the text if found
        if ($translation) {
            return $translation->get_text();
        }

        // Fallback to the default locale
        if ($locale !== DEFAULT_LOCALE) {
            $fallback = QuestionTranslation::find_by_question_and_locale($this->id, DEFAULT_LOCALE);
            if ($fallback) {
                return $fallback->get_text();
            }
        }

        return $this->text;
    }

    // Getters
    public function get_id(): int
    {
        return $this->id;
    }
    public function get_sector(): Sector
    {
        return $this->sector;
    }
    public function get_text(): string
    {
        return $this->text;
    }
    public function is_active(): bool
    {
        return $this->status;
    }
    public function get_status(): bool
    {
        return $this->status;
    }

    // Implements JsonSerializable
    public function jsonSerialize(): array
    {
        return [
            COLUMNS_QUESTIONS['id'] => $this->id,
            COLUMNS_QUESTIONS['sector_id'] => $this->sector->get_id(),
            COLUMNS_QUESTIONS['text'] => $this->text,
            COLUMNS_QUESTIONS['status'] => $this->status,
        ];
    }
}
