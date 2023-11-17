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
        if (isset($_POST['modificar']) && isset($_POST['estadoActual'])){
            $modificar = $_POST['modificar'];
    
                // Realizar la eliminación en la tabla de usuarios
                $conn = new mysqli("localhost", "root", "", "trabajo");
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                $modificar_query = "UPDATE usuarios SET Administrador = $valor WHERE id = $modificar";
    
                if ($conn->query($modificar_query) === TRUE) {
                    echo "<p>Usuario eliminado correctamente.</p>";
                } else {
                    echo "<p>Error al eliminar usuario: " . $conn->error . "</p>";
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
        form{
            margin-bottom: 0px;
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

        <!-- Botón para agregar usuario -->
    <button onclick="mostrarFormulario()">Añadir Usuario</button>

    <!-- Formulario para agregar usuario (inicialmente oculto) -->
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