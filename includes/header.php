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

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Estilos propios -->
    <link
        rel="stylesheet"
        href="css/estilos.css"
    >
</head>

<body>

<header>

<nav
    class="
        navbar
        navbar-expand-md
        navbar-dark
        bg-dark
        fixed-top
        shadow
    "
>

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="index.php"
        >
            El Mundo del Cómic
        </a>

        <!-- Botón hamburguesa -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuPrincipal"
            aria-controls="menuPrincipal"
            aria-expanded="false"
            aria-label="Mostrar navegación"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú colapsable -->
        <div
            class="collapse navbar-collapse"
            id="menuPrincipal"
        >

            <ul class="navbar-nav ms-auto">

                <?php if ($tipoUsuario === 'PT'): ?>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="index.php"
                        >
                            Inicio
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="registrar_pedido.php"
                        >
                            Registrar pedido
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="administrar_pedidos.php"
                        >
                            Administrar pedidos
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="salir.php"
                        >
                            Salir
                        </a>

                    </li>


                <?php elseif ($tipoUsuario === 'CT'): ?>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="index.php"
                        >
                            Inicio
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="registrar_pedido.php"
                        >
                            Registrar pedido
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="consultar_pedidos.php"
                        >
                            Consultar pedidos
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="salir.php"
                        >
                            Salir
                        </a>

                    </li>


                <?php else: ?>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="index.php"
                        >
                            Inicio
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="registro.php"
                        >
                            Registrarse
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="login.php"
                        >
                            Iniciar sesión
                        </a>

                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>

</header>

<main>