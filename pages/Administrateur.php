<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role_id'] != 1) {
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


$sql_users = "SELECT COUNT(*) FROM users";
$stmt_users = $pdo->query($sql_users);
$user_count = $stmt_users->fetchColumn();


$sql_projects = "SELECT COUNT(*) FROM projects";
$stmt_projects = $pdo->query($sql_projects);
$project_count = $stmt_projects->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administrateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($user['name']); ?> (Administrateur)</h1>
        <nav>
            <ul>
                <li><a href="manage_users.php">Gérer les utilisateurs</a></li>
                <li><a href="manage_projects.php">Gérer les projets</a></li>
                <li><a href="manage_tasks.php">Gérer les tâches</a></li>
                <li><a href="settings.php">Paramètres</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <section class="dashboard">
        <h2>Tableau de bord</h2>
        <p>Bienvenue dans votre espace d'administration. Vous pouvez gérer les utilisateurs, les projets, les tâches et les paramètres.</p>

        <div class="stats">
            <div class="stat-card">
                <h3>Nombre d'utilisateurs</h3>
                <p><?php echo $user_count; ?></p>
            </div>
            <div class="stat-card">
                <h3>Nombre de projets</h3>
                <p><?php echo $project_count; ?></p>
            </div>
        </div>

        <div class="action-cards">
            <div class="action-card">
                <h3>Ajouter un utilisateur</h3>
                <a href="ajouter_utilisateur.php" class="btn">Ajouter</a>
            </div>
            <div class="action-card">
                <h3>Ajouter un projet</h3>
                <a href="ajouter_projet.php" class="btn">Ajouter</a>
            </div>
            <div class="action-card">
                <h3>Gérer les utilisateurs</h3>
                <a href="gerer_utilisateurs.php" class="btn">Gérer</a>
            </div>
            <div class="action-card">
                <h3>Gérer les projets</h3>
                <a href="manage_projects.php" class="btn">Gérer</a>
            </div>
            <div class="action-card">
                <h3>Gérer les tâches</h3>
                <a href="manage_tasks.php" class="btn">Gérer</a>
            </div>
            <div class="action-card">
                <h3>Paramètres</h3>
                <a href="settings.php" class="btn">Paramètres</a>
            </div>
        </div>
    </section>
</div>

</body>
</html>

<style>
    body {
        font-family: 'Roboto', sans-serif; 
        background: linear-gradient(to right, #f4f4f9, #e0e0e0);
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 40px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
    }

    header {
        text-align: center;
        margin-bottom: 40px;
    }

    header h1 {
        color: #5d4037;
        font-size: 36px;
        font-weight: 600;
    }

    nav ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
    }

    nav ul li {
        margin: 0 20px;
    }

    nav ul li a {
        text-decoration: none;
        color: #8d6e63;
        font-size: 18px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    nav ul li a:hover {
        color: #5d4037;
    }

    .dashboard {
        text-align: center;
    }

    .dashboard h2 {
        color: #5d4037;
        margin-bottom: 40px;
        font-size: 28px;
    }

    .stats {
        display: flex;
        justify-content: space-around;
        gap: 30px;
        margin-bottom: 40px;
    }

    .stat-card {
        background-color: #e4d6c5;
        padding: 25px;
        width: 250px;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .stat-card h3 {
        color: #5d4037;
        margin-bottom: 15px;
        font-size: 22px;
    }

    .stat-card p {
        font-size: 28px;
        color: #8d6e63;
    }

    .action-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: space-between;
    }

    .action-card {
        background-color: #e4d6c5;
        padding: 25px;
        width: 220px;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .action-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .action-card h3 {
        color: #5d4037;
        margin-bottom: 15px;
        font-size: 22px;
    }

    .btn {
        background-color: #8d6e63;
        color: white;
        padding: 12px 25px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 18px;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn:hover {
        background-color: #5d4037;
        transform: scale(1.05);
    }
</style>
