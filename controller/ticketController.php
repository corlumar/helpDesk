<?php
ob_start(); // Inicia el buffer
header('Content-Type: application/json');

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../config/conexion.php");
require_once("../models/Ticket.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Validar sesión ANTES de limpiar el buffer
if (!isset($_SESSION['usu_id']) || !isset($_SESSION['rol_id'])) {
    echo json_encode(["success" => false, "message" => "No autenticado"]);
    exit();
}

// Ahora limpia
ob_end_clean();

$ticket = new Ticket();
$usu_id_sesion = $_SESSION['usu_id'];
$rol_id_sesion = $_SESSION['rol_id'];

if (isset($_GET["op"])) {
    switch ($_GET["op"]) {

        case "listar":
            $datos = $ticket->listar_ticket();
            break;

        case "listar_x_usu":
            $datos = $ticket->listar_ticket_x_usu($usu_id_sesion);
            break;

        case "listar_por_estado":
            $estado = $_POST["estado"] ?? '';
            $datos = $ticket->listar_ticket_x_estado($usu_id_sesion, $estado, $rol_id_sesion);
            break;

        case "cerrar":
            $ticket->cerrar_ticket($_POST["ticket_id"]);
            echo json_encode(["success" => true, "message" => "Ticket cerrado exitosamente."]);
            exit();

        case "obtener":
            if (!isset($_GET["ticket_id"])) {
                echo json_encode(["success" => false, "message" => "Falta el ID del ticket"]);
                exit();
            }
            $ticket_id = intval($_GET["ticket_id"]);
            $datos = $ticket->obtener_ticket_por_id($ticket_id);
            echo json_encode($datos ?: ["success" => false, "message" => "Ticket no encontrado"]);
            exit();

        case "actualizar":
            $ticket_id = $_POST["ticket_id"];
            $titulo = $_POST["ticket_titulo"];
            $descripcion = $_POST["ticket_descripcion"];
            $resultado = $ticket->actualizar_ticket($ticket_id, $titulo, $descripcion);
            echo json_encode([
                "success" => $resultado,
                "message" => $resultado ? "Ticket actualizado correctamente" : "No se pudo actualizar"
            ]);
            exit();
            
        case "insert":
            
                $resultado = $ticket->insert_ticket(
                $_POST["usu_id"],
                $_POST["cat_id"],
                $_POST["ticket_titulo"],
                $_POST["ticket_descripcion"],
                "Abierto" // Estado inicial
            );

            echo json_encode([
                "success" => $resultado,
                "message" => $resultado ? "Ticket creado correctamente." : "Error al crear el ticket."
            ]);
            exit();
   

        default:
            echo json_encode(["success" => false, "message" => "Operación desconocida"]);
            exit();
    }

    // Si llega aquí, es un caso de listar
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
} else {
    echo json_encode(["success" => false, "message" => "No se especificó 'op' en la URL"]);
    exit();
}
