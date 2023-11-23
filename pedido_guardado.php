<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "trabajo");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el ID del cliente desde la sesión
    $cliente_id = $_SESSION['user_id'];

    // Consulta para obtener los pedidos del cliente
    $query = "SELECT * FROM pedidos WHERE cliente_id = $cliente_id ORDER BY fecha_pedido DESC LIMIT 1"; // Último pedido realizado por el cliente
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $pedido = $result->fetch_assoc();
        $pedido_id = $pedido['id'];

        // Consulta para obtener los detalles del pedido
        $detalles_query = "SELECT * FROM detalles_pedido WHERE pedido_id = $pedido_id";
        $detalles_result = $conn->query($detalles_query);

        // Mostrar los detalles del pedido
        echo "<style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                margin: 20px;
            }

            h1 {
                text-align: center;
            }

            p {
                text-align: center;
                font-size: 18px;
            }

            ul {
                list-style-type: none;
                padding: 0;
                text-align: center;
            }

            li {
                font-size: 16px;
                margin-bottom: 10px;
            }

            form {
                text-align: center;
                margin-top: 20px;
            }

            input[type='submit'] {
                padding: 10px 20px;
                font-size: 16px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            input[type='submit']:hover {
                background-color: #45a049;
            }
        </style>";

        echo "<h1>Detalle de tu pedido</h1>";
        echo "<p>ID del pedido: " . $pedido['id'] . "</p>";
        echo "<p>Fecha del pedido: " . $pedido['fecha_pedido'] . "</p>";
        echo "<p>Total: $" . $pedido['total'] . "</p>";

        if ($detalles_result->num_rows > 0) {
            echo "<h2>Productos:</h2>";
            echo "<ul>";
            while ($detalle = $detalles_result->fetch_assoc()) {
                echo "<li>" . $detalle['producto_id'] . " - Cantidad: " . $detalle['cantidad'] . " - Precio unitario: $" . $detalle['precio_unitario'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay productos en este pedido.</p>";
        }
    } else {
        echo "<p>No se encontraron pedidos para este cliente.</p>";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    echo "<p>No hay usuario logueado.</p>";
}
echo "<form action='objetos.php'>";
echo "<input type='submit' value='Volver a la Tienda'>";
echo "</form>"
?>
