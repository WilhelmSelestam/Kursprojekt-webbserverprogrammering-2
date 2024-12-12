<?php

namespace App\Models;

use App\Models\Singleton;
use PDO;
use Dotenv\Dotenv;

/**
 * Bygger på att klassen Singleton sköter själva kopplingen till databasen
 * Denna klass skapar allmänna metoder för att jobba mot databasen
 * Andra klasser ärver denna (abstract)
 */
abstract class Database
{
    public PDO $pdo;

    /**
     *  Hämta upp pdo-objektet från Singleton-klassen
     */
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(ROOT);
        $dotenv->load();

        $host = $_ENV["HOST"];
        $db = $_ENV["DB"];
        $user = $_ENV["USER"];
        $pass = $_ENV["PASSWORD"];
        $dsn = "mysql:host=$host;port=3306;dbname=$db";
        $settings = [
            PDO::ATTR_PERSISTENT => $_ENV["PDO_PERSIST"],
            PDO::MYSQL_ATTR_LOCAL_INFILE => $_ENV["PDO_LOCAL_INFILE"],
            PDO::ATTR_ERRMODE => $_ENV["PDO_ERROR"],
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];
        $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass,$settings);
    }

    /**
     * @param string $sql
     * @return bool
     */
    public function query(string $sql)
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    /**
     * @param string $sql
     * @param int|null $fetchMode
     * @return mixed
     */
    public function fetch(string $sql, int $fetchMode = null): mixed
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        if ($fetchMode) {
            $result = $stmt->fetch($fetchMode);
        } else {
            $result = $stmt->fetch();
        }
        return $result;
    }

    /**
     * @param string $sql
     * @param int|null $fetchMode
     * @return array|false
     */
    public function fetchAll(string $sql, int $fetchMode = null):array|bool
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        if ($fetchMode) {
            $results = $stmt->fetchAll($fetchMode);
        } else {
            $results = $stmt->fetchAll();
        }
        return $results;
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function fetchColumn(string $sql): mixed
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}