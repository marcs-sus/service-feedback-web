<?php
require_once __DIR__ . '/../../config.php';

class Sector
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

    public static function find_by_id(int $id): ?Sector
    {
        $sector_query = new Query();
        $sectors = $sector_query->select(TABLE_SECTORS, ['*'], [COLUMNS_SECTORS['id'] => $id]);

        $sector = $sectors[0] ?? null;
        if ($sector) {
            return new Sector(
                $sector[COLUMNS_SECTORS['id']],
                $sector[COLUMNS_SECTORS['name']],
                $sector[COLUMNS_SECTORS['status']]
            );
        }

        return null;
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
