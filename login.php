<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<?php
    if (isset($_GET['error'])):
        if ($_GET['error'] === 'invalid'):?>
            <p style="color:red;">Username o password errati</p>
<?php endif; endif; ?>

<form method="POST" action="authenticate.php">
    <label>Username:</label>
    <input type="text" name="username" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>
