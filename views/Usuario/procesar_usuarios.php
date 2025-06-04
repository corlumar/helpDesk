<?php
session_start();
if (!isset($_SESSION["usu_id"]) || $_SESSION["rol_id"] != 1) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Acceso no autorizado"]);
    exit();
}

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos de la solicitud
    $input = $_POST;

    // Si los datos vienen en formato JSON
    if (empty($input)) {
        $input = json_decode(file_get_contents("php://input"), true);
    }

    $accion = $input["accion"] ?? "";

    if ($accion === "editar") {
        $usu_id = intval($input["usu_id"]);
        $usu_nom = trim($input["usu_nom"]);
        $usu_correo = trim($input["usu_correo"]);
        $rol_id = intval($input["rol_id"]);

        // Validar que el correo no esté duplicado para otro usuario
        $stmt = $conexion->prepare("SELECT usu_id FROM usuarios WHERE usu_correo = ? AND usu_id != ?");
        $stmt->bind_param("si", $usu_correo, $usu_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(["success" => false, "message" => "El correo ya está en uso por otro usuario."]);
            exit();
        }

        $stmt->close();

        // Actualizar el usuario
        $stmt = $conexion->prepare("UPDATE usuarios SET usu_nom = ?, usu_correo = ?, rol_id = ? WHERE usu_id = ?");
        $stmt->bind_param("ssii", $usu_nom, $usu_correo, $rol_id, $usu_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Usuario actualizado correctamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el usuario."]);
        }

                $stmt->close();
        exit();
    }

    if ($accion === "eliminar") {
        $usu_id = intval($input["usu_id"]);

        // No se permite eliminar el propio usuario logueado
        if ($usu_id === $_SESSION["usu_id"]) {
            echo json_encode(["success" => false, "message" => "No puedes eliminar tu propio usuario."]);
            exit();
        }

        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE usu_id = ?");
        $stmt->bind_param("i", $usu_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Usuario eliminado correctamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al eliminar el usuario."]);
        }

        $stmt->close();
        exit();
    }

    echo json_encode(["success" => false, "message" => "Acción no válida."]);
    exit();
}

// Si es GET, retornar todos los usuarios
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT u.usu_id, u.usu_nom, u.usu_correo, u.rol_id, r.rol_nom, u.fecha_registro
            FROM usuarios u
            INNER JOIN roles r ON u.rol_id = r.rol_id
            ORDER BY u.usu_id DESC";

    $result = $conexion->query($sql);
    $usuarios = [];

    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
    exit();
}
?>
