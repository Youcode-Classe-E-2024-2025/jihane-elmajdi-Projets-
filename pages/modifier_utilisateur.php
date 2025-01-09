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


    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Utilisateur introuvable.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $role_id = $_POST['role_id'];

            $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, role_id = :role_id WHERE id = :id");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':role_id' => $role_id,
                ':id' => $id
            ]);

            header("Location: gerer_utilisateurs.php?success=1");
            exit;
        }
    } else {
        echo "ID utilisateur manquant.";
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
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Modifier l'utilisateur</h1>
        <form method="POST" action="">
            <div>
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div>
                <label for="role_id">Rôle :</label>
                <select id="role_id" name="role_id" required>
                    <option value="1" <?php echo $user['role_id'] == 1 ? 'selected' : ''; ?>>Administrateur</option>
                    <option value="2" <?php echo $user['role_id'] == 2 ? 'selected' : ''; ?>>Chef de projet</option>
                </select>
            </div>
            <button type="submit">Modifier</button>
        </form>
    </div>
</body>
</html>
