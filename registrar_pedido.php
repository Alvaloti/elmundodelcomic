<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}
if (!in_array($_SESSION['tipo_usuario'] ?? '', ['CT', 'PT'], true)) {
    header('Location: index.php');
    exit;
}
require_once 'config/conexion.php';
$errores = [];
$exito = '';
$d = ['IDProducto' => '', 'IDUsuario' => $_SESSION['tipo_usuario'] === 'CT' ? $_SESSION['id_usuario'] : '', 'NombreProducto' => '', 'Marca' => '', 'UnidadMedida' => '', 'Precio' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['IDProducto', 'NombreProducto', 'Marca', 'UnidadMedida', 'Precio'] as $c) {
        $d[$c] = trim($_POST[$c] ?? '');
    }
    $d['IDUsuario'] = $_SESSION['tipo_usuario'] === 'CT' ? $_SESSION['id_usuario'] : trim($_POST['IDUsuario'] ?? '');
    foreach ($d as $c => $v) {
        if ($v === '') $errores[] = "El campo $c es obligatorio.";
    }
    if ($d['Precio'] !== '' && (!is_numeric($d['Precio']) || (float)$d['Precio'] < 0)) $errores[] = 'El precio debe ser un número válido.';
    if ($d['IDProducto'] !== '') {
        $s = $pdo->prepare('SELECT IDProducto FROM PEDIDOS WHERE IDProducto=:id');
        $s->execute([':id' => $d['IDProducto']]);
        if ($s->fetch()) $errores[] = 'El ID de producto ya está registrado.';
    }
    if ($d['IDUsuario'] !== '') {
        $s = $pdo->prepare('SELECT IDUsuario FROM USUARIOS WHERE IDUsuario=:id AND TipoUsuario=\'CT\'');
        $s->execute([':id' => $d['IDUsuario']]);
        if (!$s->fetch()) $errores[] = 'El cliente indicado no existe.';
    }
    if (!$errores) {
        $s = $pdo->prepare('INSERT INTO PEDIDOS(IDProducto,IDUsuario,NombreProducto,Marca,UnidadMedida,Precio) VALUES(:ip,:iu,:np,:m,:u,:p)');
        $s->execute([':ip' => $d['IDProducto'], ':iu' => $d['IDUsuario'], ':np' => $d['NombreProducto'], ':m' => $d['Marca'], ':u' => $d['UnidadMedida'], ':p' => $d['Precio']]);
        $exito = 'Pedido registrado correctamente.';
        $d = ['IDProducto' => '', 'IDUsuario' => $_SESSION['tipo_usuario'] === 'CT' ? $_SESSION['id_usuario'] : '', 'NombreProducto' => '', 'Marca' => '', 'UnidadMedida' => '', 'Precio' => ''];
    }
}
require_once 'includes/header.php'; ?>
<h1>Registrar pedido</h1>
<?php if ($exito): ?>
    <div class="mensaje exito">
        <?php echo $exito; ?>
    </div><?php endif; ?><?php if ($errores): ?>
    <div class="mensaje error">
        <ul><?php foreach ($errores as $e): ?>
                <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?>
                </li><?php endforeach; ?>
        </ul>
    </div><?php endif; ?>
<form method="post" class="formulario" novalidate>
    <div class="campo">
        <label for="IDProducto">ID de producto:</label>
        <input type="text" id="IDProducto" name="IDProducto" value="
        <?php echo htmlspecialchars($d['IDProducto'], ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <?php if ($_SESSION['tipo_usuario'] === 'PT'): ?>
        <div class="campo">
            <label for="IDUsuario">IDUsuario del cliente:</label>
            <input type="text" id="IDUsuario" name="IDUsuario" value="<?php echo htmlspecialchars($d['IDUsuario'], ENT_QUOTES, 'UTF-8'); ?>">
        </div><?php else: ?>
        <div class="mensaje info">El pedido se registrará para el cliente
            <strong>
                <?php echo htmlspecialchars($_SESSION['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>
            </strong>.
        </div>
    <?php endif; ?>
    <?php foreach (['NombreProducto' => 'Nombre del producto', 'Marca' => 'Marca', 'UnidadMedida' => 'Unidad de medida', 'Precio' => 'Precio'] as $c => $l): ?>
        <div class="campo">
            <label for="<?php echo $c; ?>"><?php echo $l; ?>:</label>
            <input type="<?php echo $c === 'Precio' ? 'number' : 'text'; ?>" <?php echo $c === 'Precio' ? 'step="0.01" min="0"' : ''; ?> id="<?php echo $c; ?>" name="<?php echo $c; ?>" value="<?php echo htmlspecialchars($d[$c], ENT_QUOTES, 'UTF-8'); ?>">
        </div><?php endforeach; ?>
    <button type="submit">Registrar pedido</button>
</form>
<?php require_once 'includes/footer.php'; ?>