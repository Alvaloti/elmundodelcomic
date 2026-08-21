<?php

$productosCarrusel = [

    [
        'imagen' => '/public/img/comics.jpg',
        'titulo' => 'Cómics y revistas',
        'descripcion' =>
            'Descubre historias, personajes y nuevas aventuras '
            . 'en nuestra selección de cómics y revistas.'
    ],

    [
        'imagen' => 'public/img/albumes.jpg',
        'titulo' => 'Álbumes coleccionables',
        'descripcion' =>
            'Encuentra álbumes y colecciones especiales '
            . 'para completar tus series favoritas.'
    ],

    [
        'imagen' => 'public/img/figuras.jpg',
        'titulo' => 'Figuras de acción',
        'descripcion' =>
            'Conoce nuestra selección de figuras de acción '
            . 'y personajes para coleccionistas.'
    ],

    [
        'imagen' => 'public/img/animacion.jpg',
        'titulo' => 'Series animadas',
        'descripcion' =>
            'Productos inspirados en series animadas '
            . 'para seguidores y coleccionistas.'
    ],

    [
        'imagen' => 'public/img/peliculas.jpg',
        'titulo' => 'Cine y películas',
        'descripcion' =>
            'Artículos relacionados con películas, '
            . 'personajes y producciones cinematográficas.'
    ]

];

require_once 'includes/header.php';

?>


<!-- CARRUSEL -->

<section>

<div
    id="carruselTienda"
    class="carousel slide"
    data-bs-ride="carousel"
