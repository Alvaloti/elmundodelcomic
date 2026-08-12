<?php

session_start();

if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit;
}

require_once 'config/conexion.php';

$errores = [];
$registroExitoso = false;

$datos = [
    'IDUsuario' => '',
    'Nombre' => '',
    'ApellidoPaterno' => '',
    'ApellidoMaterno' => '',
    'Edad' => '',
    'Sexo' => '',
    'Email' => '',
    'Telefono' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos['IDUsuario'] = trim($_POST['IDUsuario'] ?? '');
    $datos['Nombre'] = trim($_POST['Nombre'] ?? '');
    $datos['ApellidoPaterno'] = trim($_POST['ApellidoPaterno'] ?? '');
    $datos['ApellidoMaterno'] = trim($_POST['ApellidoMaterno'] ?? '');
    $datos['Edad'] = trim($_POST['Edad'] ?? '');
    $datos['Sexo'] = trim($_POST['Sexo'] ?? '');
    $datos['Email'] = trim($_POST['Email'] ?? '');
    $datos['Telefono'] = trim($_POST['Telefono'] ?? '');

    $password = $_POST['Password'] ?? '';
    $confirmarPassword = $_POST['ConfirmarPassword'] ?? '';

    $nombresCampos = [
        'IDUsuario' => 'ID de usuario',
        'Nombre' => 'Nombre',
        'ApellidoPaterno' => 'Apellido paterno',
        'ApellidoMaterno' => 'Apellido materno',
        'Edad' => 'Edad',
        'Sexo' => 'Sexo',
        'Email' => 'Correo electrónico',
        'Telefono' => 'Teléfono'
    ];

    foreach ($datos as $campo => $valor) {
        if ($valor === '') {
            $errores[] = 'El campo ' . $nombresCampos[$campo] . ' es obligatorio.';
        }
    }

    if ($password === '') {
        $errores[] = 'La contraseña es obligatoria.';
    }

    if ($confirmarPassword === '') {
        $errores[] = 'La confirmación de contraseña es obligatoria.';
    }

    if (
        $datos['Edad'] !== '' &&
        (
            filter_var($datos['Edad'], FILTER_VALIDATE_INT) === false ||
            (int) $datos['Edad'] < 1 ||
            (int) $datos['Edad'] > 120
        )
    ) {
        $errores[] = 'La edad debe ser un número entero válido entre 1 y 120.';
    }

    $sexosPermitidos = ['Masculino', 'Femenino', 'Otro'];
    if ($datos['Sexo'] !== '' && !in_array($datos['Sexo'], $sexosPermitidos, true)) {
        $errores[] = 'El valor seleccionado para sexo no es válido.';
    }

    if (
        $datos['Email'] !== '' &&
        !filter_var($datos['Email'], FILTER_VALIDATE_EMAIL)
    ) {
        $errores[] = 'El correo electrónico no es válido.';
    }

    if (
        $password !== '' &&
        $confirmarPassword !== '' &&
        $password !== $confirmarPassword
    ) {
        $errores[] = 'Las contraseñas no coinciden.';
    }

    if ($password !== '') {
        $passwordValido =
            strlen($password) >= 8 &&
            preg_match('/[A-Za-z]/', $password) &&
            preg_match('/[0-9]/', $password) &&
            preg_match('/[#$\-_&%]/', $password);

        if (!$passwordValido) {
            $errores[] =
                'La contraseña debe tener mínimo 8 caracteres, incluir letras, números '
                . 'y al menos un carácter especial: #, $, -, _, & o %.';
        }
    }

    if ($datos['IDUsuario'] !== '') {
        $sql = 'SELECT IDUsuario FROM USUARIOS WHERE IDUsuario = :idUsuario';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idUsuario' => $datos['IDUsuario']
        ]);

        if ($stmt->fetch()) {
            $errores[] = 'El IDUsuario ya se encuentra registrado.';
        }
    }

    if (
        $datos['Email'] !== '' &&
        filter_var($datos['Email'], FILTER_VALIDATE_EMAIL)
    ) {
        $sql = 'SELECT IDUsuario FROM USUARIOS WHERE Email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $datos['Email']
        ]);

        if ($stmt->fetch()) {
            $errores[] = 'El correo electrónico ya está registrado.';
        }
    }

    if (empty($errores)) {
        $sql = 'INSERT INTO USUARIOS (
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

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':idUsuario' => $datos['IDUsuario'],
            ':nombre' => $datos['Nombre'],
            ':apellidoPaterno' => $datos['ApellidoPaterno'],
            ':apellidoMaterno' => $datos['ApellidoMaterno'],
            ':edad' => (int) $datos['Edad'],
            ':sexo' => $datos['Sexo'],
            ':email' => $datos['Email'],
            ':telefono' => $datos['Telefono'],
            ':tipoUsuario' => 'CT',
            ':password' => $password
        ]);

        $registroExitoso = true;

        $datos = [
            'IDUsuario' => '',
            'Nombre' => '',
            'ApellidoPaterno' => '',
            'ApellidoMaterno' => '',
            'Edad' => '',
            'Sexo' => '',
            'Email' => '',
            'Telefono' => ''
        ];
    }
}

