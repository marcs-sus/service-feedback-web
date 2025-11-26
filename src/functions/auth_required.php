<?php
require_once __DIR__ . '/../auth.php';

function auth_required()
{
    $auth = new Auth();
    if (!$auth->is_authenticated()) {
        // Redirect to login page
        header('Location: login.php');
        exit();
    }
}
