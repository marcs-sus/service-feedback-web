<?php
require_once __DIR__ . '/../../src/auth/auth_required.php';

// Enforce authentication
auth_required('login_page.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h1>TEST</h1>
    <a href="../../src/auth/logout.php">Logout</a>
</body>

</html>