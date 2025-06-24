<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CaseCrypto</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon/favicon.png" type="image/x-icon">
</head>

<body class="container-body-register">


    <main class="container-register">
        <i class="fa-sharp fa-solid fa-circle-user icon"></i>
        <h1>Register</h1>
        <form action="/register" method="post">
            <div class="form-content">
                <div class="input-names">
                    <input type="text" placeholder="Name" name="name" id="name" required>
                    <input type="text" placeholder="Last Name" name="lastName" id="lastName" required>
                </div>
                <div class="form-content">
                    <input type="email" placeholder="E-mail" name="email" id="email" required>
                    <input type="password" placeholder="Password" name="password" id="password" required>
                </div>
                <?php if (!empty($error)): ?>
                    <p id="error"><?= $error ?></p>
                <?php endif ?>
                <button type="submit">Register</button>
                <p><a href="/">Have an account?</a></p>
            </div>
        </form>
    </main>

    <?php require_once "includes/rodape.php" ?>

    <script src="js/register.js"></script>
    <script src="https://kit.fontawesome.com/04399c8787.js" crossorigin="anonymous"></script>
</body>

</html>