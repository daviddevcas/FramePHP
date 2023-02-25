const alert_login = document.getElementById("alert-login");

document.getElementById("form-login").addEventListener("submit", (event) => {
  event.preventDefault();

  let form = new FormData(document.getElementById("form-login"));

  let xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", link + "Main/login");
  xmlhttp.onload = () => {
    if (xmlhttp.status === 200) {
      let response = JSON.parse(xmlhttp.responseText);
      switch (response["message"]) {
        case "Session is init.":
          acept(alert_login);
          window.location = link + "Main";
          break;
        case "Session already exist.":
          notAcept(alert_login, "La sesión ya está abierta.");
          break;
        case "Password incorrect.":
          notAcept(alert_login, "La contraseña es incorrecta.");
          break;
        case "Email incorrect.":
          notAcept(alert_login, "El correo es incorrecto.");
          break;
        default:
          notAcept(alert_login, "Ha ocurrido un error.");
          console.log(response["message"]);
      }
      xmlhttp.abort();
    }
  };
  xmlhttp.send(form);
});

