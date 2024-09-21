<?php if (!empty($pedidos)): ?>
    <h2>Lista de Pedidos</h2>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= htmlspecialchars($pedido['id_pedido']); ?></td>
                    <td><?= htmlspecialchars($pedido['desc_pedido']); ?></td>
                    <td><?= htmlspecialchars($pedido['status_pedido']); ?></td>
                    <td><?= htmlspecialchars($pedido['data_pedido']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum pedido encontrado.</p>
<?php endif; ?>
