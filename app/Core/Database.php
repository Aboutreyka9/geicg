<?php
namespace App\Core;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct()
    {
        // Charger les variables d'environnement une seule fois
        $dotenv = Dotenv::createImmutable(__DIR__ . THREE_PIP);
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $charset = $_ENV['DB_CHARSET'];

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

        try {
            $this->connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Récupérer l'instance unique
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    
    // Récupérer la connexion PDO
    public function getConnection(): PDO
    {
        return $this->connection;
    }

   
}
