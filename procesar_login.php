<?php

session_start();

require_once 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$idUsuario = trim(
    $_POST['idUsuario'] ?? ''
);

$password =
    $_POST['password'] ?? '';


/*
|--------------------------------------------------------------------------
| Validar campos vacíos
|--------------------------------------------------------------------------
*/

if (
    $idUsuario === '' ||
    $password === ''
) {

    $_SESSION['error_login'] =
        'Debes proporcionar tu ID de usuario y contraseña.';

    header('Location: login.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Buscar usuario mediante sentencia preparada
|--------------------------------------------------------------------------
*/

$sql =
    'SELECT
        IDUsuario,
        Nombre,
        ApellidoPaterno,
        ApellidoMaterno,
        TipoUsuario,
        Password
    FROM USUARIOS
    WHERE IDUsuario = :idUsuario';

$stmt = $pdo->prepare(
    $sql
);

$stmt->execute([
    ':idUsuario' => $idUsuario
]);

$usuario = $stmt->fetch();


/*
|--------------------------------------------------------------------------
| Usuario no registrado
|--------------------------------------------------------------------------
*/

if (!$usuario) {

    $_SESSION['error_login'] =
        'Usuario no registrado';

    header('Location: login.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Validación de contraseña
|--------------------------------------------------------------------------
*/

if ($password !== $usuario['Password']) {

    $_SESSION['error_login'] =
        'Contraseña incorrecta';

    header('Location: login.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Crear sesión
|--------------------------------------------------------------------------
*/

session_regenerate_id(true);

$_SESSION['id_usuario'] =
    $usuario['IDUsuario'];

$_SESSION['nombre'] =
    $usuario['Nombre'];

$_SESSION['apellido_paterno'] =
    $usuario['ApellidoPaterno'];

$_SESSION['apellido_materno'] =
    $usuario['ApellidoMaterno'];

$_SESSION['tipo_usuario'] =
    $usuario['TipoUsuario'];


/*
|--------------------------------------------------------------------------
| Redirección según el tipo de usuario
|--------------------------------------------------------------------------
*/

if ($usuario['TipoUsuario'] === 'CT') {

    header('Location: cliente.php');
    exit;
}

if ($usuario['TipoUsuario'] === 'PT') {

    header('Location: personal.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Tipo de usuario no válido
|--------------------------------------------------------------------------
*/

$_SESSION = [];

session_destroy();

header('Location: login.php');
exit;