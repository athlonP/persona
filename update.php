<?php
include("conexion.php");
$con = conectar();

$id = $_POST['id'];
$codigo = $_POST['codigo'];
$producto = $_POST['producto'];
$marca = $_POST['marca'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$fecha_compra = $_POST['fecha_compra'];

// Validación de datos (puedes personalizarla según tus necesidades)
if (!is_numeric($id) || $id <= 0) {
    die("ID de producto no válido.");
}
if (!is_numeric($precio) || $precio < 0) {
    die("Precio no válido.");
}
if (!is_numeric($stock) || $stock < 0) {
    die("Stock no válido.");
}
// Puedes agregar más validaciones para otros campos según tus requisitos

// Utiliza consultas preparadas para evitar SQL Injection
$sql = "UPDATE producto SET codigo=?, producto=?, marca=?, precio=?, stock=?, fecha_compra=? WHERE id=?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "sssdisi", $codigo, $producto, $marca, $precio, $stock, $fecha_compra, $id);

if (mysqli_stmt_execute($stmt)) {
    // Redirige a una página de confirmación o lista actualizada
    header("Location: product.php");
    exit(); // Termina el script después de la redirección
} else {
    // Manejo de errores
    echo "Error al actualizar el registro: " . mysqli_error($con);
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
