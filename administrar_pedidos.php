<?php
session_start();
if (!isset($_SESSION['id_usuario']) || ($_SESSION['tipo_usuario'] ?? '') !== 'PT') {
    header('Location:index.php');
    exit;
}
require_once 'config/conexion.php';
$id = trim($_GET['IDUsuario'] ?? '');
$cliente = null;
$pedidos = [];
$mensaje = '';
if ($id !== '') {
    $s = $pdo->prepare('SELECT IDUsuario,Nombre,ApellidoPaterno,ApellidoMaterno FROM USUARIOS WHERE IDUsuario=:id AND TipoUsuario=\'CT\'');
    $s->execute([':id' => $id]);
    $cliente = $s->fetch();
    if (!$cliente) {
        $mensaje = 'Cliente no encontrado.';
    } else {
        $s = $pdo->prepare('SELECT IDProducto,NombreProducto,Marca,UnidadMedida,Precio FROM PEDIDOS WHERE IDUsuario=:id ORDER BY IDProducto');
        $s->execute([':id' => $id]);
        $pedidos = $s->fetchAll();
    }
}
require_once 'includes/header.php'; ?>
<section class="pagina-pedidos-fondo">
    <div class="panel">
        <h1>Administrar pedidos</h1>
        <form method="get" class="consulta-inline"><label for="IDUsuario">Proporcione el IDUsuario del cliente a consultar:</label><input type="text" id="IDUsuario" name="IDUsuario" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>"><button type="submit">Consultar</button></form>
        <?php if ($mensaje): ?><div class="mensaje error"><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
        <?php if ($cliente): ?><p><strong>Cliente:</strong> <?php echo htmlspecialchars($cliente['IDUsuario'], ENT_QUOTES, 'UTF-8'); ?> <strong>Nombre:</strong> <?php echo htmlspecialchars($cliente['Nombre'] . ' ' . $cliente['ApellidoPaterno'] . ' ' . $cliente['ApellidoMaterno'], ENT_QUOTES, 'UTF-8'); ?></p>
            <h2>Pedidos registrados</h2>
            <?php if ($pedidos): ?><div class="tabla-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID de producto</th>
                                <th>Nombre del producto</th>
                                <th>Marca</th>
                                <th>Unidad de medida</th>
                                <th>Precio</th>
                                <th>Editar</th>
                                <th>Borrar</th>
                            </tr>
                        </thead>
                        <tbody><?php foreach ($pedidos as $p): ?><tr>
                                    <td><?php echo htmlspecialchars($p['IDProducto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($p['NombreProducto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($p['Marca'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($p['UnidadMedida'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>$<?php echo number_format((float)$p['Precio'], 2); ?></td>
                                    <td><a href="editar_pedido.php?IDProducto=<?php echo urlencode($p['IDProducto']); ?>">Editar</a></td>
                                    <td><a href="borrar_pedido.php?IDProducto=<?php echo urlencode($p['IDProducto']); ?>">Borrar</a></td>
                                </tr><?php endforeach; ?></tbody>
                    </table>
                </div><?php else: ?><div class="mensaje info">El cliente no tiene pedidos registrados.</div><?php endif; ?><?php endif; ?>
    </div>
</section><?php require_once 'includes/footer.php'; ?>