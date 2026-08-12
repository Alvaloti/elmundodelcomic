<?php

session_start();

if (
    !isset($_SESSION['id_usuario']) ||
    $_SESSION['tipo_usuario'] !== 'CT'
) {
    header('Location: index.php');
    exit;
}

require_once 'includes/header.php';
?>

<h1>Consultar pedidos</h1>

<p>
    Módulo exclusivo para clientes de la tienda (CT).
</p>

<?php
require_once 'includes/footer.php';
?>
