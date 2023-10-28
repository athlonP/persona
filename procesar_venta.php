<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");
$con = conectar();

// Verifica que la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica que la solicitud contiene datos JSON
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id']) && isset($data['nuevoStock'])) {
        // Obtiene los datos del JSON
        $id = $data['id'];
        $nuevoStock = $data['nuevoStock'];

        // Actualiza el stock en la base de datos
        $sql = "UPDATE producto SET stock = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $nuevoStock, $id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Éxito: devolver una respuesta JSON con éxito
            echo json_encode(['success' => true]);
        } else {
            // Error: devolver una respuesta JSON con el error
            echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
        }
    } else {
        // Datos insuficientes en la solicitud
        echo json_encode(['success' => false, 'error' => 'Datos insuficientes']);
    }
} else {
    // Método de solicitud no permitido
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>

