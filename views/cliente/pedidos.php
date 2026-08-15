<?php foreach ($pedidos as $pedido): ?>

    <div class="pedido">

        <strong>
            Pedido
            #<?=
                htmlspecialchars(
                    $pedido['codigo'],
                    ENT_QUOTES,
                    'UTF-8'
                )
                ?>
        </strong>

        <p>
            Status:
            <?=
            htmlspecialchars(
                $pedido['status'],
                ENT_QUOTES,
                'UTF-8'
            )
            ?>
        </p>

    </div>

<?php endforeach; ?>