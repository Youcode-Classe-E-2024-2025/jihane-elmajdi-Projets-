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

    // Vérifier si l'email est déjà pris
    if ($authService->getUserByEmail($email)) {
        echo "<div class='message error'>Cet email est déjà utilisé.</div>";
    } else {
        // Essayer d'enregistrer l'utilisateur
        if ($authService->register($name, $email, $password)) {
            echo "<div class='message success'>Inscription réussie! Vous pouvez maintenant vous connecter.</div>";
        } else {
            echo "<div class='message error'>Erreur lors de l'inscription.</div>";
        }
    }
}
?>

<style>
    /* Style identique à ce que tu as donné précédemment */
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
