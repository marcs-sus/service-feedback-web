<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/sector.php';

class Question
{
    private int $id;
    private Sector $sector;
    private string $text;
    private int $scale_type = 10;
    private bool $status = true;

    public function __construct(int $id, Sector $sector, string $text, int $scale_type = 10, bool $status = true)
    {
        $this->id = $id;
        $this->sector = $sector;
        $this->text = $text;
        $this->scale_type = $scale_type;
        $this->status = $status;
    }

    public static function find_by_id(int $id): ?Question
    {
        $question_query = new Query();
        $questions = $question_query->select(TABLE_QUESTIONS, ['*'], [COLUMNS_QUESTIONS['id'] => $id]);

        $question = $questions[0] ?? null;
        if ($question) {
            return new Question(
                $question[COLUMNS_QUESTIONS['id']],
                Sector::find_by_id($question[COLUMNS_QUESTIONS['sector_id']]),
                $question[COLUMNS_QUESTIONS['text']],
                $question[COLUMNS_QUESTIONS['type']],
                $question[COLUMNS_QUESTIONS['status']]
            );
        }

        return null;
    }

    public static function find_all(): array
    {
        $question_query = new Query();
        $questions = $question_query->select(TABLE_QUESTIONS);

        foreach ($questions as $key => $value) {
            $questions[$key] = new Question(
                $value[COLUMNS_QUESTIONS['id']],
                Sector::find_by_id($value[COLUMNS_QUESTIONS['sector_id']]),
                $value[COLUMNS_QUESTIONS['text']],
                $value[COLUMNS_QUESTIONS['type']],
                $value[COLUMNS_QUESTIONS['status']]
            );
        }

        return $questions;
    }

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

    public function get_scale_type(): int
    {
        return $this->scale_type;
    }

    public function is_active(): bool
    {
        return $this->status;
    }

    public function get_status(): bool
    {
        return $this->status;
    }
}
