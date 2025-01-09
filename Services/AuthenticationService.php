<?php

class AuthenticationService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fonction pour récupérer un utilisateur par email
    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'utilisateur s'il existe
    }

    // Fonction pour connecter un utilisateur (validation du mot de passe)
    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // L'utilisateur est authentifié
        }
        return false; // Si le mot de passe est incorrect
    }
}
