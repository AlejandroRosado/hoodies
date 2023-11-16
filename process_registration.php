
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $nombre_apellido = isset($_POST['nombre_apellido']) ? $_POST['nombre_apellido'] : '';

    // Verificar si las contraseñas coinciden
    if ($password !== $confirm_password) {
        echo 'Las contraseñas no coinciden. Inténtalo de nuevo.';
        exit;
    }

    // Verificar si la longitud del nombre de usuario y contraseña es válida
    if (strlen($username) > 20 || strlen($password) > 20) {
        echo 'El nombre de usuario y la contraseña deben tener menos de 20 caracteres.';
        exit;
    }

    // Separar el nombre de usuario y la contraseña
    list($nombre, $apellido) = explode(' ', $nombre_apellido, 2);

    // Verificar si la conexión a la base de datos es exitosa
    $conn = new mysqli("localhost", "root", "", "trabajo");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para insertar un nuevo usuario
    $admin_value = 0; // Valor predeterminado para el campo Administrador

    $insert_query = "INSERT INTO usuarios (nombre, Usuario, contraseña, Administrador) VALUES ('$nombre_apellido', '$username', '$password', $admin_value)";

    if ($conn->query($insert_query) === TRUE) {
        echo 'Registro exitoso. Ahora puedes iniciar sesión.';
        // Redirigir a la página de inicio de sesión
        header('Location: login.php');
    } else {
        echo 'Error al registrar el usuario: ' . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>