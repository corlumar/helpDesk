<?php
require_once("../config/conexion.php");

$sql = "SELECT cat_id, cat_nom FROM categoria ORDER BY cat_nom ASC";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['cat_id'] . '">' . htmlspecialchars($row['cat_nom']) . '</option>';
    }
} else {
    echo '<option value="">No hay categorías disponibles</option>';
}
?>
