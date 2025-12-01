<?php
require_once __DIR__ . '/../../src/auth/auth_required.php';
require_once __DIR__ . '/../../src/model/sector.php';
require_once __DIR__ . '/../../src/model/device.php';
require_once __DIR__ . '/../../src/model/question.php';

// Enforce authentication
auth_required('login_page.php');

// Get counts for dashboard
$sectors = Sector::find_all();
$devices = Device::find_all();
$questions = Question::find_all();

$sectors_count = count($sectors);
$devices_count = count($devices);
$questions_count = count($questions);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <!-- Navigation -->
    <nav>
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="evaluation_summary.php">Evaluation Summary</a></li>
            <li><a href="crud/sectors/list_sectors.php">Sectors</a></li>
            <li><a href="crud/devices/list_devices.php">Devices</a></li>
            <li><a href="crud/questions/list_questions.php">Questions</a></li>
            <li><a href="../../src/auth/logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="admin-header">
            <h1>Dashboard</h1>
        </div>

        <!-- Dashboard Cards -->
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h2><?= $sectors_count ?></h2>
                <p>Total Sectors</p>
                <a href="crud/sectors/list_sectors.php">Manage Sectors</a>
            </div>

            <div class="dashboard-card">
                <h2><?= $devices_count ?></h2>
                <p>Total Devices</p>
                <a href="crud/devices/list_devices.php">Manage Devices</a>
            </div>

            <div class="dashboard-card">
                <h2><?= $questions_count ?></h2>
                <p>Total Questions</p>
                <a href="crud/questions/list_questions.php">Manage Questions</a>
            </div>
        </div>
    </div>
</body>

</html>