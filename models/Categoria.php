<?php
require_once("../config/conexion.php");

class Categoria extends Conectar {

    public function listar_categorias() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_categoria WHERE estado = 1 ORDER BY cat_nom ASC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
  