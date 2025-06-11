<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="container-body-login">

    <main class="container">
        <i class="fa-sharp fa-solid fa-circle-user"></i>

        <form action="/login" method="post">
            <div class="form-content">
                <input type="email" name="email" placeholder="E-mail">
                <input type="password" name="password" placeholder="Password">
                <div class="checkbox-container">
                    <label for="save"><input type="checkbox" name="save" id="save">Remember-me</label>
                    <a href="">Forgot password?</a>
                </div>
                <button type="submit">Login</button>
                <p>Don't have account? <a href="/register">Register</a></p>
            </div>
        </form>
    </main>
    <p class="rodape">
        <a href="https://github.com/WelGomes" target="_blank"><i class="fa-brands fa-github"></i></a>
        <a href="https://www.linkedin.com/in/welbert-gomes-8105b7219/" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
    </p>

    <script src="https://kit.fontawesome.com/04399c8787.js" crossorigin="anonymous"></script>
</body>

</html>