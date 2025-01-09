<?php
session_start();


if (!isset($_SESSION['user']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

$host = 'localhost';
$dbname = 'project_management';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $manager_id = $_POST['manager_id'];

  
        $query = "INSERT INTO projects (title, description, status, manager_id, created_at) 
                  VALUES (:title, :description, :status, :manager_id, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':status' => $status,
            ':manager_id' => $manager_id
        ]);

        header("Location: Administrateur.php?success=1");
        exit;
    }
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un projet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un projet</h1>
        <form method="POST" action="">
            <div>
                <label for="title">Titre du projet :</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="description">Description du projet :</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div>
                <label for="status">Statut du projet :</label>
                <select id="status" name="status" required>
                    <option value="En cours">En cours</option>
                    <option value="Terminé">Terminé</option>
                    <option value="À démarrer">À démarrer</option>
                </select>
            </div>
            <div>
                <label for="manager_id">Chef de projet :</label>
                <select id="manager_id" name="manager_id" required>
                    
                    <?php
                 
                    $stmt = $pdo->query("SELECT id, name FROM users WHERE role_id = 2");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit">Ajouter</button>
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
    background: linear-gradient(135deg, #f5e2c0, #d8c7b7); 
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

input, textarea, select {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    background: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
}

input:focus, textarea:focus, select:focus {
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
