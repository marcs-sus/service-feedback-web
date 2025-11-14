<?php
// Get device and sector from URL parameters, with defaults
$device_id = $_GET['device'] ?? 1;
$sector_id = $_GET['sector'] ?? 1;

// Build the redirect URL with the parameters
$redirect_url = "index.php?device=$device_id&sector=$sector_id";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
    <link rel="stylesheet" href="css/thank.css">
</head>

<body>
    <div>
        <h1>The Establishment appreciates your response</h1>
        <h2>It is very important for us as it helps us to continually improve our services.</h2>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = '<?= $redirect_url ?>';
        }, 5000);
    </script>
</body>

</html>