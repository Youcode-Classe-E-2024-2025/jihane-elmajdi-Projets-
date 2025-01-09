<?php
require_once '../config/database.php';
require_once '../Services/AuthenticationService.php';

$dbService = new DatabaseService();
$db = $dbService->getConnection();
$authService = new AuthenticationService($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($authService->getUserByEmail($email)) {
        echo "<div class='message error'>Cet email est déjà utilisé.</div>";
    } else {
        if ($AuthenticationService->register($name, $email, $password)) {
            echo "<div class='message success'>Inscription réussie! Vous pouvez maintenant vous connecter.</div>";
        } else {
            echo "<div class='message error'>Erreur lors de l'inscription.</div>";
        }
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f1e5d8; 
        margin: 0;
        padding: 0;
    }

    .register-form {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .register-form h2 {
        text-align: center;
        color: #333;
    }

    .register-form input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .register-form button {
        width: 100%;
        padding: 10px;
        background-color: #c5a880; 
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .register-form button:hover {
        background-color: #a68a60;
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
    }

    .login-link a {
        color: #007bff;
        text-decoration: none;
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

<div class="register-form">
    <h2>S'inscrire</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Votre nom" required><br>
        <input type="email" name="email" placeholder="Votre email" required><br>
        <input type="password" name="password" placeholder="Votre mot de passe" required><br>
        <button type="submit">S'inscrire</button>
    </form>
    <div class="login-link">
        <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
    </div>
</div>
