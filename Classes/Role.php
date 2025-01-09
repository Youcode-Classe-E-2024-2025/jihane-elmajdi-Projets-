<?php
require_once '../config/database.php';
require_once '../Services/AuthenticationService.php';

$dbService = new DatabaseService();
$db = $dbService->getConnection();
$authService = new AuthenticationService($db);

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$user = $_SESSION['user'];
$role_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] : 4; // 4 = invité par défaut

// Si on reçoit un changement de rôle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role_id'])) {
    $role_id = $_POST['role_id'];
    
    // Mettre à jour le rôle dans la base de données
    $query = "UPDATE users SET role_id = :role_id WHERE id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':role_id', $role_id);
    $stmt->bindParam(':user_id', $user['id']);
    if ($stmt->execute()) {
        $_SESSION['role_id'] = $role_id; // Mettre à jour le rôle dans la session
        $message = "<div class='message success'>Rôle mis à jour avec succès!</div>";
    } else {
        $message = "<div class='message error'>Erreur lors de la mise à jour du rôle.</div>";
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

    .role-card {
        width: 200px;
        margin: 20px;
        padding: 20px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: inline-block;
    }

    .role-card h3 {
        margin-bottom: 10px;
    }

    .role-card button {
        padding: 10px;
        background-color: #c5a880;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .role-card button:hover {
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

<div class="container">
    <h2>Choisir un rôle</h2>

    <?php if (!empty($message)) echo $message; ?>

    <div class="role-cards">
        <div class="role-card">
            <h3>Administrateur</h3>
            <form method="POST">
                <button type="submit" name="role_id" value="1">Choisir</button>
            </form>
        </div>

        <div class="role-card">
            <h3>Chef de Projet</h3>
            <form method="POST">
                <button type="submit" name="role_id" value="2">Choisir</button>
            </form>
        </div>

        <div class="role-card">
            <h3>Membre</h3>
            <form method="POST">
                <button type="submit" name="role_id" value="3">Choisir</button>
            </form>
        </div>

        <div class="role-card">
            <h3>Invité</h3>
            <form method="POST">
                <button type="submit" name="role_id" value="4" <?php echo $role_id == 4 ? 'disabled' : ''; ?>>Choisir</button>
            </form>
        </div>
    </div>
</div>

