<?php
include("conexion.php");
$con = conectar();

// Obtener los datos enviados por la solicitud POST
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$nuevoStock = $data['nuevoStock'];

// Actualizar el stock en la base de datos
$sql = "UPDATE producto SET stock = ? WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "ii", $nuevoStock, $id);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    // Éxito: devolver una respuesta JSON
    echo json_encode(['success' => true]);
} else {
    // Error: devolver una respuesta JSON con el error
    echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
}

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>
