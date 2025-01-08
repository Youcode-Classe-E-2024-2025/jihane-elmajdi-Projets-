<?php
require_once '../config/database.php';
require_once '../Services/AuthenticationService.php';

$dbService = new DatabaseService();
$db = $dbService->getConnection();
$authService = new AuthenticationService($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $authService->getUserByEmail($email);

    if (!$user) {
        echo "<div class='message error'>L'email n'est pas enregistré dans notre système.</div>";
    } else {
        if ($authService->login($email, $password)) {
            echo "<div class='message success'>Connexion réussie! Bienvenue, " . $user['name'] . "</div>";
            header("Location: ../Classes/Role.php");
            exit;
        } else {
            echo "<div class='message error'>Mot de passe incorrect.</div>";
        }
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f1e5d8; /* Beige background */
        margin: 0;
        padding: 0;
    }

    .login-form {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .login-form h2 {
        text-align: center;
        color: #333;
    }

    .login-form input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .login-form button {
        width: 100%;
        padding: 10px;
        background-color: #c5a880; /* Beige-like button */
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .login-form button:hover {
        background-color: #a68a60;
    }

    .message {
        padding: 10px;
        margin-bottom: 15px;
        text-align: center;
        border-radius: 5px;
    }

    .message.success {
        background-color: #d4edda;
        color: #155724;
    }

    .message.error {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<div class="login-form">
    <h2>Se connecter</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Votre email" required><br>
        <input type="password" name="password" placeholder="Votre mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
</div>
