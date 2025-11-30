<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../query.php';

class Device
{
    private int $id;
    private string $name;
    private bool $status = true;

    public function __construct(int $id, string $name, bool $status = true)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
    }

    public static function find_by_id(int $id): ?Device
    {
        $device_query = new Query();
        $devices = $device_query->select(TABLE_DEVICES, ['*'], [COLUMNS_DEVICES['id'] => $id]);

        $device = $devices[0] ?? null;
        if ($device) {
            return new Device(
                $device[COLUMNS_DEVICES['id']],
                $device[COLUMNS_DEVICES['name']],
                $device[COLUMNS_DEVICES['status']]
            );
        }

        return null;
    }

    public static function find_all(): array
    {
        $device_query = new Query();
        $devices = $device_query->select(TABLE_DEVICES);

        foreach ($devices as $key => $value) {
            $devices[$key] = new Device(
                $value[COLUMNS_DEVICES['id']],
                $value[COLUMNS_DEVICES['name']],
                $value[COLUMNS_DEVICES['status']]
            );
        }

        return $devices;
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function is_active(): bool
    {
        return $this->status;
    }
}
