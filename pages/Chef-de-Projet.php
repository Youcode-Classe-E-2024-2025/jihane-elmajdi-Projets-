<?php

session_start();
if (!isset($_SESSION['user']) || $_SESSION['role_id'] != 2) { 
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
    die("Erreur de connexion : " . $e->getMessage());
}


$sql_projects = "SELECT * FROM projects WHERE manager_id = ?";
$stmt_projects = $pdo->prepare($sql_projects);
$stmt_projects->execute([$user['id']]);
$projects = $stmt_projects->fetchAll();


$sql_tasks = "SELECT * FROM tasks WHERE assigned_to = ?";
$stmt_tasks = $pdo->prepare($sql_tasks);
$stmt_tasks->execute([$user['id']]);
$tasks = $stmt_tasks->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Chef de Projet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($user['name']); ?> (Chef de Projet)</h1>
        <nav>
            <ul>
                <li><a href="manage_projects.php">Gérer les projets</a></li>
                <li><a href="manage_tasks.php">Gérer les tâches</a></li>
                <li><a href="settings.php">Paramètres</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <section class="dashboard">
        <h2>Tableau de bord</h2>
        <p>Bienvenue dans votre espace de gestion des projets. Vous pouvez gérer vos projets et les tâches associées.</p>

        <div class="stats">
            <div class="stat-card">
                <h3>Nombre de projets</h3>
                <p><?php echo count($projects); ?></p>
            </div>
            <div class="stat-card">
                <h3>Nombre de tâches</h3>
                <p><?php echo count($tasks); ?></p>
            </div>
        </div>

        <div class="action-cards">
            <div class="action-card">
                <h3>Ajouter un projet</h3>
                <a href="add_project.php" class="btn">Ajouter</a>
            </div>
            <div class="action-card">
                <h3>Ajouter une tâche</h3>
                <a href="add_task.php" class="btn">Ajouter</a>
            </div>
            <div class="action-card">
                <h3>Gérer les projets</h3>
                <a href="manage_projects.php" class="btn">Gérer</a>
            </div>
            <div class="action-card">
                <h3>Gérer les tâches</h3>
                <a href="manage_tasks.php" class="btn">Gérer</a>
            </div>
        </div>

        <h3>Projets assignés</h3>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project['title']); ?></td>
                        <td><?php echo htmlspecialchars($project['description']); ?></td>
                        <td><?php echo htmlspecialchars($project['status']); ?></td>
                        <td><a href="edit_project.php?id=<?php echo $project['id']; ?>">Modifier</a> | <a href="delete_project.php?id=<?php echo $project['id']; ?>">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Tâches assignées</h3>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Deadline</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo htmlspecialchars($task['deadline']); ?></td>
                        <td><?php echo htmlspecialchars($task['status']); ?></td>
                        <td><a href="edit_task.php?id=<?php echo $task['id']; ?>">Modifier</a> | <a href="delete_task.php?id=<?php echo $task['id']; ?>">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
        transition: all 0.3s ease;
    }

    .container:hover {
        transform: scale(1.02);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
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
        margin-top: 15px;
    }

    nav ul li {
        display: inline;
        margin: 0 15px;
    }

    nav ul li a {
        text-decoration: none;
        color: #8d6e63;
        font-size: 18px;
        font-weight: 500;
        transition: color 0.3s;
    }

    nav ul li a:hover {
        color: #5d4037;
    }

    .dashboard {
        text-align: center;
        margin-bottom: 30px;
    }

    .dashboard h2 {
        color: #5d4037;
        margin-bottom: 20px;
        font-size: 28px;
    }

    .stats {
        display: flex;
        justify-content: space-around;
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background-color: #8d6e63;
        padding: 25px;
        width: 250px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-10px);
    }

    .stat-card h3 {
        color: white;
        font-size: 22px;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .stat-card p {
        font-size: 28px;
        color: #fff;
    }

    .action-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    .action-card {
        background-color: #e4d6c5;
        padding: 30px;
        width: 240px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .action-card:hover {
        transform: translateY(-10px);
    }

    .action-card h3 {
        color: #5d4037;
        font-size: 22px;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .btn {
        background-color: #5d4037;
        color: white;
        padding: 12px 25px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #8d6e63;
    }

    table {
        width: 100%;
        margin-top: 30px;
        border-collapse: collapse;
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
        font-size: 18px;
        font-weight: bold;
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
