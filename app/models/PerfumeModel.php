<?php
require_once 'Model.php';
class PerfumeModel extends Model {
    public function all(){
        $stmt = $this->pdo->query('SELECT p.*, l.nombre as laboratorio_nombre FROM perfumes p JOIN laboratorios l ON p.id_laboratorio = l.id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find($id){
        $stmt = $this->pdo->prepare('SELECT p.*, l.nombre as laboratorio_nombre FROM perfumes p JOIN laboratorios l ON p.id_laboratorio = l.id WHERE p.id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function byLaboratorio($labId){
        $stmt = $this->pdo->prepare('SELECT p.*, l.nombre as laboratorio_nombre FROM perfumes p JOIN laboratorios l ON p.id_laboratorio = l.id WHERE p.id_laboratorio = ?');
        $stmt->execute([$labId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($id_laboratorio,$precio,$codigo,$duracion,$aroma,$sexo){
        $stmt = $this->pdo->prepare('INSERT INTO perfumes (id_laboratorio,precio,codigo,duracion,aroma,sexo) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$id_laboratorio,$precio,$codigo,$duracion,$aroma,$sexo]);
        return $this->pdo->lastInsertId();
    }
}
