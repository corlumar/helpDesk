<?php
require_once("config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["usu_nom"] ?? '');
    $correo = trim($_POST["usu_correo"] ?? '');
    $password = $_POST["usu_pass"] ?? '';
    $recaptcha_response = $_POST["g-recaptcha-response"] ?? '';

    // Validar campos
    if (empty($nombre) || empty($correo) || empty($password) || empty($recaptcha_response)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
        exit;
    }

    // Validar reCAPTCHA
    $secret_key = "6Le3slMrAAAAAB7_Evb0Cnih2rVAcCWBA0t1TH0-";
    $verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$recaptcha_response}");
    $response_data = json_decode($verify_response);

    if (!$response_data->success) {
        echo json_encode(["success" => false, "message" => "Verificación de reCAPTCHA fallida."]);
        exit;
    }

    // Verificar si el correo ya existe
    $stmt = $conexion->prepare("SELECT usu_id FROM usuarios WHERE usu_correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "El correo ya está registrado."]);
        exit;
    }
    $stmt->close();

    // Encriptar contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt = $conexion->prepare("INSERT INTO usuarios (usu_nom, usu_correo, usu_pass, rol_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $correo, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar el usuario."]);
    }
    $stmt->close();
}
?>
