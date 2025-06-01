<?php
require_once("../config/conexion.php");

class Categoria extends Conectar {

    public function listar_categorias() {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT cat_id, cat_nom FROM tm_categoria WHERE est = 1 ORDER BY cat_nom ASC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
