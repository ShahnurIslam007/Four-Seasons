<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - FOUR SEASONS</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Log In to FOUR SEASONS</h2>
        <form action="process_login.php" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary">Log In</button>
        </form>
        <p>Don't have an account? <a href="register.php" class="link">Sign Up</a></p>
    </div>
</body>
</html>
