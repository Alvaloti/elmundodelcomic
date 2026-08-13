<?php
session_start();
if (!isset($_SESSION['id_usuario']) || ($_SESSION['tipo_usuario'] ?? '') !== 'CT') {
    header('Location:index.php');
    exit;
}
require_once 'config/conexion.php';
$s = $pdo->prepare('SELECT IDUsuario,Nombre,ApellidoPaterno,ApellidoMaterno FROM USUARIOS WHERE IDUsuario=:id AND TipoUsuario=\'CT\'');
$s->execute([':id' => $_SESSION['id_usuario']]);
$cliente = $s->fetch();
$s = $pdo->prepare('SELECT IDProducto,NombreProducto,Marca,UnidadMedida,Precio FROM PEDIDOS WHERE IDUsuario=:id ORDER BY IDProducto');
$s->execute([':id' => $_SESSION['id_usuario']]);
$pedidos = $s->fetchAll();
require_once 'includes/header.php'; ?>
<section class="pagina-pedidos-fondo">
    <div class="panel">
        <h1>Consultar pedidos</h1>
        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($cliente['IDUsuario'], ENT_QUOTES, 'UTF-8'); ?> <strong>Nombre:</strong> <?php echo htmlspecialchars($cliente['Nombre'] . ' ' . $cliente['ApellidoPaterno'] . ' ' . $cliente['ApellidoMaterno'], ENT_QUOTES, 'UTF-8'); ?></p>
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
                        </tr>
                    </thead>
                    <tbody><?php foreach ($pedidos as $p): ?><tr>
                                <td><?php echo htmlspecialchars($p['IDProducto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($p['NombreProducto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($p['Marca'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($p['UnidadMedida'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>$<?php echo number_format((float)$p['Precio'], 2); ?></td>
                            </tr><?php endforeach; ?></tbody>
                </table>
            </div><?php else: ?><div class="mensaje info">No tienes pedidos registrados.</div><?php endif; ?>
    </div>
</section><?php require_once 'includes/footer.php'; ?>