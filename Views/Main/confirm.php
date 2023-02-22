<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Main/Confirm.css'; ?>">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Footer.css'; ?>">
    <link rel="shortcut icon" href="<?php echo constant('URL') . 'Frontend/Images/Icono.png'; ?>" type="image/x-icon">
    <title>¡Todo parece correcto!</title>
</head>

<body>
    <header class="header">
        <div class="content">
            <div class="body-content">
                <h1>¡Todo parece correcto!</h1>
                <p><?php echo $msj; ?></p>
                <hr color="orange">
            </div>

            <div class="display-link">
                <a href="<?php echo constant('URL') . 'Main'; ?>" class="link-home">Regresar</a>
            </div>
        </div>
    </header>

    <?php
    require_once 'Views/footer.php';
    ?>
</body>

</html>