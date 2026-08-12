<?php

session_start();

require_once 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registro.php');
    exit;
}

$idUsuario = trim(
    $_POST['idUsuario'] ?? ''
);

$nombre = trim(
    $_POST['nombre'] ?? ''
);

$apellidoPaterno = trim(
    $_POST['apellidoPaterno'] ?? ''
);

$apellidoMaterno = trim(
    $_POST['apellidoMaterno'] ?? ''
);

$edad = trim(
    $_POST['edad'] ?? ''
);

$sexo = trim(
    $_POST['sexo'] ?? ''
);

$email = trim(
    $_POST['email'] ?? ''
);

$telefono = trim(
    $_POST['telefono'] ?? ''
);

$password = $_POST['password'] ?? '';

$confirmarPassword =
    $_POST['confirmarPassword'] ?? '';


/*
|--------------------------------------------------------------------------
| Validación de campos vacíos
|--------------------------------------------------------------------------
*/

if (
    $idUsuario === '' ||
    $nombre === '' ||
    $apellidoPaterno === '' ||
    $apellidoMaterno === '' ||
    $edad === '' ||
    $sexo === '' ||
    $email === '' ||
    $telefono === '' ||
    $password === '' ||
    $confirmarPassword === ''
) {

    $_SESSION['error_registro'] =
        'Todos los campos son obligatorios.';

    header('Location: registro.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Validación del ID
|--------------------------------------------------------------------------
*/

if (strlen($idUsuario) > 20) {

    $_SESSION['error_registro'] =
        'El ID de usuario no puede superar los 20 caracteres.';

    header('Location: registro.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Validación de edad
|--------------------------------------------------------------------------
*/

if (
    filter_var(
        $edad,
        FILTER_VALIDATE_INT
    ) === false ||
    (int) $edad <= 0 ||
    (int) $edad > 120
) {

    $_SESSION['error_registro'] =
        'La edad proporcionada no es válida.';

    header('Location: registro.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Validación del correo electrónico
|--------------------------------------------------------------------------
*/

if (
    !filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )
) {

    $_SESSION['error_registro'] =
        'El correo electrónico no es válido.';

    header('Location: registro.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Validación de contraseña
|--------------------------------------------------------------------------
*/

if ($password !== $confirmarPassword) {

    $_SESSION['error_registro'] =
        'La contraseña y su confirmación no coinciden.';

    header('Location: registro.php');
    exit;
}


/*
| La contraseña debe:
|
| - Tener mínimo 8 caracteres
| - Tener al menos una letra
| - Tener al menos un número
| - Tener al menos un carácter:
|   # $ - _ & %
*/

$patronPassword =
    '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[#$\-_&%]).{8,}$/';

if (
    !preg_match(
        $patronPassword,
        $password
    )
) {

    $_SESSION['error_registro'] =
        'La contraseña debe tener mínimo 8 caracteres, '
        . 'incluir letras, números y al menos uno de '
        . 'estos caracteres especiales: #, $, -, _, &, %.';

    header('Location: registro.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Revisar si el IDUsuario ya existe
|--------------------------------------------------------------------------
*/

$sqlBuscar =
    'SELECT IDUsuario
     FROM USUARIOS
     WHERE IDUsuario = :idUsuario';

$stmtBuscar = $pdo->prepare(
    $sqlBuscar
);

$stmtBuscar->execute([
    ':idUsuario' => $idUsuario
]);

$usuarioExistente =
    $stmtBuscar->fetch();

if ($usuarioExistente) {

    $_SESSION['error_registro'] =
        'El ID de usuario ya se encuentra registrado.';

    header('Location: registro.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Registro del usuario
|--------------------------------------------------------------------------
|
| No recibimos TipoUsuario desde el formulario.
| PHP asigna CT automáticamente.
|
*/

$tipoUsuario = 'CT';

$sqlInsertar =
    'INSERT INTO USUARIOS (
        IDUsuario,
        Nombre,
        ApellidoPaterno,
        ApellidoMaterno,
        Edad,
        Sexo,
        Email,
        Telefono,
        TipoUsuario,
        Password
    )
    VALUES (
        :idUsuario,
        :nombre,
        :apellidoPaterno,
        :apellidoMaterno,
        :edad,
        :sexo,
        :email,
        :telefono,
        :tipoUsuario,
        :password
    )';

$stmtInsertar = $pdo->prepare(
    $sqlInsertar
);

try {

    $stmtInsertar->execute([
        ':idUsuario' => $idUsuario,
        ':nombre' => $nombre,
        ':apellidoPaterno' => $apellidoPaterno,
        ':apellidoMaterno' => $apellidoMaterno,
        ':edad' => (int) $edad,
        ':sexo' => $sexo,
        ':email' => $email,
        ':telefono' => $telefono,
        ':tipoUsuario' => $tipoUsuario,
        ':password' => $password
    ]);

    $_SESSION['registro_exitoso'] =
        'Usuario registrado correctamente. '
        . 'Ya puedes iniciar sesión.';

    header('Location: registro.php');
    exit;

} catch (PDOException $e) {

    $_SESSION['error_registro'] =
        'No fue posible realizar el registro.';

    header('Location: registro.php');
    exit;
}