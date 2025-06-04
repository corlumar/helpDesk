<?php
require_once("../config/conexion.php");

$op = $_GET['op'] ?? '';

switch ($op) {
    case 'listar':
        $stmt = $conexion->prepare("SELECT * FROM usuario");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($usuarios);
        break;

    case 'guardar':
        $usu_id = $_POST['usu_id'] ?? '';
        $usu_nom = $_POST['usu_nom'] ?? '';
        $usu_correo = $_POST['usu_correo'] ?? '';
        $rol_id = $_POST['rol_id'] ?? '';
        $usu_pass = $_POST['usu_pass'] ?? '';

        if ($usu_id) {
            // Actualizar usuario
            if ($usu_pass) {
                $stmt = $conexion->prepare("UPDATE usuario SET usu_nom = ?, usu_correo = ?, rol_id = ?, usu_pass = ? WHERE usu_id = ?");
                $stmt->execute([$usu_nom, $usu_correo, $rol_id, password_hash($usu_pass, PASSWORD_DEFAULT), $usu_id]);
            } else {
                $stmt = $conexion->prepare("UPDATE usuario SET usu_nom = ?, usu_correo = ?, rol_id = ? WHERE usu_id = ?");
                $stmt->execute([$usu_nom, $usu_correo, $rol_id, $usu_id]);
            }
        } else {
            // Insertar nuevo usuario
            $stmt = $conexion->prepare("INSERT INTO usuario (usu_nom, usu_correo, rol_id, usu_pass) VALUES (?, ?, ?, ?)");
            $stmt->execute([$usu_nom, $usu_correo, $rol_id, password_hash($usu_pass, PASSWORD_DEFAULT)]);
        }
        echo json_encode(['status' => 'success']);
        break;

    case 'mostrar':
        $id = $_GET['id'] ?? '';
        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE usu_id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($usuario);
        break;

    case 'eliminar':
        $id = $_GET['id'] ?? '';
        $stmt = $conexion->prepare("DELETE FROM usuario WHERE usu_id = ?");
        $stmt->execute([$id]);
        echo json_encode(['status' => 'success']);
        break;

    default:
        echo json
::contentReference[oaicite:0]{index=0}
 
