<?php

session_start();

if (
    !isset($_SESSION['id_usuario']) ||
    $_SESSION['tipo_usuario'] !== 'PT'
) {
    header('Location: login.php');
    exit;
}

require_once 'includes/header.php';

?>

<section class="panel">

    <h1>
        Área del personal
    </h1>

    <div class="mensaje exito">

        <?php

        echo '¡Bienvenido '
            . htmlspecialchars(
                $_SESSION['nombre']
            )
            . ' '
            . htmlspecialchars(
                $_SESSION['apellido_paterno']
            )
            . ' '
            . htmlspecialchars(
                $_SESSION['apellido_materno']
            )
            . '! Has ingresado como '
            . htmlspecialchars(
                $_SESSION['tipo_usuario']
            )
            . '!';

        ?>

    </div>

    <p>
        Desde esta sección podrás acceder
        a las operaciones disponibles para
        el personal de El Mundo del Cómic.
    </p>

</section>

<?php

require_once 'includes/footer.php';

?>