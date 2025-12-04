<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../session.php';
require_once __DIR__ . '/../model/user.php';

class Auth
{
    private Session $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    // Login the user and return true if successful
    public function login(string $username, string $password): bool
    {
        // Find user by username
        $user = User::find_by_username($username);

        // Check if user exists and password matches
        if ($user && password_verify($password, $user->get_password_hash())) {
            $this->session->regenerate_id();
            $this->session->set(COLUMNS_ADMIN_USERS['id'], $user->get_id());

            return true;
        }

        return false;
    }

    // Logout the user
    public function logout(): void
    {
        $this->session->destroy();
    }

    // Check if the user is authenticated
    public function is_authenticated(): bool
    {
        return $this->session->has(COLUMNS_ADMIN_USERS['id']);
    }

    // Get the current authenticated user
    public function get_user(): ?User
    {
        // Search for user if authenticated
        if ($this->is_authenticated()) {
            $user_id = $this->session->get(COLUMNS_ADMIN_USERS['id']);
            return User::find_by_id($user_id);
        }

        return null;
    }
}
