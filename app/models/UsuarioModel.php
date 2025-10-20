<?php
require_once 'Model.php';
class UsuarioModel extends Model {
    public function getByUsername($username){
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE nombre_usuario = ?');
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($username, $nombre, $apellido, $tipo, $password){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('INSERT INTO usuarios (nombre_usuario,nombre,apellido,tipo,contrasenia) VALUES (?,?,?,?,?)');
        $stmt->execute([$username,$nombre,$apellido,$tipo,$hash]);
        return $this->pdo->lastInsertId();
    }
}
