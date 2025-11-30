<?php
require_once __DIR__ . '/auth.php';

$auth = new Auth();
$auth->logout();

header('Location: ../../public/admin/login_page.php');
exit();
