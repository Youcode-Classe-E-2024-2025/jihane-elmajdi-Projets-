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

$sql_roles = "SELECT * FROM roles";  
$stmt_roles = $pdo->query($sql_roles);
$roles = $stmt_roles->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}
header {
    background-color: #d4c5a9; 
    color: white;
    padding: 15px 0;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 2em;
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 10px 0;
    text-align: center;
}

nav ul li {
    display: inline;
    margin: 0 15px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 1.1em;
}

nav ul li a:hover {
    text-decoration: underline;
}


.dashboard {
    background-color: #fff; 
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.dashboard h2 {
    margin-top: 0;
    font-size: 1.8em;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f9f9f9; 
}

td a {
    color: #d4c5a9; 
    text-decoration: none;
}

td a:hover {
    text-decoration: underline;
}
tr:hover {
    background-color: #f1f1f1; 
}


@media (max-width: 768px) {
    header h1 {
        font-size: 1.5em;
    }

    table {
        font-size: 0.9em;
    }

    nav ul {
        display: block;
    }

    nav ul li {
        display: block;
        margin: 10px 0;
    }
}
</style>
</head>
<body>

<div class="container">
    <header>
        <h1>Gérer les Rôles</h1>
        
    </header>

    <section class="dashboard">
        <h2>Liste des utilisateurs et leurs rôles</h2>
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
                        <td>
                            <?php
                            $user_role_id = $user_item['role_id']; 
                            $role_name = '';
                            foreach ($roles as $role) {
                                if ($role['id'] == $user_role_id) {
                                    $role_name = $role['name'];
                                    break;
                                }
                            }
                            echo htmlspecialchars($role_name);
                            ?>
                        </td>
                        <td><a href="edit_role.php?id=<?php echo $user_item['id']; ?>">Modifier le rôle</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

</body>
</html>
