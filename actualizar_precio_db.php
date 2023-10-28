<?php
// Conexión a la base de datos (debes incluir tu propio archivo de conexión)
include("conexion.php");
$con = conectar();

// Recuperar los datos enviados por la solicitud AJAX
$data = json_decode(file_get_contents("php://input"));

if ($data) {
    $id = $data->id; // ID del producto a actualizar
    $nuevoPrecio = $data->nuevoPrecio; // Nuevo precio

    // Consulta SQL para actualizar el precio en la base de datos
    $sql = "UPDATE producto SET precio = $nuevoPrecio WHERE id = $id";

    if (mysqli_query($con, $sql)) {
        // Éxito: El precio se actualizó en la base de datos
        $response = array("success" => true);
        echo json_encode($response);
    } else {
        // Error: No se pudo actualizar el precio
        $response = array("success" => false, "error" => mysqli_error($con));
        echo json_encode($response);
    }
} else {
    // Error: Datos no válidos
    $response = array("success" => false, "error" => "Datos no válidos");
    echo json_encode($response);
}

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>
