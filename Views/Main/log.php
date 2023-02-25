<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'Frontend/Bootstrap/css/bootstrap.min.css'; ?>">
    <link rel="shortcut icon" href="<?php echo constant('URL') . 'Frontend/Images/Icono.png'; ?>" type="image/x-icon">
    <title>Iniciar sesión/Crear cuenta</title>
</head>

<body>
    <section class="d-flex justify-content-center mt-5 ">
        <div class="border rounded-3 shadow overflow-hidden" style="width:50%; height:600px">
            <div class="row h-100">
                <div class="col">
                    <img src="<?php echo constant('URL') . 'Frontend/Images/Student.jpg'; ?>" style="width: 100%; height:100%; object-fit:cover" alt="img">
                </div>
                <div class="col p-5">
                    <form class="h-100 d-flex flex-column justify-content-center gap-3 " id="form-login">
                        <h2>Iniciar Sesión</h2>
                        <!-- <div class="form-group">
                            <select id="tipoLogin" class="form-select" name="tipoLogin">
                                <option value="0">Desarrollo Academico</option>
                                <option value="instructor">Instructor</option>
                                <option value="alumno">Alumno</option>
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label for="usuarioda">Email</label>
                            <input id="usuarioda" class="form-control" type="text" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input id="password" class="form-control" type="password" name="password">
                        </div>
                        <div class="alert alert-danger d-none" role="alert" id="alert-login">
                            Usuario o contraseña incorrecta
                        </div>

                        <button class="btn btn-primary" type="submit">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src=<?php echo constant('URL') . 'Frontend/Bootstrap/js/bootstrap.min.js'; ?>></script>
    <script src=<?php echo constant('URL') . 'Frontend/JS/AJAX.js'; ?>></script>
    <script src=<?php echo constant('URL') . 'Frontend/JS/Main/Log.js'; ?>></script>
</body>

</html>