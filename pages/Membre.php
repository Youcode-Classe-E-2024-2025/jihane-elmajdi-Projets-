<?php
// Démarrer la session
session_start();


if (!isset($_SESSION['user']) || $_SESSION['role_id'] != 3) {
    header("Location: ../login.php");
    exit;
}

$user = $_SESSION['user'];


$host = 'localhost';
$dbname = 'project_management'; 
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


$user_id = $user['id'];
$query = "SELECT COUNT(*) FROM tasks WHERE assigned_to = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$task_count = $stmt->fetchColumn(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Membre</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<div class="container">
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($user['name']); ?> (Membre)</h1>
        <nav>
            <ul>
                <li><a href="my_projects.php">Mes projets</a></li>
                <li><a href="my_tasks.php">Mes tâches</a></li>
                <li><a href="settings.php">Paramètres</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <section class="dashboard">
        <h2>Tableau de bord</h2>
        <p>Bienvenue dans votre espace membre. Vous pouvez gérer vos projets et tâches ici.</p>

        <div class="stats">
            <div class="stat-card">
                <h3>Nombre de projets</h3>
                <p>0</p> 
            </div>
            <div class="stat-card">
                <h3>Nombre de tâches</h3>
                <p><?php echo $task_count; ?></p>
            </div>
        </div>

        <div class="task-list">
            <h3>Mes tâches</h3>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
             
                    <?php
                    $query_tasks = "SELECT * FROM tasks WHERE assigned_to = :user_id";
                    $stmt_tasks = $pdo->prepare($query_tasks);
                    $stmt_tasks->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt_tasks->execute();

                    while ($task = $stmt_tasks->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>" . htmlspecialchars($task['title']) . "</td>
                            <td>" . htmlspecialchars($task['description']) . "</td>
                            <td>" . htmlspecialchars($task['status']) . "</td>
                            <td><a href='view_task.php?id=" . $task['id'] . "'>Voir</a></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="project-list">
            <h3>Mes projets</h3>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td>Projet X</td>
                        <td>Description du projet X</td>
                        <td>En cours</td>
                        <td><a href="view_project.php?id=1">Voir</a></td>
                    </tr>
                    <tr>
                        <td>Projet Y</td>
                        <td>Description du projet Y</td>
                        <td>Terminé</td>
                        <td><a href="view_project.php?id=2">Voir</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>

</body>
</html>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    header {
        text-align: center;
        margin-bottom: 30px;
    }

    header h1 {
        color: #5d4037;
        font-size: 32px;
        font-weight: bold;
    }

    nav ul {
        list-style-type: none;
        padding: 0;
    }

    nav ul li {
        display: inline;
        margin: 0 15px;
    }

    nav ul li a {
        text-decoration: none;
        color: #8d6e63;
        font-size: 18px;
    }

    .dashboard {
        text-align: center;
    }

    .dashboard h2 {
        color: #5d4037;
        margin-bottom: 30px;
    }

    .stats {
        display: flex;
        justify-content: space-around;
        gap: 20px;
    }

    .stat-card {
        background-color: #8d6e63;
        padding: 25px;
        width: 250px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .stat-card h3 {
        color: white;
        font-size: 22px;
        margin-bottom: 15px;
    }

    .stat-card p {
        font-size: 28px;
        color: #fff;
    }

    .task-list, .project-list {
        margin-top: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: #8d6e63;
        color: white;
    }

    td {
        font-size: 16px;
        color: #5d4037;
    }

    td a {
        text-decoration: none;
        color: #5d4037;
    }

    td a:hover {
        color: #8d6e63;
        font-weight: bold;
    }
</style>
