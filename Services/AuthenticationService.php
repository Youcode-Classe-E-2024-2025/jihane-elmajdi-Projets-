<?php

class AuthenticationService
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db; // Connexion à la base de données
    }

    // Fonction d'inscription
    public function register($name, $email, $password)
    {
        // Hacher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute(); // Retourne vrai si l'inscription a réussi
    }

    // Fonction de connexion
    public function login($email, $password)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Retourne les informations utilisateur si connexion réussie
        }

        return false; // Connexion échouée
    }
}
