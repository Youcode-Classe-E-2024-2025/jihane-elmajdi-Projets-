<?php

session_start();
if (!isset($_SESSION['user']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
</head>
<body>

<div class="container">
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($user['name']); ?> (Administrateur)</h1>
        <nav>
            <ul>
                <li><a href="manage_users.php">Gérer les utilisateurs</a></li>
                <li><a href="manage_projects.php">Gérer les projets</a></li>
                <li><a href="settings.php">Paramètres</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <section class="dashboard">
        <h2>Tableau de bord</h2>
        <p>Bienvenue dans votre espace d'administration. Vous pouvez gérer les utilisateurs, les projets et les paramètres du système.</p>

        <div class="stats">
            <div class="stat-card">
                <h3>Nombre d'utilisateurs</h3>
                <p>120</p> 
            </div>
            <div class="stat-card">
                <h3>Nombre de projets</h3>
                <p>45</p>
            </div>
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
    }

    nav ul {
        list-style-type: none;
        padding: 0;
    }

    nav ul li {
        display: inline;
        margin: 0 10px;
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
        background-color: #e4d6c5;
        padding: 20px;
        width: 250px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .stat-card h3 {
        color: #5d4037;
        margin-bottom: 10px;
    }

    .stat-card p {
        font-size: 24px;
        color: #8d6e63;
    }
</style>
