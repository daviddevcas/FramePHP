<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Main/Recover.css'; ?>">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Footer.css'; ?>">
    <link rel="shortcut icon" href="<?php echo constant('URL') . 'Frontend/Images/Icono.png'; ?>" type="image/x-icon">
    <title>Recupera su cuenta</title>
</head>

<body>

    <section class="background">
        <div class="content">
            <div class="display-title">
                <h3 class="title" id="title">Escriba su correo para poder recuperar su cuenta.</h3>
            </div>

            <div class="layout" id="layout">
                <form class="formulary" id="form-nickname">
                    <input type="text" name="nickname" id="nickname" class="input-form" placeholder="Nickname" required maxlength="30">
                    <div class="alert" id="alert-nickname"></div>
                    <div class="display-btn">
                        <button class="btn-submit" type="submit">Buscar</button>
                    </div>
                </form>

                <form class="code" id="form-code">
                    <input type="text" name="hash" class="input-form" placeholder="Código" required maxlength="8">
                    <div class="alert" id="alert-code"></div>
                    <div class="display-btn">
                        <button class="btn-submit" type="submit">Continuar</button>
                    </div>
                </form>

                <form class="password" id="form-pass">
                    <input type="password" name="password" class="input-form" placeholder="Contraseña" required maxlength="16">
                    <input type="password" name="password-confirm" class="input-form" placeholder="Confirmar contraseña">
                    <div class="alert" id="alert-password"></div>
                    <div class="display-btn">
                        <button class="btn-submit" type="submit">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php
    include_once('Views/footer.php');
    ?>

    <script src=<?php echo constant('URL') . 'Frontend/JS/AJAX.js'; ?>></script>
    <script src=<?php echo constant('URL') . 'Frontend/JS/Main/Recover.js'; ?>></script>
</body>

</html>