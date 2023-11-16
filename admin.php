<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "trabajo");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener todos los usuarios
$usuarios_query = "SELECT * FROM usuarios";
$usuarios_result = $conn->query($usuarios_query);

// Consulta para obtener todos los productos
$productos_query = "SELECT * FROM productos";
$productos_result = $conn->query($productos_query);

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página de Administrador</title>
    <!-- Estilos, si es necesario -->
</head>
<body>
    <h1>Tabla de Usuarios</h1>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Contraseña</th>
            <th>Acción</th>
        </tr>
        <?php
        // Mostrar datos de la tabla de usuarios
        if ($usuarios_result->num_rows > 0) {
            while ($row = $usuarios_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["Usuario"] . "</td>";
                echo "<td>" . $row["contraseña"] . "</td>";
                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='delete_user_id' value='" . $row["id"] . "'>
                        <input type='submit' name='delete_user' value='Eliminar'>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay usuarios</td></tr>";
        }

        // Procesamiento de eliminación
        if (isset($_POST['delete_user'])) {
            $delete_user_id = $_POST['delete_user_id'];

            // Realizar la eliminación en la tabla de usuarios
            $conn = new mysqli("localhost", "root", "", "trabajo");
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consulta para eliminar el usuario
            $eliminar_query = "DELETE FROM usuarios WHERE id = $delete_user_id";

            if ($conn->query($eliminar_query) === TRUE) {
                echo "<p>Usuario eliminado correctamente.</p>";
            } else {
                echo "<p>Error al eliminar usuario: " . $conn->error . "</p>";
            }

            $conn->close();
        }
        ?>
    </table>

    <h1>Tabla de Productos</h1>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acción</th>
        </tr>
        <?php
        // Mostrar datos de la tabla de productos
        if ($productos_result->num_rows > 0) {
            while ($row = $productos_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["precio"] . "</td>";
                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='delete_product_id' value='" . $row["id"] . "'>
                        <input type='submit' name='delete_product' value='Eliminar'>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay productos</td></tr>";
        }

        // Procesamiento de eliminación de productos
        if (isset($_POST['delete_product'])) {
            $delete_product_id = $_POST['delete_product_id'];

            // Realizar la eliminación en la tabla de productos
            $conn = new mysqli("localhost", "root", "", "trabajo");
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consulta para eliminar el producto
            $eliminar_query = "DELETE FROM productos WHERE id = $delete_product_id";

            if ($conn->query($eliminar_query) === TRUE) {
                echo "<p>Producto eliminado correctamente.</p>";
            } else {
                echo "<p>Error al eliminar producto: " . $conn->error . "</p>";
            }

            $conn->close();
        }
        ?>
    </table>
</body>
</html>