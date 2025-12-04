<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../query.php';

class User
{
    private int $id;
    private string $username;
    private string $password_hash;

    public function __construct(
        int $id,
        string $username,
        string $password_hash
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
    }

    // Find a user by username statically
    public static function find_by_username(string $username): ?User
    {
        $user_query = new Query();
        $users = $user_query->select(TABLE_ADMIN_USERS, ['*'], [COLUMNS_ADMIN_USERS['username'] => $username]);

        // Instantiate a new user if found
        $user = $users[0] ?? null;
        if ($user) {
            return new User(
                $user[COLUMNS_ADMIN_USERS['id']],
                $user[COLUMNS_ADMIN_USERS['username']],
                $user[COLUMNS_ADMIN_USERS['password_hash']]
            );
        }

        return null;
    }

    // Find a user by id statically
    public static function find_by_id(int $id): ?User
    {
        $user_query = new Query();
        $users = $user_query->select(TABLE_ADMIN_USERS, ['*'], [COLUMNS_ADMIN_USERS['id'] => $id]);

        // Instantiate a new user if found
        $user = $users[0] ?? null;
        if ($user) {
            return new User(
                $user[COLUMNS_ADMIN_USERS['id']],
                $user[COLUMNS_ADMIN_USERS['username']],
                $user[COLUMNS_ADMIN_USERS['password_hash']]
            );
        }

        return null;
    }

    // Find all users statically
    public static function find_all(): array
    {
        $user_query = new Query();
        $users_data = $user_query->select(TABLE_ADMIN_USERS);

        // Loop through users and instantiate them
        $users = [];
        foreach ($users_data as $key => $value) {
            $users[$key] = new User(
                $value[COLUMNS_ADMIN_USERS['id']],
                $value[COLUMNS_ADMIN_USERS['username']],
                $value[COLUMNS_ADMIN_USERS['password_hash']]
            );
        }

        return $users;
    }

    // Check if a password hash matches the user's password
    public function verify_password(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }

    // Getters
    public function get_id(): int
    {
        return $this->id;
    }
    public function get_username(): string
    {
        return $this->username;
    }
    public function get_password_hash(): string
    {
        return $this->password_hash;
    }
}
