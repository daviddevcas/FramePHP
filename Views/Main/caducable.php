<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión caducada</title>
</head>

<body style="position:relative; width: 100%; height:100vh; background: linear-gradient(to bottom, rgba(131, 18, 56, 0.9), rgba(0, 16, 59, 0.9)); box-sizing: border-box; padding:0; margin:0;">

    <script src=<?php echo constant('URL') . 'Frontend/JS/AJAX.js'; ?>></script>

    <script>
        setTimeout(() => {
            alert('La sessión ha caducado');
            window.location = link + 'Main';
        }, 100);
    </script>
</body>

</html>