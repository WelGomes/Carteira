<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CaseCrypto</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon/favicon.png" type="image/x-icon">
</head>

<body class="container-body-login">

    <main class="container">
        <i class="fa-sharp fa-solid fa-circle-user"></i>

        <form action="/" method="post">
            <div class="form-content">
                <input type="email" name="email" id="emailLogin" placeholder="E-mail" value="<?= $_COOKIE['save_email'] ?? null ?>">
                <input type="password" name="password" id="passwordLogin" placeholder="Password">
                <div class="checkbox-container">
                    <label for="save"><input type="checkbox" name="save" id="save" <?php if (isset($_COOKIE['save_email'])) echo 'checked' ?>>Remember-me</label>
                    <a href="">Forgot password?</a>
                </div>

                <?php if (!empty($error)): ?>
                    <p id="error"><?= $error ?></p>
                <?php endif ?>

                <button type="submit">Login</button>
                <p>Don't have account? <a href="/register">Register</a></p>
            </div>
        </form>
    </main>

    <?php require_once "includes/rodape.php" ?>

    <script src="js/login.js"></script>
    <script src="https://kit.fontawesome.com/04399c8787.js" crossorigin="anonymous"></script>
</body>

</html>