<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header class="site-header">
        <div class="container-header">
            <ul>
                <div>
                    <h1>
                        <li>CaseCrypto</li>
                    </h1>
                    <li><a href="/home">List Coin</a></li>
                    <li><a href="">Case</a></li>
                </div>
                <div>
                    <li>Welcome Welbert!</li>
                    <li><a href="/close">Exit</a></li>
                </div>
            </ul>
        </div>
    </header>

    <div class="container-main">
        <main class="coin-list">
            <table class="coin">
                <thead>
                    <tr>
                        <th>img</th>
                        <th>Coin</th>
                        <th>Price USD</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(array_key_exists('error', $coin)): ?>
                        <p><?= $coin['error'] ?></p>
                    <?php else: ?>
                        <?php foreach($coin as $key => $value): ?>
                    <tr>
                        <td> <img src="<?= $value->getImage() ?>" alt="<?= $value->getName() ?>"> </td>
                        <td>  <?= $value->getSymbol() ?> - <?= $value->getName() ?> </td>
                        <td>  <?= number_format($value->getPrice(), 2, '.', '.') ?> </td>
                        <td><button type="submit">Add</button></td>
                    </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
        <p class="rodape">
            <a href="https://github.com/WelGomes" target="_blank"><i class="fa-brands fa-github"></i></a>
            <a href="https://www.linkedin.com/in/welbert-gomes-8105b7219/" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
        </p>
    </div>
    <script src="https://kit.fontawesome.com/04399c8787.js" crossorigin="anonymous"></script>
</body>

</html>