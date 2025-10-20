<?php
class Model {
    protected $pdo;
    public function __construct(){
        require_once __DIR__ . '/../../config.php';
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8';
        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $e) {
            die('DB connection failed: ' . $e->getMessage());
        }
    }
}
