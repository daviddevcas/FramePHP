<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Errors/404.css'; ?>">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Footer.css'; ?>">
    <link rel="shortcut icon" href="<?php echo constant('URL') . 'Frontend/Images/Icono.png'; ?>" type="image/x-icon">
    <title>Error <?php echo $typeError; ?></title>
</head>

<body>
    <header class="header">
        <div class="content">
            <div class="body-content">
                <p>Error <?php echo "{$typeError}: {$messageError}" ?></p>
                <p><?php
                    if (isset($message)) {
                        echo $message;
                    }
                    ?></p>
                <hr color="orange">
            </div>

            <div class="display-link">
                <a href="<?php echo constant('URL'); ?>" class="link-home">Regresar</a>
            </div>
        </div>
    </header>

    <?php
    require_once('Views/footer.php');
    ?>
</body>

</html>