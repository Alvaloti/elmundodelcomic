<?php

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

require_once 'includes/encabezado.php';
?>

<h1>Registrar pedido</h1>

<p>
    Este módulo se encuentra reservado para la siguiente etapa del caso de estudio.
</p>

<?php
require_once 'includes/footer.php';
?>
