<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <!-- Form container -->
    <div id="form-container">
        <h2>Admin Login</h2>
        <!-- Login form -->
        <form action="../../src/auth/login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <!-- Message container -->
        <div id="message-container" style="display: none;"></div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');
        let loginError = null;
        if (error === 'invalid_credentials') {
            loginError = 'Invalid username or password.';
        }
    </script>
    <script src="../js/login.js"></script>
</body>

</html>