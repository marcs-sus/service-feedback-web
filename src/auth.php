<?php
require_once __DIR__ . '../config.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/model/user.php';

class Auth
{
    private Session $session;

    public function login(string $username, string $password): bool
    {
        // Check if this user is already logged in
        if (isset($this->session)) {
            return true;
        }

        // Find user by username
        $user = User::find_by_username($username);

        // Check if user exists and password matches
        if ($user && password_verify($password, $user->get_password_hash())) {
            $this->session = new Session();
            $this->session->set(COLUMNS_ADMIN_USERS['id'], $user->get_id());

            return true;
        }

        return false;
    }

    public function logout(): void
    {
        // Destroy session if it exists
        if (isset($this->session)) {
            $this->session->destroy();
            unset($this->session);
        }
    }

    public function is_authenticated(): bool
    {
        // Check if session exists and is active
        if (isset($this->session)) {
            return $this->session->is_active();
        }

        return false;
    }

    public function get_user(): ?User
    {
        // Search for user if authenticated
        if ($this->is_authenticated()) {
            $user_id = $this->session->get(COLUMNS_ADMIN_USERS['id']);
            return User::find_by_username($user_id);
        }

        return null;
    }
}
