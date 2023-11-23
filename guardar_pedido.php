<?php
session_start();

// Verificar si se hizo clic en el botón "Guardar Pedido"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart']) && isset($_SESSION['total'])) {
    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "trabajo");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el ID del cliente de la sesión
    $cliente_id = $_SESSION['user_id']; // Suponiendo que guardas el ID del cliente en la sesión

    // Formatear el total como un número decimal
    $total = number_format($_SESSION['total'], 2, '.', '');

    // Obtener la fecha actual en el formato 'YYYY-MM-DD'
    $fecha_pedido = date("Y-m-d");

    // Insertar el pedido en la tabla 'pedidos'
    $insertPedidoQuery = "INSERT INTO pedidos (cliente_id, fecha_pedido, total) VALUES ($cliente_id, '$fecha_pedido', '$total')";
    $conn->query($insertPedidoQuery);

    // Obtener el ID del último pedido insertado
    $pedidoID = $conn->insert_id;
    // Recorrer los productos en el carrito y guardar los detalles en 'detalles_pedido'
    foreach ($_SESSION['cart'] as $item) {
        $producto_id = $item['id']; // Este es el ID del producto en el carrito
     // Suponiendo que el ID del producto está en 'id' en el carrito
        $cantidad = 1; // Suponiendo que la cantidad es siempre 1 en este ejemplo
        $precio_unitario = $item['price'];
        // Insertar los detalles del producto en 'detalles_pedido'
        $insertDetailsQuery = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario) VALUES ('$pedidoID', '$producto_id', '$cantidad', '$precio_unitario')";
        $conn->query($insertDetailsQuery);
    }

    // Limpiar el carrito y la sesión después de guardar el pedido
    unset($_SESSION['cart']);
    unset($_SESSION['total']);

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Redireccionar o mostrar un mensaje de éxito
    header('Location: pedido_guardado.php');
    exit;
}
?>

