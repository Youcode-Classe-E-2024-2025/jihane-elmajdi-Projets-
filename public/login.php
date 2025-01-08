<?php
require_once '../config/database.php';
require_once '../Services/AuthenticationService.php';

$dbService = new DatabaseService();
$db = $dbService->getConnection();
$authService = new AuthenticationService($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'email existe dans la base de données
    $user = $authService->getUserByEmail($email);

    if (!$user) {
        // Si l'email n'est pas trouvé
        echo "<div class='message error'>L'email n'est pas enregistré dans notre système.</div>";
    } else {
        // Si l'email existe, vérifier le mot de passe
        if ($authService->login($email, $password)) {
            echo "<div class='message success'>Connexion réussie! Bienvenue, " . $user['name'] . "</div>";
            // Rediriger vers la page de rôle (ajoute ici la redirection vers role.php)
            header("Location: ../Classes/Role.php");
            exit;
        } else {
            // Si le mot de passe est incorrect
            echo "<div class='message error'>Mot de passe incorrect.</div>";
        }
    }
}
?>

<style>
    /* Style identique à celui que tu as fourni précédemment */
</style>

<div class="login-form">
    <h2>Se connecter</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Votre email" required><br>
        <input type="password" name="password" placeholder="Votre mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
</div>
