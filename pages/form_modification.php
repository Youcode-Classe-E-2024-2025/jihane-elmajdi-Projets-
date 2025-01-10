<?php
// Démarrage de la session
session_start();

// Vérification si l'utilisateur est connecté et s'il a le rôle d'administrateur (role_id = 1)
if (!isset($_SESSION['user']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Vérification de l'existence de l'identifiant de l'utilisateur dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun utilisateur sélectionné.");
}

// Récupération de l'identifiant de l'utilisateur
$userId = $_GET['id'];

// Informations de connexion à la base de données
$host = 'localhost';
$dbname = 'project_management';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}

// Requête pour récupérer les informations de l'utilisateur sélectionné
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Vérifier si l'utilisateur existe
if (!$user) {
    die("Utilisateur non trouvé.");
}

// Requête pour récupérer tous les rôles disponibles
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
    /* Style général de la page */
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
    }

    .form-section {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #e4d6c5;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-section h2 {
        color: #5d4037;
        font-size: 28px;
        margin-bottom: 20px;
    }

    label {
        font-size: 18px;
        color: #5d4037;
        margin-bottom: 10px;
        display: block;
    }

    select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        color: #5d4037;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button {
        background-color: #5d4037;
        color: white;
        padding: 12px 25px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
    }

    button:hover {
        background-color: #8d6e63;
    }
</style>


</head>
<body>

<div class="container">
    <header>
     
        <h1>Modifier le rôle de l'utilisateur : <?php echo htmlspecialchars($user['name']); ?></h1>
    
    </header>

    <section class="form-section">
        <h2>Formulaire de modification du rôle</h2>
        <form action="update_role.php" method="POST">
            <!-- Champ caché pour envoyer l'ID de l'utilisateur -->
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

            <label for="role">Sélectionner un rôle :</label>
            <select name="role_id" id="role" required>
                <?php foreach ($roles as $role): ?>
                    <!-- Pré-sélection du rôle actuel de l'utilisateur -->
                    <option value="<?php echo $role['id']; ?>" <?php echo ($role['id'] == $user['role_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($role['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn">Modifier le rôle</button>
        </form>
    </section>
</div>

</body>
</html>

