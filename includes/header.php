<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$tipoUsuario = $_SESSION['tipo_usuario'] ?? null;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>El Mundo del Cómic</title>

    <link
        rel="stylesheet"
        href="css/estilos.css"
    >
</head>

<body>

<header>

    <nav class="navbar">

        <div class="marca">
            El Mundo del Cómic
        </div>

        <ul>

            <?php if ($tipoUsuario === 'PT'): ?>

                <li>
                    <a href="index.php">
                        Inicio
                    </a>
                </li>

                <li>
                    <a href="registrar_pedido.php">
                        Registrar pedido
                    </a>
                </li>

                <li>
                    <a href="administrar_pedidos.php">
                        Administrar pedidos
                    </a>
                </li>

                <li>
                    <a href="salir.php">
                        Salir
                    </a>
                </li>

            <?php elseif ($tipoUsuario === 'CT'): ?>

                <li>
                    <a href="index.php">
                        Inicio
                    </a>
                </li>

                <li>
                    <a href="registrar_pedido.php">
                        Registrar pedido
                    </a>
                </li>

                <li>
                    <a href="consultar_pedidos.php">
                        Consultar pedidos
                    </a>
                </li>

                <li>
                    <a href="salir.php">
                        Salir
                    </a>
                </li>

            <?php else: ?>

                <li>
                    <a href="index.php">
                        Inicio
                    </a>
                </li>

                <li>
                    <a href="registro.php">
                        Registrarse
                    </a>
                </li>

                <li>
                    <a href="login.php">
                        Iniciar sesión
                    </a>
                </li>

            <?php endif; ?>

        </ul>

    </nav>

</header>

<main class="contenedor">