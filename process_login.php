<?php
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

        // Consulta simple sin preparación (vulnerable a inyección SQL)
        $query = "SELECT Usuario, Contraseña, Administrador FROM usuarios WHERE Usuario = '$username'";
        $result = $conn->query($query);

        // Verificar si se encontró un usuario
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verificar la contraseña
            if ($row['Contraseña'] === $password) {
                // Autenticación exitosa, determinar destino
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
                echo 'Credenciales incorrectas. Inténtalo de nuevo.';
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