<?php
require_once("../config/conexion.php");

class Ticket extends Conectar {

    public function insert_ticket($usu_id, $cat_id, $ticket_titulo, $ticket_descripcion, $ticket_estado) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO tm_ticket (usu_id, cat_id, ticket_titulo, ticket_descripcion, ticket_estado, fecha_crea, est) 
                VALUES (?, ?, ?, ?, ?, now(),'1');";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $usu_id);
        $stmt->bindValue(2, $cat_id);
        $stmt->bindValue(3, $ticket_titulo);
        $stmt->bindValue(4, $ticket_descripcion);
        $stmt->bindValue(5, $ticket_estado);
        return $stmt->execute();
    }

    public function listar_ticket_x_usu($usu_id) {
        $conectar = parent::conexion();
        $sql = "SELECT
                    tm_ticket.ticket_id,
                    tm_ticket.ticket_titulo,
                    tm_categoria.cat_nom,
                    CONCAT(tm_usuario.usu_nom, ' ', tm_usuario.usu_ape) AS nombre_completo_usuario,
                    tm_ticket.fecha_crea,
                    CASE tm_ticket.ticket_estado
                        WHEN 'Abierto' THEN 'Abierto'
                        WHEN 'Cerrado' THEN 'Cerrado'
                        ELSE 'Desconocido'
                    END AS estado_nombre_display,
                    tm_ticket.ticket_id AS acciones_id
                FROM tm_ticket
                INNER JOIN tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
                INNER JOIN tm_usuario ON tm_ticket.usu_id = tm_usuario.usu_id
                WHERE tm_ticket.usu_id = ? AND tm_ticket.ticket_estado = 'Abierto'
                ORDER BY tm_ticket.ticket_id DESC";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $usu_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_ticket_por_id($ticket_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    t.ticket_id, 
                    t.ticket_titulo AS ticket_titulo, 
                    t.ticket_descripcion AS ticket_descripcion, 
                    t.ticket_estado AS ticket_estado, 
                    t.fecha_crea AS fecha_crea, 
                    c.cat_nom AS categoria, 
                    u.usu_nom AS usuario_nombre, 
                    u.usu_ape AS usuario_apellid
                FROM tm_ticket t
                INNER JOIN tm_categoria c ON t.cat_id = c.cat_id
                INNER JOIN tm_usuario u ON t.usu_id = u.usu_id
                WHERE t.ticket_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $ticket_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar_ticket($ticket_id, $titulo, $descripcion) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_ticket 
                SET ticket_titulo = ?, ticket_descripcion = ? 
                WHERE ticket_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $titulo);
        $stmt->bindValue(2, $descripcion);
        $stmt->bindValue(3, $ticket_id);
        return $stmt->execute();
    }

    public function listar_ticket() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
                    tm_ticket.ticket_id,
                    tm_ticket.ticket_titulo,
                    tm_categoria.cat_nom,
                    CONCAT(tm_usuario.usu_nom, ' ', tm_usuario.usu_ape) AS nombre_completo_usuario,
                    tm_ticket.fecha_crea,
                    tm_ticket.ticket_estado AS estado_nombre_display,
                    tm_ticket.ticket_id AS acciones_id
                FROM tm_ticket
                INNER JOIN tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
                INNER JOIN tm_usuario ON tm_ticket.usu_id = tm_usuario.usu_id
                WHERE tm_ticket.estado = 1
                ORDER BY tm_ticket.ticket_id DESC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cerrar_ticket($ticket_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_ticket SET ticket_estado = 'Cerrado' WHERE ticket_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $ticket_id);
        return $stmt->execute();
    }

    public function listar_ticket_x_estado($usu_id, $estado, $rol_id) {
        $conectar = parent::conexion();
        parent::set_names();

        if ($rol_id == 3) {
            $sql = "SELECT
                        tm_ticket.ticket_id,
                        tm_ticket.ticket_titulo,
                        tm_categoria.cat_nom,
                        CONCAT(tm_usuario.usu_nom, ' ', tm_usuario.usu_ape) AS nombre_completo_usuario,
                        tm_ticket.fecha_crea,
                        tm_ticket.ticket_estado AS estado_nombre_display,
                        tm_ticket.ticket_id AS acciones_id
                    FROM tm_ticket
                    INNER JOIN tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
                    INNER JOIN tm_usuario ON tm_ticket.usu_id = tm_usuario.usu_id
                    WHERE tm_ticket.usu_id = ? AND tm_ticket.ticket_estado = ?
                    ORDER BY tm_ticket.ticket_id DESC";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->bindValue(2, $estado);
        } else {
            $sql = "SELECT
                        tm_ticket.ticket_id,
                        tm_ticket.ticket_titulo,
                        tm_categoria.cat_nom,
                        CONCAT(tm_usuario.usu_nom, ' ', tm_usuario.usu_ape) AS nombre_completo_usuario,
                        tm_ticket.fecha_crea,
                        tm_ticket.ticket_estado AS estado_nombre_display,
                        tm_ticket.ticket_id AS acciones_id
                    FROM tm_ticket
                    INNER JOIN tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
                    INNER JOIN tm_usuario ON tm_ticket.usu_id = tm_usuario.usu_id
                    WHERE tm_ticket.ticket_estado = ?
                    ORDER BY tm_ticket.ticket_id DESC";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $estado);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
