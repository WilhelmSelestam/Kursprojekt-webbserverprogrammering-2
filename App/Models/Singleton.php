<?php
namespace App\Models;
use PDO;
use Dotenv\Dotenv;

class Singleton
{
    private static ?Singleton $instance = null;
    private PDO $pdo;

    protected function __construct()
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
     * @return Singleton
     */
    public static function getInstance(): Singleton
    {
        if (!self::$instance) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}