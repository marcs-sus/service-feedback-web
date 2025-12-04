<?php
require_once __DIR__ . '/../config.php';

class Session
{
    private string $id;
    private bool $is_active = false;
    private int $created_at;
    private int $last_accessed_at;

    public function __construct()
    {
        $this->configure_cookie();
        $this->start_session();
    }

    // Configure secure session cookie settings
    private function configure_cookie(): void
    {
        session_set_cookie_params([
            'lifetime' => SESSION_LIFETIME,
            'path' => '/',
            'secure' => SESSION_SECURE,
            'httponly' => SESSION_HTTPONLY,
            'samesite' => SESSION_SAMESITE
        ]);
    }

    // Start a session securely and track metadata
    private function start_session(): void
    {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->id = session_id();
        $this->is_active = true;

        $this->created_at = $_SESSION['_created_at'] ?? time();
        $this->last_accessed_at = time();

        // Persist session creation time once
        if (!isset($_SESSION['_created_at'])) {
            $_SESSION['_created_at'] = $this->created_at;
        }

        // Update last accessed time
        $_SESSION['_last_accessed_at'] = $this->last_accessed_at;
    }

    // Regenerate session ID safely
    public function regenerate_id(): void
    {
        // Regenerate session ID to prevent fixation attacks
        if ($this->is_active) {
            session_regenerate_id(true);
            $this->id = session_id();
        }
    }

    // Set a value in the session
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
        $this->touch();
    }

    // Get a value from the session
    public function get(string $key, mixed $default = null): mixed
    {
        $this->touch();
        return $_SESSION[$key] ?? $default;
    }

    // Check if a key exists in the session
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    // Remove a key from the session
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
        $this->touch();
    }

    // Update last accessed time
    private function touch(): void
    {
        $this->last_accessed_at = time();
        $_SESSION['_last_accessed_at'] = $this->last_accessed_at;
    }

    // Destroy the session securely
    public function destroy(): void
    {
        if (!isset($_SESSION)) {
            return;
        }

        $_SESSION = [];

        // Invalidate the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        $this->is_active = false;
    }

    // Getters
    public function get_id(): string
    {
        return $this->id;
    }

    public function is_active(): bool
    {
        return $this->is_active && session_status() == PHP_SESSION_ACTIVE;
    }

    public function get_created_at(): int
    {
        return $this->created_at;
    }

    public function get_last_accessed_at(): int
    {
        return $this->last_accessed_at;
    }
}
