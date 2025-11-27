<?php
require_once __DIR__ . '/../auth.php';

// Redirects to login page if user is not authenticated
function auth_required(string $login_path = 'login.php'): void
{
    $auth = new Auth();
    if (!$auth->is_authenticated()) {
        // Redirect to login page
        header('Location: ' . $login_path);
        exit();
    }
}