require_once 'includes/header.php';
?>

<h1>Registro de cliente</h1>

<p>
    Complete los siguientes datos para crear una cuenta como cliente de la tienda.
    Todos los datos se validan en el servidor mediante PHP.
</p>

<?php if ($registroExitoso): ?>
    <div class="mensaje exito">
        Usuario registrado correctamente.
        <a href="login.php">Iniciar sesión</a>
    </div>
<?php endif; ?>

<?php if (!empty($errores)): ?>
    <div class="mensaje error">
        <strong>No fue posible realizar el registro:</strong>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="registro.php" method="post" class="formulario" novalidate>
    <div class="campo">
        <label for="IDUsuario">ID de usuario:</label>
        <input
            type="text"
            id="IDUsuario"
            name="IDUsuario"
            value="<?php echo htmlspecialchars($datos['IDUsuario'], ENT_QUOTES, 'UTF-8'); ?>"
        >
    </div>

    <div class="campo">
        <label for="Nombre">Nombre:</label>
        <input
            type="text"
            id="Nombre"
            name="Nombre"
            value="<?php echo htmlspecialchars($datos['Nombre'], ENT_QUOTES, 'UTF-8'); ?>"
        >
    </div>

    <div class="campo">
        <label for="ApellidoPaterno">Apellido paterno:</label>
        <input
            type="text"
            id="ApellidoPaterno"
            name="ApellidoPaterno"
            value="<?php echo htmlspecialchars($datos['ApellidoPaterno'], ENT_QUOTES, 'UTF-8'); ?>"
        >
    </div>

    <div class="campo">
        <label for="ApellidoMaterno">Apellido materno:</label>
        <input
            type="text"
            id="ApellidoMaterno"
            name="ApellidoMaterno"
            value="<?php echo htmlspecialchars($datos['ApellidoMaterno'], ENT_QUOTES, 'UTF-8'); ?>"
        >
    </div>

    <div class="campo">
        <label for="Edad">Edad:</label>
        <input
            type="number"
            id="Edad"
            name="Edad"
            value="<?php echo htmlspecialchars($datos['Edad'], ENT_QUOTES, 'UTF-8'); ?>"
        >
    </div>

    <div class="campo">
        <label for="Sexo">Sexo:</label>
        <select id="Sexo" name="Sexo">
            <option value="">Seleccione</option>
            <option value="Masculino" <?php echo $datos['Sexo'] === 'Masculino' ? 'selected' : ''; ?>>
                Masculino
            </option>
            <option value="Femenino" <?php echo $datos['Sexo'] === 'Femenino' ? 'selected' : ''; ?>>
                Femenino
            </option>
            <option value="Otro" <?php echo $datos['Sexo'] === 'Otro' ? 'selected' : ''; ?>>
                Otro
            </option>
        </select>
    </div>

    <div class="campo">
        <label for="Email">Correo electrónico:</label>
        <input
            type="email"
            id="Email"
            name="Email"
            value="<?php echo htmlspecialchars($datos['Email'], ENT_QUOTES, 'UTF-8'); ?>"
        >
    </div>

    <div class="campo">
        <label for="Telefono">Teléfono:</label>
        <input
            type="text"
            id="Telefono"
            name="Telefono"
            value="<?php echo htmlspecialchars($datos['Telefono'], ENT_QUOTES, 'UTF-8'); ?>"
        >
    </div>

    <div class="campo">
        <label for="Password">Contraseña:</label>
        <input type="password" id="Password" name="Password">
        <small>
            Mínimo 8 caracteres, con letras, números y uno de estos caracteres:
            #, $, -, _, & o %.
        </small>
    </div>

    <div class="campo">
        <label for="ConfirmarPassword">Confirmar contraseña:</label>
        <input type="password" id="ConfirmarPassword" name="ConfirmarPassword">
    </div>

    <button type="submit">Registrarse</button>
</form>

<?php
require_once 'includes/footer.php';
?>
