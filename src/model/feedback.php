<?php
require_once __DIR__ . '/../query.php';
require_once __DIR__ . '/sector.php';
require_once __DIR__ . '/device.php';

class Feedback
{
    private int $id;
    private Sector $sector;
    private Device $device;
    private string $feedback_text;
    private string $created_at;

    public function __construct(int $id, Sector $sector, Device $device, string $feedback_text, string $created_at)
    {
        $this->id = $id;
        $this->sector = $sector;
        $this->device = $device;
        $this->feedback_text = $feedback_text;
        $this->created_at = $created_at;
    }

    public static function find_by_id(int $id): ?Feedback
    {
        $feedback_query = new Query();
        $feedbacks = $feedback_query->select(TABLE_FEEDBACK, ['*'], [COLUMNS_FEEDBACK['id'] => $id]);

        $feedbacks = $feedbacks[0] ?? null;
        if ($feedbacks) {
            return new Feedback(
                $feedbacks[COLUMNS_FEEDBACK['id']],
                Sector::find_by_id($feedbacks[COLUMNS_FEEDBACK['sector_id']]),
                Device::find_by_id($feedbacks[COLUMNS_FEEDBACK['device_id']]),
                $feedbacks[COLUMNS_FEEDBACK['text']],
                $feedbacks[COLUMNS_FEEDBACK['created_at']]
            );
        }

        return null;
    }

    public static function find_all(): array
    {
        $feedback_query = new Query();
        $feedbacks = $feedback_query->select(TABLE_FEEDBACK);

        foreach ($feedbacks as $key => $value) {
            $feedbacks[$key] = new Feedback(
                $value[COLUMNS_FEEDBACK['id']],
                Sector::find_by_id($value[COLUMNS_FEEDBACK['sector_id']]),
                Device::find_by_id($value[COLUMNS_FEEDBACK['device_id']]),
                $value[COLUMNS_FEEDBACK['text']],
                $value[COLUMNS_FEEDBACK['created_at']]
            );
        }

        return $feedbacks;
    }

    public static function find_all_by_sector(int $sector_id): array
    {
        $feedback_query = new Query();
        $feedbacks = $feedback_query->select(
            TABLE_FEEDBACK,
            ['*'],
            [COLUMNS_FEEDBACK['sector_id'] => $sector_id]
        );

        foreach ($feedbacks as $key => $value) {
            $feedbacks[$key] = new Feedback(
                $value[COLUMNS_FEEDBACK['id']],
                Sector::find_by_id($value[COLUMNS_FEEDBACK['sector_id']]),
                Device::find_by_id($value[COLUMNS_FEEDBACK['device_id']]),
                $value[COLUMNS_FEEDBACK['text']],
                $value[COLUMNS_FEEDBACK['created_at']]
            );
        }

        return $feedbacks;
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function get_sector(): Sector
    {
        return $this->sector;
    }

    public function get_device(): Device
    {
        return $this->device;
    }

    public function get_feedback_text(): string
    {
        return $this->feedback_text;
    }

    public function get_created_at(): string
    {
        return $this->created_at;
    }
}
