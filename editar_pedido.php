<?php
session_start();
if (!isset($_SESSION['id_usuario']) || ($_SESSION['tipo_usuario'] ?? '') !== 'PT') {
    header('Location:index.php');
    exit;
}
require_once 'config/conexion.php';
$id = trim($_GET['IDProducto'] ?? ($_POST['IDProductoOriginal'] ?? ''));
$errores = [];
if ($id === '') {
    header('Location:administrar_pedidos.php');
    exit;
}
$s = $pdo->prepare('SELECT IDProducto,IDUsuario,NombreProducto,Marca,UnidadMedida,Precio FROM PEDIDOS WHERE IDProducto=:id');
$s->execute([':id' => $id]);
$p = $s->fetch();
if (!$p) {
    header('Location:administrar_pedidos.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iu = trim($_POST['IDUsuario'] ?? '');
    $np = trim($_POST['NombreProducto'] ?? '');
    $m = trim($_POST['Marca'] ?? '');
    $u = trim($_POST['UnidadMedida'] ?? '');
    $pr = trim($_POST['Precio'] ?? '');
    if ($iu === '' || $np === '' || $m === '' || $u === '' || $pr === '') $errores[] = 'Todos los campos son obligatorios.';
    if ($pr !== '' && (!is_numeric($pr) || (float)$pr < 0)) $errores[] = 'El precio debe ser válido.';
    if ($iu !== '') {
        $s = $pdo->prepare('SELECT IDUsuario FROM USUARIOS WHERE IDUsuario=:id AND TipoUsuario=\'CT\'');
        $s->execute([':id' => $iu]);
        if (!$s->fetch()) $errores[] = 'El cliente indicado no existe.';
    }
    if (!$errores) {
        $s = $pdo->prepare('UPDATE PEDIDOS SET IDUsuario=:iu,NombreProducto=:np,Marca=:m,UnidadMedida=:u,Precio=:p WHERE IDProducto=:id');
        $s->execute([':iu' => $iu, ':np' => $np, ':m' => $m, ':u' => $u, ':p' => $pr, ':id' => $id]);
        header('Location:administrar_pedidos.php?IDUsuario=' . urlencode($iu));
        exit;
    }
    $p['IDUsuario'] = $iu;
    $p['NombreProducto'] = $np;
    $p['Marca'] = $m;
    $p['UnidadMedida'] = $u;
    $p['Precio'] = $pr;
}
require_once 'includes/header.php'; ?>
<h1>Editar pedido</h1>
<?php if ($errores): ?>
    <div class="mensaje error">
        <ul><?php foreach ($errores as $e): ?>
                <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?>
                </li><?php endforeach; ?>
        </ul>
    </div><?php endif; ?>
<form method="post" class="formulario" novalidate>
    <input type="hidden" name="IDProductoOriginal" value="<?php echo htmlspecialchars($p['IDProducto'], ENT_QUOTES, 'UTF-8'); ?>">
    <div class="campo">
        <label>ID de producto:</label>
        <input type="text" value="<?php echo htmlspecialchars($p['IDProducto'], ENT_QUOTES, 'UTF-8'); ?>" disabled>
    </div>
    <?php foreach (['IDUsuario' => 'IDUsuario del cliente', 'NombreProducto' => 'Nombre del producto', 'Marca' => 'Marca', 'UnidadMedida' => 'Unidad de medida', 'Precio' => 'Precio'] as $c => $l): ?>
        <div class="campo">
            <label for="<?php echo $c; ?>"><?php echo $l; ?>:</label>
            <input type="<?php echo $c === 'Precio' ? 'number' : 'text'; ?>" <?php echo $c === 'Precio' ? 'step="0.01" min="0"' : ''; ?> id="<?php echo $c; ?>" name="<?php echo $c; ?>" value="<?php echo htmlspecialchars($p[$c], ENT_QUOTES, 'UTF-8'); ?>">
        </div><?php endforeach; ?>
    <button type="submit">Guardar cambios</button>
</form>
<?php require_once 'includes/footer.php'; ?>