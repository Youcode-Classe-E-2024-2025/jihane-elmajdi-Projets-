<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id']) && isset($_POST['role_id'])) {
    $userId = $_POST['user_id'];
    $roleId = $_POST['role_id'];

    $host = 'localhost';
    $dbname = 'project_management';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE users SET role_id = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$roleId, $userId]);

    
        header("Location: gerer_role.php");
        exit;

    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
?>
