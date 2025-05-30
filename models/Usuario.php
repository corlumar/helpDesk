<?php
require_once("config/conexion.php");

class Usuario extends Conectar {
    public function login() {
        $conectar = parent::conexion();
        parent::set_names();

        if (isset($_POST["enviar"]) && $_POST["enviar"] == "si") {
            $correo = $_POST["usu_correo"];
            $pass = $_POST["usu_pass"];
            $rol = $_POST["rol_id"];

            if (empty($correo) || empty($pass)) {
               header("Location:" . Conectar::ruta() . "login.php?login=success");
                exit();
            }

            $sql = "SELECT * FROM tm_usuario 
                    WHERE usu_correo = ? AND usu_pass = ? AND rol_id = ? AND estado = '1'";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $correo);
            $stmt->bindValue(2, $pass);
            $stmt->bindValue(3, $rol);
            $stmt->execute();
            $resultado = $stmt->fetch();

            if (is_array($resultado) && count($resultado) > 0) {
                $_SESSION["usu_id"] = $resultado["usu_id"];
                $_SESSION["usu_nom"] = $resultado["usu_nom"];
                $_SESSION["usu_ape"] = $resultado["usu_ape"];
                $_SESSION["rol_id"] = $resultado["rol_id"];
                $_SESSION["avatar"] = $resultado["avatar"];

                switch ($resultado["rol_id"]) {
                    case 1:
                        $_SESSION["rol_nombre"] = "Administrador";
                        header("Location: views/Admin/dashboard.php");
                        break;
                    case 2:
                        $_SESSION["rol_nombre"] = "Soporte";
                        header("Location: views/Soporte/dashboard.php");
                        break;
                    case 3:
                        $_SESSION["rol_nombre"] = "Usuario";
                        header("Location: views/Usuario/dashboard.php");
                        break;
                    default:
                        $_SESSION["rol_nombre"] = "Sin Rol";
                        header("Location: login.php?m=3");
                        break;
                }
                exit();
            } else {
                header("Location: index.php?m=1");
                exit();
            }
        }
    }
}
?>
