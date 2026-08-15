<?php foreach ($enderecos as $endereco): ?>

    <div class="card">

        <strong>
            <?=
            htmlspecialchars(
                $endereco['identificacao'],
                ENT_QUOTES,
                'UTF-8'
            )
            ?>
        </strong>

        <p>
            <?=
            htmlspecialchars(
                $endereco['logradouro'],
                ENT_QUOTES,
                'UTF-8'
            )
            ?>
        </p>

    </div>

<?php endforeach; ?>