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

  
    if (isset($_GET['delete'])) {
        $deleteId = $_GET['delete'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $deleteId]);
        header("Location: gerer_utilisateurs.php?success=1");
        exit;
    }

    
    $stmt = $pdo->query("SELECT id, name, email, role_id FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les utilisateurs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Gérer les utilisateurs</h1>

       
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success">
                Utilisateur ajouté ou supprimé avec succès !
            </div>
        <?php endif; ?>

       
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
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo $user['role_id'] == 1 ? 'Administrateur' : 'Chef de projet'; ?></td>
                        <td>
                            <a href="modifier_utilisateur.php?id=<?php echo $user['id']; ?>">Modifier</a> |
                            <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<style>

.container {
    max-width: 900px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f4f4f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #8d6e63;
    color: white;
}

tr:hover {
    background-color: #f4f4f9;
}

a {
    color: #5d4037;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.alert {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.alert.success {
    background-color: #4CAF50;
}
</style>
