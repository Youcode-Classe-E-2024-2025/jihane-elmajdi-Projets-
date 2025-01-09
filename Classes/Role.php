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
$role_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] : 4; // invité par défaut

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role_id'])) {
    $role_id = $_POST['role_id'];

    // Mettre à jour le rôle dans la base de données
    $query = "UPDATE users SET role_id = :role_id WHERE id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':role_id', $role_id);
    $stmt->bindParam(':user_id', $user['id']);
    if ($stmt->execute()) {
        $_SESSION['role_id'] = $role_id; // Mettre à jour le rôle dans la session

        // Rediriger vers la page correspondante
        switch ($role_id) {
            case 1:
                header("Location: ../pages/Administrateur.php");
                break;
            case 2:
                header("Location: ../pages/Chef de Projet.php");
                break;
            case 3:
                header("Location: ../pages/Membre.php");
                break;
            case 4:
                header("Location: ../pages/invite.php");
                break;
            default:
            header("Location: ../pages/error.php");
                break;
        }
        exit;
    } else {
        $message = "<div class='message error'>Erreur lors de la mise à jour du rôle.</div>";
    }
}
?>


<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to right, #f5e7de, #e4d6c5);
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 900px;
        margin: 50px auto;
        text-align: center;
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    h2 {
        color: #5d4037;
        margin-bottom: 20px;
    }

    .role-cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .role-card {
        width: 200px;
        padding: 20px;
        text-align: center;
        border-radius: 15px;
        background: linear-gradient(to bottom, #f8f5f1, #eae3d8);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .role-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
    }

    .role-card h3 {
        margin-bottom: 15px;
        color: #5d4037;
    }

    .role-card button {
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #8d6e63;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .role-card button:hover {
        background-color: #6d4c41;
        transform: scale(1.05);
    }

    .role-card button:disabled {
        background-color: #d3c0b4;
        color: #aaa;
        cursor: not-allowed;
        transform: none;
    }

    .message {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        text-align: center;
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
