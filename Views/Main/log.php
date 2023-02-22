<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Main/Log.css'; ?>">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Footer.css'; ?>">
    <link rel="shortcut icon" href="<?php echo constant('URL') . 'Frontend/Images/Icono.png'; ?>" type="image/x-icon">
    <title>Iniciar sesión/Crear cuenta</title>
</head>

<body>
    <section class="background">
        <div class="content">
            <div class="btns">
                <div class="bar" id="bar"></div>
                <div class="left"><button class="btn-left" id="btn-left">Iniciar sesión</button></div>
                <div class="right"><button class="btn-right" id="btn-right">Crear cuenta</button></div>
            </div>
            <div class="formularys">
                <div class="show-formulary" id="show">
                    <form class="login" id="form-login">
                        <div class="display-title">
                            <p class="title">Iniciar sesión</p>
                        </div>
                        <input type="text" class="input-form" name="nickname" placeholder="Nickname" required maxlength="30">
                        <input type="password" class="input-form" name="password" placeholder="Contraseña" required maxlength="16">
                        <div class="alert" id="alert-login"></div>
                        <div class="display-link">
                            <a href=<?php echo constant('URL') . 'Main/recover'; ?> class="link-log">¿Olvidó su contraseña?</a>
                        </div>
                        <div class="display-btn">
                            <button class="btn-submit" type="submit">Iniciar sesión</button>
                        </div>
                    </form>
                    <form class="create" id="form-create">
                        <div class="display-title">
                            <p class="title">Crear cuenta</p>
                        </div>
                        <input type="text" class="input-form" name="name" placeholder="Nombre(s)" required maxlength="30">
                        <input type="text" class="input-form" name="lastname" placeholder="Apellido(s)" required maxlength="30">
                        <div class="alert" id="alert-name"></div>
                        <input type="text" class="input-form" name="nickname" placeholder="Nickname" required maxlength="30">
                        <div class="alert" id="alert-nickname"></div>
                        <input type="password" name="password" class="input-form" placeholder="Contraseña" required maxlength="16">
                        <div class="alert" id="alert-password"></div>
                        <input type="password" name="password-confirm" class="input-form" placeholder="Confirmar contraseña" required maxlength="16">
                        <div class="alert" id="alert-confirm"></div>
                        <div class="display-btn">
                            <button class="btn-submit" type="submit">Crear cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php
    require_once('Views/footer.php');
    ?>
    <script src=<?php echo constant('URL') . 'Frontend/JS/AJAX.js'; ?>></script>
    <script src=<?php echo constant('URL') . 'Frontend/JS/Main/Log.js'; ?>></script>
</body>

</html>