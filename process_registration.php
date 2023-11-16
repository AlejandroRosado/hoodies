<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Aquí deberías validar los datos del formulario y registrar al usuario en tu base de datos.
    // Por simplicidad, aquí solo comprobamos si las contraseñas coinciden.
    if ($password === $confirm_password) {
        echo 'Registro exitoso. Ahora puedes iniciar sesión.';
    } else {
        echo 'Las contraseñas no coinciden. Inténtalo de nuevo.';
    }
}
?>