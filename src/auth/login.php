<?php
require_once __DIR__ . '/auth.php';

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

$auth = new Auth();

// Call login function and check if the login was successful
if ($auth->login($username, $password)) {
    // Redirect to admin dashboard on successful login
    header('Location: ../../public/admin/dashboard.php');
    exit();
} else {
    // Redirect back to login page with error on failure
    header('Location: ../../public/admin/login_page.php?error=invalid_credentials');
    exit();
}
