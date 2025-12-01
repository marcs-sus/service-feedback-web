<?php
require_once __DIR__ . '/../query.php';
require_once __DIR__ . '/sector.php';
require_once __DIR__ . '/question.php';
require_once __DIR__ . '/device.php';

class Evaluation
{
    private int $id;
    private Sector $sector;
    private Question $question;
    private Device $device;
    private int $score;
    private string $created_at;

    public function __construct(int $id, Sector $sector, Question $question, Device $device, int $score, string $created_at)
    {
        $this->id = $id;
        $this->sector = $sector;
        $this->question = $question;
        $this->device = $device;
        $this->score = $score;
        $this->created_at = $created_at;
    }

    public static function find_by_id(int $id): ?Evaluation
    {
        $evaluation_query = new Query();
        $evaluations = $evaluation_query->select(TABLE_EVALUATIONS, ['*'], [COLUMNS_EVALUATIONS['id'] => $id]);

        $evaluation = $evaluations[0] ?? null;
        if ($evaluation) {
            return new Evaluation(
                $evaluation[COLUMNS_EVALUATIONS['id']],
                Sector::find_by_id($evaluation[COLUMNS_EVALUATIONS['sector_id']]),
                Question::find_by_id($evaluation[COLUMNS_EVALUATIONS['question_id']]),
                Device::find_by_id($evaluation[COLUMNS_EVALUATIONS['device_id']]),
                $evaluation[COLUMNS_EVALUATIONS['score']],
                $evaluation[COLUMNS_EVALUATIONS['created_at']]
            );
        }

        return null;
    }

    public static function find_all(): array
    {
        $evaluation_query = new Query();
        $evaluations = $evaluation_query->select(TABLE_EVALUATIONS);

        foreach ($evaluations as $key => $value) {
            $evaluations[$key] = new Evaluation(
                $value[COLUMNS_EVALUATIONS['id']],
                Sector::find_by_id($value[COLUMNS_EVALUATIONS['sector_id']]),
                Question::find_by_id($value[COLUMNS_EVALUATIONS['question_id']]),
                Device::find_by_id($value[COLUMNS_EVALUATIONS['device_id']]),
                $value[COLUMNS_EVALUATIONS['score']],
                $value[COLUMNS_EVALUATIONS['created_at']]
            );
        }

        return $evaluations;
    }

    public static function find_all_by_sector(int $sector_id): array
    {
        $evaluation_query = new Query();
        $evaluations_result = $evaluation_query->select(
            TABLE_EVALUATIONS,
            ['*'],
            [COLUMNS_EVALUATIONS['sector_id'] => $sector_id]
        );

        $evaluations = [];
        foreach ($evaluations_result as $key => $value) {
            $evaluations[$key] = new Evaluation(
                $value[COLUMNS_EVALUATIONS['id']],
                Sector::find_by_id($value[COLUMNS_EVALUATIONS['sector_id']]),
                Question::find_by_id($value[COLUMNS_EVALUATIONS['question_id']]),
                Device::find_by_id($value[COLUMNS_EVALUATIONS['device_id']]),
                $value[COLUMNS_EVALUATIONS['score']],
                $value[COLUMNS_EVALUATIONS['created_at']]
            );
        }

        return $evaluations;
    }

    public static function calc_average_score_by_question(int $question_id): float
    {
        $evaluation_query = new Query();
        $evaluation_result = $evaluation_query->select(
            TABLE_EVALUATIONS,
            [COLUMNS_EVALUATIONS['score']],
            [COLUMNS_EVALUATIONS['question_id'] => $question_id]
        );

        $scores = [];
        foreach ($evaluation_result as $key => $value) {
            $scores[$key] = $value[COLUMNS_EVALUATIONS['score']];
        }

        $average = array_sum($scores) / count($scores);

        return $average;
    }

    public static function calc_average_score_by_sector(int $sector_id): float
    {
        $evaluation_query = new Query();
        $evaluation_result = $evaluation_query->select(
            TABLE_EVALUATIONS,
            [COLUMNS_EVALUATIONS['score']],
            [COLUMNS_EVALUATIONS['sector_id'] => $sector_id]
        );

        $scores = [];
        foreach ($evaluation_result as $key => $value) {
            $scores[$key] = $value[COLUMNS_EVALUATIONS['score']];
        }

        $average = array_sum($scores) / count($scores);

        return $average;
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function get_sector(): Sector
    {
        return $this->sector;
    }

    public function get_question(): Question
    {
        return $this->question;
    }

    public function get_device(): Device
    {
        return $this->device;
    }

    public function get_score(): int
    {
        return $this->score;
    }

    public function get_created_at(): string
    {
        return $this->created_at;
    }
}
