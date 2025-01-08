<?php
require_once '../config/database.php';
require_once '../Services/AuthenticationService.php';

$dbService = new DatabaseService();
$db = $dbService->getConnection();
$authService = new AuthenticationService($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $authService->login($email, $password);

    if ($user) {
        echo "<div class='message success'>Connexion réussie! Bienvenue, " . $user['name'] . "</div>";
    } else {
        echo "<div class='message error'>Email ou mot de passe incorrect.</div>";
    }
}
?>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background: #f4f7f6;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .login-form {
        background: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        width: 320px;
        text-align: center;
        box-sizing: border-box;
    }
    .login-form h2 {
        margin-bottom: 30px;
        color: #333;
        font-size: 24px;
    }
    input[type="email"], input[type="password"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }
    input:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
    }
    button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        border: none;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #45a049;
    }
    .message {
        padding: 10px;
        margin-top: 20px;
        border-radius: 5px;
        font-size: 16px;
    }
    .message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .message.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
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

