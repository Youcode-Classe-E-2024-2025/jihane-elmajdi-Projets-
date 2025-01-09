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
        <div class="button-container">
            <button type="submit">Ajouter</button>
        </div>
    </form>
</div>
</body>
</html>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f7f7;
    color: #333;
    padding: 20px;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 40px;
    background: linear-gradient(135deg, #f5d0a9, #e0c1a6); 
    border-radius: 15px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    color: #333;
    transform: scale(1);
    transition: transform 0.3s ease;
}

.container:hover {
    transform: scale(1.05);
}

h1 {
    text-align: center;
    font-size: 32px;
    margin-bottom: 30px;
    letter-spacing: 2px;
    color: #5d4037;
}


form {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

form div {
    margin: 0;
}

label {
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 10px;
    color: #5d4037; 
}

input, select {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    background: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
}

input:focus, select:focus {
    background: rgba(255, 255, 255, 1);
    outline: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.button-container {
    display: flex;
    justify-content: center;
}

button {
    background-color: #d9a872; 
    color: #fff;
    border: none;
    padding: 14px 30px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

button:hover {
    background-color: #c58d54; 
    transform: translateY(-3px);
}

button:active {
    transform: translateY(2px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
}

@media (max-width: 768px) {
    .container {
        padding: 30px;
    }

    h1 {
        font-size: 28px;
    }

    button {
        width: 100%;
    }
}

</style>