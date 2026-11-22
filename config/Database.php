<?php
namespace Config;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $database;
    private string $username;
    private string $password;

    public function __construct()
    {
        // Leer el archivo .env desde la raíz del proyecto
        $rutaEnv = __DIR__ . '/../.env';
        
        if (file_exists($rutaEnv)) {
            $env = parse_ini_file($rutaEnv);
            $this->host = $env['DB_HOST'] ?? 'localhost';
            $this->database = $env['DB_NAME'] ?? 'royalpetsdb';
            $this->username = $env['DB_USER'] ?? 'root';
            $this->password = $env['DB_PASSWORD'] ?? '';
        } else {
            // Valores por defecto si no existe el .env
            $this->host = 'localhost';
            $this->database = 'royalpetsdb';
            $this->username = 'root';
            $this->password = '';
        }
    }

    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
            
            $connection = new PDO($dsn, $this->username, $this->password);
            
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            return $connection;

        } catch (PDOException $e) {
            throw new PDOException('Error al conectar con la base de datos.');
        }
    }
}