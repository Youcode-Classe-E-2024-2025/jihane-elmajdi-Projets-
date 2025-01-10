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

$sql_users = "SELECT * FROM users";
$stmt_users = $pdo->query($sql_users);
$users = $stmt_users->fetchAll();

$sql_projects = "SELECT * FROM projects";
$stmt_projects = $pdo->query($sql_projects);
$projects = $stmt_projects->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
 
body {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    background-color: #f3f4f6; 
    margin: 0;
    padding: 0;
    color: #333;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 20px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.container:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

header {
    background-color: #6c757d; 
    color: #fff;
    padding: 20px 30px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

header h1 {
    margin: 0;
    font-size: 32px;
    font-weight: bold;
}

nav ul {
    list-style: none;
    padding: 0;
    margin-top: 15px;
}

nav ul li {
    display: inline-block;
    margin-right: 25px;
}

nav ul li a {
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

nav ul li a:hover {
    background-color: #d9a63d; 
    color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.dashboard {
    margin-top: 30px;
}

.dashboard h2 {
    font-size: 28px;
    color: #333;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.stats {
    display: flex;
    justify-content: space-between;
    gap: 20px; /* Added gap */
    margin-bottom: 40px;
}

.stat-card {
    background-color: #ffffff;
    padding: 25px;
    border-radius: 15px;
    width: 30%;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.stat-card h3 {
    font-size: 24px;
    color: #333;
    margin-bottom: 15px;
}

.stat-card p {
    font-size: 32px;
    font-weight: bold;
    color: #d9a63d; 
}

.action-cards {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 50px;
}

.action-card {
    background-color: #d9a63d;
    padding: 25px;
    border-radius: 10px;
    width: 30%;
    text-align: center;
    transition: all 0.3s ease;
    color: white;
}

.action-card:hover {
    background-color: #c58b2f;
    transform: translateY(-10px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.action-card h3 {
    font-size: 24px;
    margin-bottom: 20px;
}

.action-card a {
    display: inline-block;
    padding: 12px 25px;
    background-color: #fff;
    color: #6c757d;
    font-weight: bold;
    text-decoration: none;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.action-card a:hover {
    background-color: #6c757d;
    color: white;
    transform: scale(1.1);
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}

table th, table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    font-size: 18px;
    color: #333;
    transition: all 0.3s ease;
}

table th {
    background-color: #f1f1f1;
    color: #333;
}

table tr:hover {
    background-color: #f9f9f9;
}

table a {
    color: #d9a63d; 
    text-decoration: none;
    font-weight: bold;
}

table a:hover {
    color: #c58b2f;
    text-decoration: underline;
}
.add-button {
    margin-top: 30px;
    padding: 15px 25px;
    background-color: #d9a63d;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: bold;
    display: inline-block;
    transition: all 0.3s ease;
}

.add-button:hover {
    background-color: #c58b2f;
    transform: scale(1.05);
}

    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($user['name']); ?> (Administrateur)</h1>
        <nav>
            <ul>
                <li><a href="manage_users.php">Gérer les utilisateurs</a></li>
                <li><a href="manage_projects.php">Gérer les projets</a></li>
                <li><a href="manage_roles.php">Gérer les rôles</a></li>
                <li><a href="settings.php">Paramètres</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <section class="dashboard">
        <h2>Tableau de bord</h2>
        <p>Bienvenue dans votre espace de gestion. Vous pouvez gérer les utilisateurs, projets et rôles.</p>

        <div class="stats">
            <div class="stat-card">
                <h3>Nombre d'utilisateurs</h3>
                <p><?php echo count($users); ?></p>
            </div>
            <div class="stat-card">
                <h3>Nombre de projets</h3>
                <p><?php echo count($projects); ?></p>
            </div>
        </div>

        <div class="action-cards">
            <div class="action-card">
                <h3>Ajouter un utilisateur</h3>
                <a href="add_user.php" class="btn">Ajouter</a>
            </div>
            <div class="action-card">
                <h3>Ajouter un projet</h3>
                <a href="add_project.php" class="btn">Ajouter</a>
            </div>
            <div class="action-card">
                <h3>Gérer les rôles</h3>
                <a href="manage_roles.php" class="btn">Gérer</a>
            </div>
        </div>

        <h3>Liste des utilisateurs</h3>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user_item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user_item['name']); ?></td>
                        <td><?php echo htmlspecialchars($user_item['email']); ?></td>
                        <td><?php echo htmlspecialchars($user_item['role']); ?></td>
                        <td><a href="edit_user.php?id=<?php echo $user_item['id']; ?>">Modifier</a> | <a href="delete_user.php?id=<?php echo $user_item['id']; ?>">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Liste des projets</h3>
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
    </section>
</div>

</body>
</html>
