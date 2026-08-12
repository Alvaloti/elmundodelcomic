<nav class="navbar">

    <div class="navbar-contenido">

        <a
            href="index.php"
            class="logo"
        >
            El Mundo del Cómic
        </a>

        <div class="menu">

            <?php if (!isset($_SESSION['id_usuario'])): ?>

                <a href="index.php">
                    Inicio
                </a>

                <a href="registro.php">
                    Registrarse
                </a>

                <a href="login.php">
                    Iniciar sesión
                </a>

            <?php elseif ($_SESSION['tipo_usuario'] === 'CT'): ?>

                <a href="index.php">
                    Inicio
                </a>

                <a href="cliente.php">
                    Área del cliente
                </a>

                <a href="salir.php">
                    Salir
                </a>

            <?php elseif ($_SESSION['tipo_usuario'] === 'PT'): ?>

                <a href="index.php">
                    Inicio
                </a>

                <a href="personal.php">
                    Área del personal
                </a>

                <a href="salir.php">
                    Salir
                </a>

            <?php endif; ?>

        </div>

    </div>

</nav>