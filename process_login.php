<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        echo 'Por favor, completa todos los campos.';
    } else {
        // Conectar a la base de datos
        $conn = new mysqli("localhost", "root", "", "trabajo");

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para seleccionar ID junto con el nombre de usuario y contraseña
        $query = "SELECT id, Usuario, Contraseña, Administrador FROM usuarios WHERE Usuario = '$username'";
        $result = $conn->query($query);

        // Verificar si se encontró un usuario
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['Contraseña'] === $password) {
                // Autenticación exitosa
                $_SESSION['user_id'] = $row['id']; // Guardar el ID del usuario en la sesión
                $_SESSION['username'] = $username; // Guardar el nombre de usuario en la sesión si es necesario

                // Redireccionar según el tipo de usuario
                if ($row['Administrador'] == 1) {
                    // Usuario es administrador, redireccionar a página de admin
                    header('Location: admin.php');
                } else {
                    // Usuario no es administrador, redireccionar a objetos.php
                    header('Location: objetos.php');
                }
                exit;
            } else {
                // Autenticación fallida
                echo 'Contraseña incorrecta. Inténtalo de nuevo.';
            }
        } else {
            // Usuario no encontrado
            echo 'Usuario no encontrado. Inténtalo de nuevo.';
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    }
}
?>
