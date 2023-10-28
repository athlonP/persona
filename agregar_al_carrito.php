<?php
include("conexion.php");
$con=conectar();


// Verifica si se recibieron datos de la solicitud AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se recibieron los datos necesarios (productId, productName, productPrice)
    if (isset($_POST['id']) && isset($_POST['producto']) && isset($_POST['Precio'])) {
        // Obtiene los datos del producto de la solicitud AJAX
        $product_id = $_POST['id'];
        $product_name = $_POST['produco'];
        $product_price = $_POST['Precio'];

        // Crea un array asociativo para representar el producto
        $product = array(
            'id' => $product_id,
            'producto' => $product_name,
            'precio' => $product_price,
        );

        // Agrega el producto al carrito de compras (almacenado en la sesión)
        if (!isset($_SESSION['cart'])) {
            // Si el carrito de compras no existe en la sesión, crea uno
            $_SESSION['cart'] = array();
        }

        // Agrega el producto al carrito
        $_SESSION['cart'][] = $product;

        // Responde con un mensaje de éxito (esto es solo un ejemplo, puedes personalizarlo)
        $response = array(
            'success' => true,
            'message' => 'El producto se ha agregado al carrito correctamente.',
        );

        // Envía la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Si no se recibieron todos los datos necesarios, responde con un error
        $response = array(
            'success' => false,
            'message' => 'Faltan datos para agregar el producto al carrito.',
        );

        // Envía la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // Si la solicitud no es POST, responde con un error
    $response = array(
        'success' => false,
        'message' => 'Método de solicitud no válido. Debe ser una solicitud POST.',
    );

    // Envía la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
