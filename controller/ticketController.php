<?php
ob_start(); // Inicia el buffer
header('Content-Type: application/json');

ini_set('display_errors', 1); // ACTIVAR temporalmente para debug
error_reporting(E_ALL);

require_once("../config/conexion.php");
require_once("../models/Ticket.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ob_end_clean(); // Limpia antes de cualquier salida

$ticket = new Ticket();
$usu_id_sesion = $_SESSION['usu_id'] ?? null;
$rol_id_sesion = $_SESSION['rol_id'] ?? null;

if (isset($_GET["op"])) {
    switch ($_GET["op"]) {

        case "listar":
            $datos = $ticket->listar_ticket();
            $data = [];

            foreach ($datos as $row) {
                $data[] = [
                    $row["ticket_id"],
                    $row["cat_nom"],
                    $row["ticket_titulo"],
                    $row["nombre_completo_usuario"] ?? '',
                    date("d/m/Y H:i:s", strtotime($row["fecha_crea"])),
                    ($row["estado_nombre_display"] == 'Abierto')
                        ? '<span class="label label-success">Abierto</span>'
                        : '<span class="label label-danger">Cerrado</span>',
                    '<button type="button" onClick="ver(' . $row["ticket_id"] . ');" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>'
                ];
            }

            echo json_encode([
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "data" => $data
            ]);
            exit();

        case "listar_x_usu":
            $datos = $ticket->listar_ticket_x_usu($usu_id_sesion);
            $data = [];

            foreach ($datos as $row) {
                $data[] = [
                    $row["ticket_id"],
                    $row["cat_nom"],
                    $row["ticket_titulo"],
                    $row["nombre_completo_usuario"] ?? '',
                    date("d/m/Y H:i:s", strtotime($row["fecha_crea"])),
                    ($row["estado_nombre_display"] == 'Abierto')
                        ? '<span class="label label-success">Abierto</span>'
                        : '<span class="label label-danger">Cerrado</span>',
                    '<button type="button" onClick="ver(' . $row["ticket_id"] . ');" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>'
                ];
            }

            echo json_encode([
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "data" => $data
            ]);
            exit();

        case "cerrar":
            $ticket->cerrar_ticket($_POST["ticket_id"]);
            echo json_encode(["success" => true, "message" => "Ticket cerrado exitosamente."]);
            exit();

        case "listar_por_estado":
            $estado = $_POST["estado"];
            $datos = $ticket->listar_ticket_x_estado($usu_id_sesion, $estado, $rol_id_sesion);
            $data = [];

            foreach ($datos as $row) {
                $data[] = [
                    $row["ticket_id"],
                    $row["cat_nom"],
                    $row["ticket_titulo"],
                    $row["nombre_completo_usuario"] ?? '',
                    date("d/m/Y H:i:s", strtotime($row["fecha_crea"])),
                    ($row["estado_nombre_display"] == 'Abierto')
                        ? '<span class="label label-success">Abierto</span>'
                        : '<span class="label label-danger">Cerrado</span>',
                    '<button type="button" onClick="ver(' . $row["ticket_id"] . ');" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>'
                ];
            }

            echo json_encode([
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "data" => $data
            ]);
            exit();

        default:
            echo json_encode(["success" => false, "message" => "Operación desconocida"]);
            exit();
    }
} else {
    echo json_encode(["success" => false, "message" => "No se especificó 'op' en la URL"]);
    exit();
}
