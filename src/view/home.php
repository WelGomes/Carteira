
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CaseCrypto</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon/favicon.png" type="image/x-icon">
</head>

<body>
    
    <?php require_once "includes/navbar.php" ?>

    <div class="container-main">
        <main class="coin-list">
            <table class="coin">
                <thead>
                    <tr>
                        <th>img</th>
                        <th>Coin</th>
                        <th>Price USD</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (array_key_exists('error', $coin)): ?>
                        <p><?= $coin['error'] ?></p>
                    <?php else: ?>
                        <?php foreach ($coin as $key => $value): ?>
                            <tr>
                                <td> <img src="<?= $value->getImage() ?>" alt="<?= $value->getName() ?>"> </td>
                                <td> <?= $value->getSymbol() ?> - <?= $value->getName() ?> </td>
                                <td> <?= number_format($value->getPrice(), 2, '.', '.') ?> </td>
                                <form action="/coin" method="post">
                                    <input type="text" name="image" id="image" value="<?= $value->getImage() ?>" hidden>
                                    <input type="text" name="symbol" id="symbol" value="<?= $value->getSymbol() ?>" hidden>
                                    <input type="text" name="name" id="name" value="<?= $value->getName() ?>" hidden>
                                    <input type="text" name="price" id="price" value="<?= $value->getPrice() ?>" hidden>
                                    <td><input type="number" placeholder="Quantity" name="quantity" id="quantity" step="0.001"></td>
                                    <td> <button type="submit">Add</button> </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>

        <?php require_once "includes/rodape.php" ?>

    </div>
    <script src="https://kit.fontawesome.com/04399c8787.js" crossorigin="anonymous"></script>
</body>

</html>