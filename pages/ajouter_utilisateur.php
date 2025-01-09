<?php
session_start();


if (!isset($_SESSION['user']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $host = 'localhost';
    $dbname = 'project_management';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role_id = $_POST['role_id'];

        
        $query = "INSERT INTO users (name, email, password, role_id, created_at) VALUES (:name, :email, :password, :role_id, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':role_id' => $role_id,
        ]);

     
        header("Location: Administrateur.php?success=1");
        exit;

    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Ajouter un utilisateur</h1>
    <form method="POST" action="">
        <div>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="role_id">Rôle :</label>
            <select id="role_id" name="role_id" required>
                <option value="2">Chef de projet</option>
                <option value="3">Membre</option>
                <option value="4">Invité</option>
            </select>
        </div>
        <button type="submit">Ajouter</button>
    </form>
</div>
</body>
</html>

<style>
/* Style pour la page d'ajout */
.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f4f4f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

form div {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #5d4037;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #8d6e63;
}
</style>
