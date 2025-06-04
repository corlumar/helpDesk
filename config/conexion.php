<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Conectar {
    protected $dbh;

    protected function conexion() {
        try {
            $conectar = $this->dbh = new PDO("mysql:host=localhost;dbname=helpdesk", "root", "");
            $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conectar;
        } catch (Exception $e) {
            print "Error BD: " . $e->getMessage() . "<br>";
            die();
        }
    }

    public function set_names() {
        return $this->dbh->query("SET NAMES 'utf8'");
    }

    public function ruta() {
        return "http://localhost/HelpDesk/";
    }
}
?>

