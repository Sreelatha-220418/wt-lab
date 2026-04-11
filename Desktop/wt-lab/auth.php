<?php
session_start();
require "db.php";

if (isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit;
}

$loginError = "";
$signupError = "";

/* LOGIN */
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $loginError = "All fields required";
    } else {
        $user = findUser($email);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name']  = $user['full_name'];

            header("Location: index.php");
            exit;
        } else {
            $loginError = "Invalid email or password";
        }
    }
}

/* SIGNUP */
if (isset($_POST['signup'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        $signupError = "All fields required";
    } else {
        $existingUser = findUser($email);

        if ($existingUser) {
            $signupError = "Email already registered";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userData = [
                'full_name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'created_at' => date('Y-m-d H:i:s')
            ];

            addUser($userData);

            // Auto-login after signup
            session_regenerate_id(true);
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name']  = $name;

            header("Location: index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blood Donation Camp</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>

    <!-- Navbar -->
    <header>
        <h1>🩸 Blood Donation Camp</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="auth.php">Login</a>
        </nav>
    </header>

<div class="auth-wrapper">

    <!-- LOGIN -->
    <div class="auth-card" id="loginForm">
        <h2>Login</h2>

        <?php if($loginError): ?>
            <div class="error"><?= $loginError ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <div class="btn-group">
                <button type="submit" name="login" class="auth-btn">Login</button>
            </div>
        </form>

        <div class="switch-link">
            Don't have account?
            <a href="#" onclick="showSignup()">Sign Up</a>
        </div>
    </div>

    <!-- SIGNUP -->
    <div class="auth-card hidden" id="signupForm">
        <h2>Sign Up</h2>

        <?php if($signupError): ?>
            <div class="error"><?= $signupError ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <div class="btn-group">
                <button type="submit" name="signup" class="auth-btn">Sign Up</button>
            </div>
        </form>

        <div class="switch-link">
            Already have account?
            <a href="#" onclick="showLogin()">Login</a>
        </div>
    </div>

</div>

<script>
function showSignup(){
    document.getElementById("loginForm").classList.add("hidden");
    document.getElementById("signupForm").classList.remove("hidden");
}
function showLogin(){
    document.getElementById("signupForm").classList.add("hidden");
    document.getElementById("loginForm").classList.remove("hidden");
}
</script>

</body>
</html>