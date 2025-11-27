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
