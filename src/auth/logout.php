<?php
require_once __DIR__ . '/auth.php';

// Logout the user
$auth = new Auth();
$auth->logout();

// Redirect to the login page
$locale = $_GET['locale'] ?? null;
$redirect_url = '../../public/admin/login_page.php';
if ($locale) {
    $redirect_url .= '?locale=' . $locale;
}

header('Location: ' . $redirect_url);
exit();
