<?php

require_once 'includes/header.php';
?>

<section class="inicio">
    <h1>El Mundo del Cómic</h1>

    <?php if (isset($_SESSION['nombre'])): ?>
        <div class="mensaje exito">
            ¡Bienvenido
            <?php echo htmlspecialchars($_SESSION['nombre'], ENT_QUOTES, 'UTF-8'); ?>
            <?php echo htmlspecialchars($_SESSION['apellido_paterno'], ENT_QUOTES, 'UTF-8'); ?>
            <?php echo htmlspecialchars($_SESSION['apellido_materno'], ENT_QUOTES, 'UTF-8'); ?>
            ¡Has ingresado como
            <?php echo htmlspecialchars($_SESSION['tipo_usuario'], ENT_QUOTES, 'UTF-8'); ?>!
        </div>
    <?php endif; ?>

    <div role="img" aria-label="Espacio reservado para una imagen alusiva a una tienda de cómics">
        <img src="/public/img/comic.jpg" class="imagen-principal">
    </div>
    <p> Imagen de libre uso (pixabay)</p>

    <p class="descripcion">
        Bienvenido a El Mundo del Cómic, una tienda dedicada a los aficionados de las
        historietas, series animadas y películas. Aquí podrás encontrar revistas de cómics,
        álbumes y diversos artículos de colección para ampliar tu universo favorito.
    </p>
</section>

<?php
require_once 'includes/footer.php';
?>
