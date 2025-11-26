<?php
require_once __DIR__ . '/../../src/auth.php';

$auth = new Auth();
$auth->logout();

header('Location: login.php');
exit();
