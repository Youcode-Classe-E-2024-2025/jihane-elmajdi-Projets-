
<?php
require_once '../config/database.php';


$dbService = new DatabaseService();

$pdo = $dbService->getConnection();

if ($pdo) {
    echo "Connexion réussie à la base de données!";
} else {
    echo "Erreur de connexion!";
}
?>