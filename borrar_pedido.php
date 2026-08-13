<?php
session_start();
if (!isset($_SESSION['id_usuario']) || ($_SESSION['tipo_usuario'] ?? '') !== 'PT') {
    header('Location:index.php');
    exit;
}
require_once 'config/conexion.php';
$id = trim($_GET['IDProducto'] ?? ($_POST['IDProducto'] ?? ''));
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
    if (($_POST['confirmar'] ?? '') === 'si') {
        $s = $pdo->prepare('DELETE FROM PEDIDOS WHERE IDProducto=:id');
        $s->execute([':id' => $id]);
    }
    header('Location:administrar_pedidos.php?IDUsuario=' . urlencode($p['IDUsuario']));
    exit;
}
require_once 'includes/header.php'; ?>
<h1>Borrar pedido</h1>
<div class="mensaje advertencia">
    <p>¿Desea eliminar el pedido <strong><?php echo htmlspecialchars($p['IDProducto'], ENT_QUOTES, 'UTF-8'); ?>
        </strong> correspondiente a <strong>
            <?php echo htmlspecialchars($p['NombreProducto'], ENT_QUOTES, 'UTF-8'); ?>
        </strong>?
    </p>
    <p>Esta acción eliminará el registro de la tabla PEDIDOS.</p>
</div>
<form method="post" class="acciones">
    <input type="hidden" name="IDProducto" value="<?php echo htmlspecialchars($p['IDProducto'], ENT_QUOTES, 'UTF-8'); ?>">
    <button type="submit" name="confirmar" value="si">Sí, borrar</button>
    <button type="submit" name="confirmar" value="no">Cancelar</button>
</form>
<?php require_once 'includes/footer.php'; ?>