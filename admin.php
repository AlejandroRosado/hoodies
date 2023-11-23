<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "trabajo");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

    // Verificación y procesamiento del formulario de agregar usuario
    if (isset($_POST['agregar_usuario'])) {
        $nombre_usuario = $_POST['nombre_usuario'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $es_admin = $_POST['es_admin'];

        // Realizar la inserción en la tabla de usuarios
        $conn = new mysqli("localhost", "root", "", "trabajo");
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para agregar un nuevo usuario
        $insertar_query = "INSERT INTO usuarios (nombre, Usuario, contraseña, Administrador) 
                           VALUES ('$nombre_usuario', '$usuario', '$password', $es_admin)";

        if ($conn->query($insertar_query) === TRUE) {
            echo "<p>Usuario agregado correctamente.</p>";
        } else {
            echo "<p>Error al agregar usuario: " . $conn->error . "</p>";
        }
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
    

            }
            if (isset($_POST['modificar']) && isset($_POST['estadoActual']) && isset($_POST['cambiar_permisos'])) {
                $modificar = $_POST['modificar'];
                $estado_actual = $_POST['estadoActual'];
                
                // Cambiar el valor de Administrador de 0 a 1 o de 1 a 0
                $nuevo_estado = ($estado_actual == 0) ? 1 : 0;
            
                $conn = new mysqli("localhost", "root", "", "trabajo");
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
            
                $modificar_query = "UPDATE usuarios SET Administrador = $nuevo_estado WHERE id = $modificar";
            
                if ($conn->query($modificar_query) === TRUE) {
                    echo "<p>Permisos modificados correctamente.</p>";
                } else {
                    echo "<p>Error al modificar los permisos del usuario: " . $conn->error . "</p>";
                }
            
                //$conn->close();
            } else {
                echo "<p>No se proporcionaron datos para modificar los permisos.</p>";
            }
            if (isset($_POST['delete_detalle'])) {
                $delete_detalle_id = $_POST['delete_detalle_id'];
    
                // Realizar la eliminación en la tabla de detalles de pedidos
                $eliminar_detalle_query = "DELETE FROM detalles_pedido WHERE id = $delete_detalle_id";
    
                if ($conn->query($eliminar_detalle_query) === TRUE) {
                    echo "<p>Detalle de pedido eliminado correctamente.</p>";
                    
                } else {
                    echo "<p>Error al eliminar el detalle de pedido: " . $conn->error . "</p>";
                }
            }
            if (isset($_POST['delete_pedido'])) {
                $delete_pedido_id = $_POST['delete_pedido_id'];
    
                // Realizar la eliminación en la tabla de pedidos
                $eliminar_pedido_query = "DELETE FROM pedidos WHERE id = $delete_pedido_id";
    
                if ($conn->query($eliminar_pedido_query) === TRUE) {
                    echo "<p>Pedido eliminado correctamente.</p>";
                    
                } else {
                    echo "<p>Error al eliminar el pedido: " . $conn->error . "</p>";
                }
            }
            if (isset($_POST['delete_product'])) {
                $delete_product_id = $_POST['delete_product_id'];
    
                // Realizar la eliminación en la tabla de productos
                $eliminar_producto_query = "DELETE FROM productos WHERE id = $delete_product_id";
    
                if ($conn->query($eliminar_producto_query) === TRUE) {
                    echo "<p>Producto eliminado correctamente.</p>";
                    header("Refresh:0");
                } else {
                    echo "<p>Error al eliminar el producto: " . $conn->error . "</p>";
                }
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
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 20px;
}

h1 {
    text-align: center;
}

table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

form {
    margin-bottom: 0px;
}

button {
    padding: 10px;
    margin-bottom: 10px;
    cursor: pointer;
}

#formulario {
    margin-top: 20px;
}

    </style>
