<?php
require_once 'Model.php';
class LaboratorioModel extends Model {
    public function all(){
        $stmt = $this->pdo->query('SELECT * FROM laboratorios');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find($id){
        $stmt = $this->pdo->prepare('SELECT * FROM laboratorios WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($nombre,$descripcion,$url,$fundador,$pais){
        $stmt = $this->pdo->prepare('INSERT INTO laboratorios (nombre,descripcion,url,fundador,pais) VALUES (?,?,?,?,?)');
        $stmt->execute([$nombre,$descripcion,$url,$fundador,$pais]);
        return $this->pdo->lastInsertId();
    }
    public function update($id,$nombre,$descripcion,$url,$fundador,$pais){
        $stmt = $this->pdo->prepare('UPDATE laboratorios SET nombre=?, descripcion=?, url=?, fundador=?, pais=? WHERE id=?');
        $stmt->execute([$nombre,$descripcion,$url,$fundador,$pais,$id]);
    }
    public function delete($id){
        $stmt = $this->pdo->prepare('DELETE FROM laboratorios WHERE id=?');
        $stmt->execute([$id]);
    }
}
