<?php

session_start();

if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit;
}

require_once 'config/conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = trim($_POST['IDUsuario'] ?? '');
    $password = $_POST['Password'] ?? '';

    if ($idUsuario === '' || $password === '') {
        $error = 'Debe ingresar el IDUsuario y la contraseña.';
    } else {
        $sql = 'SELECT
                    IDUsuario,
                    Nombre,
                    ApellidoPaterno,
                    ApellidoMaterno,
                    TipoUsuario,
                    Password
                FROM USUARIOS
                WHERE IDUsuario = :idUsuario';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idUsuario' => $idUsuario
        ]);

        $usuario = $stmt->fetch();

        if (!$usuario) {
            $error = 'Usuario no registrado';
        } elseif ($password !== $usuario['Password']) {
            $error = 'Credenciales incorrectas';
        } else {
            session_regenerate_id(true);

            $_SESSION['id_usuario'] = $usuario['IDUsuario'];
            $_SESSION['nombre'] = $usuario['Nombre'];
            $_SESSION['apellido_paterno'] = $usuario['ApellidoPaterno'];
            $_SESSION['apellido_materno'] = $usuario['ApellidoMaterno'];
            $_SESSION['tipo_usuario'] = $usuario['TipoUsuario'];

            header('Location: index.php');
            exit;
        }
    }
}

require_once 'includes/header.php';
?>

<h1>Iniciar sesión</h1>

<?php if ($error !== ''): ?>
    <div class="mensaje error">
        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; ?>

<form action="login.php" method="post" class="formulario" novalidate>
    <div class="campo">
        <label for="IDUsuario">ID de usuario:</label>
        <input type="text" id="IDUsuario" name="IDUsuario">
    </div>

    <div class="campo">
        <label for="Password">Contraseña:</label>
        <input type="password" id="Password" name="Password">
    </div>

    <button type="submit">Iniciar sesión</button>
</form>

<?php
require_once 'includes/footer.php';
?>