</head>
<body>
<?php
    ?>
    <h1>Tabla de Usuarios</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Contraseña</th>
            <th>Administrador</th>
            <th>Acciones</th>
            <th>Permisos</th>
        </tr>
        <?php
        // Mostrar datos de la tabla de usuarios
        if ($usuarios_result->num_rows > 0) {
            while ($row = $usuarios_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["Usuario"] . "</td>";
                echo "<td>" . $row["contraseña"] . "</td>";
                echo "<td>" . $row["Administrador"] . "</td>";
                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='delete_user_id' value='" . $row["id"] . "'>
                            <input type='submit' name='delete_user' value='Eliminar'>
                        </form>
                    </td>";
                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='modificar' value='" . $row["id"] . "'>
                            <input type='hidden' name='estadoActual' value='" . $row["Administrador"] . "'>
                            <input type='hidden' name='cambiar_permisos' value='1'>
                            <input type='submit' value='Permisos'>
                        </form>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay usuarios</td></tr>";
        }
        // Mostrar datos de la tabla de usuarios
        ?>
        
    </table>
    <td>
    
</td>
       
    <button onclick="mostrarFormulario()">Añadir Usuario</button>

    <div id="formulario" style="display: none;">
        <h2>Agregar Nuevo Usuario</h2>
        <form method="post">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" required>
            <br>
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="es_admin">Administrador (0 o 1):</label>
            <input type="number" id="es_admin" name="es_admin" min="0" max="1" required>
            <br>
            <input type="submit" name="agregar_usuario" value="Enviar">
        </form>
    </div>


    <script>
    // Función para mostrar/ocultar el formulario
    function mostrarFormulario() {
        var formulario = document.getElementById('formulario');
        formulario.style.display = (formulario.style.display === 'none') ? 'block' : 'none';
    }
    </script>

    </table>

    <h1>Tabla de Productos</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Acción</th>
        </tr>
        <?php
        // Conexión a la base de datos
        $conn = new mysqli("localhost", "root", "", "trabajo");
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener todos los productos
        $productos_query = "SELECT * FROM productos";
        $productos_result = $conn->query($productos_query);

        // Mostrar datos de la tabla de productos
        if ($productos_result->num_rows > 0) {
            while ($row = $productos_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["descripcion"] . "</td>";
                echo "<td>" . $row["precio"] . "</td>";
                echo "<td><img src='" . $row["imagen"] . "' alt='Imagen de " . $row["nombre"] . "' width='100'></td>";
                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='delete_product_id' value='" . $row["id"] . "'>
                        <input type='submit' name='delete_product' value='Eliminar'>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay productos</td></tr>";
        }

        // Procesamiento de eliminación de productos
        

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </table>

    <h1>Tabla de Pedidos</h1>
    <table border="1">
        <tr>
            <th>ID Pedido</th>
            <th>ID Cliente</th>
            <th>Fecha Pedido</th>
            <th>Total</th>
            <th>Acción</th>
        </tr>
        <?php
        // Conexión a la base de datos
        $conn = new mysqli("localhost", "root", "", "trabajo");
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener todos los pedidos
        $pedidos_query = "SELECT * FROM pedidos";
        $pedidos_result = $conn->query($pedidos_query);

        // Mostrar datos de la tabla de pedidos
        if ($pedidos_result->num_rows > 0) {
            while ($row = $pedidos_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["cliente_id"] . "</td>";
                echo "<td>" . $row["fecha_pedido"] . "</td>";
                echo "<td>" . $row["total"] . "</td>";
                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='delete_pedido_id' value='" . $row["id"] . "'>
                        <input type='submit' name='delete_pedido' value='Eliminar'>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay pedidos</td></tr>";
        }

        // Procesamiento de eliminación de pedidos
        

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </table>
    
    <h1>Tabla de Detalles de Pedidos</h1>
    <table border="1">
        <tr>
            <th>ID Detalle</th>
            <th>ID Pedido</th>
            <th>ID Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Acción</th>
        </tr>
        <?php
        // Conexión a la base de datos
        $conn = new mysqli("localhost", "root", "", "trabajo");
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener todos los detalles de pedidos
        $detalles_query = "SELECT * FROM detalles_pedido";
        $detalles_result = $conn->query($detalles_query);

        // Mostrar datos de la tabla de detalles de pedidos
        if ($detalles_result->num_rows > 0) {
            while ($row = $detalles_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["pedido_id"] . "</td>";
                echo "<td>" . $row["producto_id"] . "</td>";
                echo "<td>" . $row["cantidad"] . "</td>";
                echo "<td>" . $row["precio_unitario"] . "</td>";
                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='delete_detalle_id' value='" . $row["id"] . "'>
                        <input type='submit' name='delete_detalle' value='Eliminar'>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay detalles de pedidos</td></tr>";
        }

        // Procesamiento de eliminación de detalles de pedidos
        

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </table>
    <br><br><br>
    <form method="get" action="login.php">
        <button type="submit">Volver a la página de inicio de sesión</button>
    </form>
</body>
</html>