>

    <div class="carousel-indicators">

        <?php foreach (
            $productosCarrusel as $indice => $producto
        ): ?>

            <button
                type="button"
                data-bs-target="#carruselTienda"
                data-bs-slide-to="<?php echo $indice; ?>"
                class="<?php
                    echo $indice === 0
                        ? 'active'
                        : '';
                ?>"
            >
            </button>

        <?php endforeach; ?>

    </div>


    <div class="carousel-inner">

        <?php foreach (
            $productosCarrusel as $indice => $producto
        ): ?>

            <div
                class="
                    carousel-item
                    <?php
                    echo $indice === 0
                        ? 'active'
                        : '';
                    ?>
                "
            >

                <img
                    src="<?php
                    echo htmlspecialchars(
                        $producto['imagen'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>"
                    class="
                        d-block
                        w-100
                        imagen-carrusel
                    "
                    alt="<?php
                    echo htmlspecialchars(
                        $producto['titulo'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>"
                    data-bs-toggle="modal"
                    data-bs-target="#modal<?php
                    echo $indice;
                    ?>"
                >

                <div
                    class="
                        carousel-caption
                        d-none
                        d-md-block
                        fondo-caption
                    "
                >

                    <h2>
                        <?php
                        echo htmlspecialchars(
                            $producto['titulo'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </h2>

                    <p>
                        <?php
                        echo htmlspecialchars(
                            $producto['descripcion'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </p>

                </div>

            </div>

        <?php endforeach; ?>

    </div>


    <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carruselTienda"
        data-bs-slide="prev"
    >

        <span
            class="carousel-control-prev-icon"
        ></span>

        <span class="visually-hidden">
            Anterior
        </span>

    </button>


    <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carruselTienda"
        data-bs-slide="next"
    >

        <span
            class="carousel-control-next-icon"
        ></span>

        <span class="visually-hidden">
            Siguiente
        </span>

    </button>

</div>

</section>


<!-- PRESENTACIÓN -->

<section class="container py-5 text-center">

    <h1 class="display-5 fw-bold">
        El Mundo del Cómic
    </h1>

    <?php if (isset($_SESSION['nombre'])): ?>

        <div
            class="
                alert
                alert-success
                mt-4
            "
        >

            ¡Bienvenido

            <?php
            echo htmlspecialchars(
                $_SESSION['nombre'],
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

            <?php
            echo htmlspecialchars(
                $_SESSION['apellido_paterno'],
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

            <?php
            echo htmlspecialchars(
                $_SESSION['apellido_materno'],
                ENT_QUOTES,
                'UTF-8'
            );
            ?>!

            Has ingresado como

            <strong>
                <?php
                echo htmlspecialchars(
                    $_SESSION['tipo_usuario'],
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>
            </strong>.

        </div>

    <?php endif; ?>


    <p class="lead mt-4">

        Bienvenido a El Mundo del Cómic,
        un espacio dedicado a los aficionados
        de las historietas, series animadas,
        películas y artículos de colección.

    </p>

</section>


<!-- TARJETAS -->

<section class="container pb-5">

    <div class="text-center mb-5">

        <h2>
            Explora nuestras categorías
        </h2>

        <p class="text-muted">

            Descubre productos para ampliar
            tu colección.

        </p>

    </div>


    <div class="row g-4">

        <div class="col-12 col-md-6 col-lg-4">

            <div class="card h-100 shadow-sm">

                <img
                    src="public/img/comic.jpg"
                    class="card-img-top imagen-tarjeta"
                    alt="Cómics y revistas"
                >

                <div class="card-body d-flex flex-column">

                    <h3 class="card-title h5">
                        Cómics y revistas
                    </h3>

                    <p class="card-text">

                        Historias, personajes
                        y publicaciones para
                        lectores y coleccionistas.

                    </p>

                    <a
                        href="#"
                        class="btn btn-primary mt-auto"
                    >
                        Ver categoría
                    </a>

                </div>

            </div>

        </div>


        <div class="col-12 col-md-6 col-lg-4">

            <div class="card h-100 shadow-sm">

                <img
                    src="img/albumes.jpg"
                    class="card-img-top imagen-tarjeta"
                    alt="Álbumes coleccionables"
                >

                <div class="card-body d-flex flex-column">

                    <h3 class="card-title h5">
                        Álbumes coleccionables
                    </h3>

                    <p class="card-text">

                        Álbumes, estampas y
                        colecciones especiales
                        para completar.

                    </p>

                    <a
                        href="#"
                        class="btn btn-primary mt-auto"
                    >
                        Ver álbumes
                    </a>

                </div>

            </div>

        </div>


        <div class="col-12 col-md-6 col-lg-4">

            <div class="card h-100 shadow-sm">

                <img
                    src="img/figuras.jpg"
                    class="card-img-top imagen-tarjeta"
                    alt="Figuras y artículos de colección"
                >

                <div class="card-body d-flex flex-column">

                    <h3 class="card-title h5">
                        Figuras y artículos de colección
                    </h3>

                    <p class="card-text">

                        Figuras, personajes y
                        artículos inspirados en
                        series y películas.

                    </p>

                    <a
                        href="#"
                        class="btn btn-primary mt-auto"
                    >
                        Ver coleccionables
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- MODALES -->

<?php foreach (
    $productosCarrusel as $indice => $producto
): ?>

<div
    class="modal fade"
    id="modal<?php echo $indice; ?>"
    tabindex="-1"
    aria-hidden="true"
>

    <div
        class="
            modal-dialog
            modal-dialog-centered
            modal-lg
        "
    >

        <div class="modal-content">

            <div class="modal-header">

                <h2 class="modal-title fs-5">

                    <?php
                    echo htmlspecialchars(
                        $producto['titulo'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>

                </h2>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                >
                </button>

            </div>


            <div class="modal-body text-center">

                <img
                    src="<?php
                    echo htmlspecialchars(
                        $producto['imagen'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>"
                    class="img-fluid rounded mb-3"
                    alt="<?php
                    echo htmlspecialchars(
                        $producto['titulo'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>"
                >

                <p>
                    <?php
                    echo htmlspecialchars(
                        $producto['descripcion'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </p>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cerrar
                </button>

            </div>

        </div>

    </div>

</div>

<?php endforeach; ?>


<?php

require_once 'includes/footer.php';

?>