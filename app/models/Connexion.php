<?php
namespace app\models;

use PDO;
use PDOException;

class Connexion {
    private static ?PDO $conn = null;

    public static function getConn(): PDO {
        if (self::$conn === null) {
            $host = '127.0.0.1';      // Adresse de la base de données
            $db   = 'poste';   // Nom de la base
            $user = 'root';           // Utilisateur MySQL
            $pass = '';               // Mot de passe
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$conn = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
