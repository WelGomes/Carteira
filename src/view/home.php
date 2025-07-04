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
                    <?php if ($error): ?>
                        <p><?= $error ?></p>
                    <?php else: ?>
                        <?php foreach ($coin as $key => $value): ?>
                            <form action="/case" method="post">
                                <tr>
                                    <td> <img src="<?= $value->getImage() ?>" alt="<?= $value->getName() ?>"> </td>
                                    <td> <?= "{$value->getSymbol()} - {$value->getName()}" ?></td>
                                    <td> <?= number_format($value->getPrice(), 2, '.', '.') ?> </td>

                                    <input type="text" name="image" id="image" value="<?= $value->getImage() ?>" hidden>
                                    <input type="text" name="symbol" id="symbol" value="<?= $value->getSymbol() ?>" hidden>
                                    <input type="text" name="name" id="name" value="<?= $value->getName() ?>" hidden>
                                    <input type="text" name="price" id="price" value="<?= $value->getPrice() ?>" hidden>

                                    <td> <input type="number" placeholder="Quantity" name="quantity" id="quantity" step="0.001" required> </td>
                                    <td> <button type="submit" class="add" name="action" value="add">Add</button> </td>
                                </tr>
                            </form>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>

        <?php require_once "includes/rodape.php" ?>

    </div>
</body>

</html>