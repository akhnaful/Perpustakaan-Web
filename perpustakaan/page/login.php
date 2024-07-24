<?php
session_start();
require_once '../include/database.php'; 

$errors = [];
$inputs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Koneksi ke database, 
    $mysqli = new mysqli("localhost", "root", "", "db_perpus006");

    if ($mysqli->connect_error) {
        die('Database connection failed: ' . $mysqli->connect_error);
    }

    $admin = new Admin($mysqli);

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $errors['login'] = 'Username dan password tidak boleh kosong';
    } else {
        if (!$admin->login($username, $password)) {
            $errors['login'] = 'Username atau password salah';
        } else {
            $_SESSION['admin']= $username;
            header('Location: dashboard.php');
            exit;
        }
    }

    $inputs = $_POST;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <title>Login</title>
</head>
<body>
<main>
    <form action="login.php" method="post">
        <h1>Login</h1>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($inputs['username'] ?? ''); ?>">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <section>
            <button type="submit">Login</button>
            <a href="register.php">Register</a>
        </section>
    </form>
</main>
</body>
</html>
