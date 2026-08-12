<?php

session_start();

if (
    !isset($_SESSION['id_usuario']) ||
    $_SESSION['tipo_usuario'] !== 'PT'
) {
    header('Location: index.php');
    exit;
}

require_once 'includes/header.php';
?>

<h1>Administrar pedidos</h1>

<p>
    Módulo exclusivo para personal de la tienda (PT).
</p>

<?php
require_once 'includes/footer.php';
?>
