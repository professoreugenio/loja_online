<?php

use App\Helpers\View;

?>

<main>

    <?php

    View::componente(
        'cliente/menu',
        [
            'menuAtivo' =>
            'painel',
        ]
    );

    ?>

    <section>

        <h1>
            Olá,
            <?=
            htmlspecialchars(
                $cliente['nome'],
                ENT_QUOTES,
                'UTF-8'
            )
            ?>
        </h1>

        <p>
            Bem-vindo à sua conta.
        </p>

    </section>

</main>