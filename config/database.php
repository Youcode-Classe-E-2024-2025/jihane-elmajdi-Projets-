
<?php
class DatabaseService
{
    private $host = 'localhost'; 
    private $dbname = 'project_management'; 
    private $username = 'root';  
    private $password = '';     
    private $pdo;

    public function getConnection()
    {
        if (!$this->pdo) {
            try {
             
                $this->pdo = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbname}",
                    $this->username,
                    $this->password
                );
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            } catch (PDOException $e) {
                die("Connexion échouée: " . $e->getMessage());
            }
        }
        return $this->pdo; 
    }
}
