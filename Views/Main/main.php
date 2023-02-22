<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Navegator.css'; ?>">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Main/Main.css'; ?>">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/styles.css'; ?>">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/CSS/Footer.css'; ?>">
    <link rel="shortcut icon" href="<?php echo constant('URL') . 'Frontend/Images/Icono.png'; ?>" type="image/x-icon">
    <title>Bienvenido a <?php echo constant('NAME'); ?></title>
</head>

<body>
    <header class="header">
        <div class="content">
            <div class="logo">
                <!-- <img src="<?php echo constant('URL') . 'Frontend/Images/Logov3.png'; ?>" alt="<?php echo constant('NAME'); ?>" class="img-logo"> -->
            </div>

            <div class="navegator" id="nav">
                <div class="title-nav">
                    Navegador
                </div>

                <ul class="list-nav">
                    <li class="element-list"><a href="#" class="link-nav this"><span class="icon-home"> Principal</span></a></li>
                    <!--<li class="element-list"><a href="#" class="link-nav"><span class="icon-shop"> Tienda</span></a></li>-->
                    <li class="element-list">
                        <?php
                        if ($this->getSession()->getCurrentUser() == '') {
                        ?>
                            <a href="<?php echo constant('URL') . 'Main/log'; ?>" class="link-nav"><span class="icon-sign-in"> Iniciar sesión</span></a>
                        <?php
                        } 
                        ?>
                    </li>
                </ul>
                <div class="footer-nav">
                    <hr color="orangered">
                    <p class="bottom"><?php echo constant('NAME'); ?> &copy; Todos los derechos reservados</p>
                </div>
            </div>

            <div class="display-btn">
                <button class="btn-nav" id="btn-nav">&#9776;</button>
            </div>
        </div>
    </header>

    <section class="banner add-filter">
        <div class="content">
            <div class="scroll-images">
                <div class="slider" id="slider">
                    <div class="slide"><img src="<?php echo constant('URL') . 'Frontend/Images/Store.jpg'; ?>" alt="Imagen" class="img-slide"></div>
                    <div class="slide"><img src="<?php echo constant('URL') . 'Frontend/Images/Store2.jpg'; ?>" alt="Imagen" class="img-slide"></div>
                    <div class="slide"><img src="<?php echo constant('URL') . 'Frontend/Images/Store3.jpg'; ?>" alt="Imagen" class="img-slide"></div>
                </div>
                <div class="btns">
                    <div class="left">
                        <div class="btn-slider btn-slider-left" id="btn-left-slider">&#60;</div>
                    </div>
                    <div class="right">
                        <div class="btn-slider btn-slider-right" id="btn-right-slider">&#62;</div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <?php
    require_once('Views/footer.php');
    ?>

    <script src=<?php echo constant('URL') . 'Frontend/JS/Navegator.js'; ?>></script>
    <script src=<?php echo constant('URL') . 'Frontend/JS/AJAX.js'; ?>></script>
    <script src=<?php echo constant('URL') . 'Frontend/JS/Main.js'; ?>></script>
</body>

</html>