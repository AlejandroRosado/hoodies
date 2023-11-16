<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <style>
        /* Apply styles to the entire body */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    text-align: center;
}

/* Style the registration form */
form {
    width: 300px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

/* Style form labels */
label {
    display: block;
    text-align: left;
    margin: 10px 0;
}

/* Style form input fields */
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 3px;
}

/* Style the submit button */
input[type="submit"] {
    background-color: #0074D9;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056a2;
}
    </style>
</head>
<body>
    <h1>Iniciar Sesión</h1>

    <form action="process_login.php" method="POST">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <h2>Todavia no te has registrado?Pincha aquí.</h2>
    <form action="register.php">
        <input type="submit" value= "Ristrarse">
    </form>
</body>
</html>