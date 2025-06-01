<?php
require_once("../config/conexion.php");
require_once("../models/Categoria.php");

$categoria = new Categoria();

switch ($_GET["op"]) {
    case "combo":
        $datos = $categoria->listar_categorias();
        if (is_array($datos) && count($datos) > 0) {
            echo '<option value="">Seleccione una categoría</option>';
            foreach ($datos as $row) {
                echo '<option value="' . $row["cat_id"] . '">' . $row["cat_nom"] . '</option>';
            }
        } else {
            echo '<option value="">No hay categorías</option>';
        }
        break;
}
