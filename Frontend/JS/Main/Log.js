const btn_left = document.getElementById("btn-left");
const btn_right = document.getElementById("btn-right");
const bar = document.getElementById("bar");
const show = document.getElementById("show");

btn_right.classList.toggle("push");
var isleft = true;

btn_left.addEventListener("click", () => {
  bar.style.marginLeft = "0";

  if (!isleft) {
    show.classList.toggle("move");
    btn_left.classList.toggle("push");
    btn_right.classList.toggle("push");
  }
  isleft = true;
});

btn_right.addEventListener("click", () => {
  bar.style.marginLeft = "45%";

  if (isleft) {
    show.classList.toggle("move");
    btn_left.classList.toggle("push");
    btn_right.classList.toggle("push");
  }
  isleft = false;
});

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
        case "Nickname incorrect.":
          notAcept(alert_login, "El usuario o nickname es incorrecto.");
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

const create = {
  name: false,
  lastname: false,
  nickname: false,
  password: false,
};

const alert_name = document.getElementById("alert-name");
const alert_nickname = document.getElementById("alert-nickname");
const alert_pass = document.getElementById("alert-password");
const alert_confirm = document.getElementById("alert-confirm");

const verifyInputCreate = (element) => {
  switch (element.target.name) {
    case "nickname":
      verifyInput(
        element.target,
        alert_nickname,
        create,
        "El nickname debe ser escrito sin utilizar carácteres" +
          " especiales excepto el guion bajo (_) y no debe de llevar espacios.",
        expr.Nickname
      );
      break;
    case "name":
      verifyInput(
        element.target,
        alert_name,
        create,
        "El nombre y apellido solo puede ser escrito por letras sin utilizar carácteres especiales.",
        expr.Name
      );
      break;
    case "lastname":
      verifyInput(
        element.target,
        alert_name,
        create,
        "El nombre y apellido solo puede ser escrito por letras sin utilizar carácteres especiales.",
        expr.Name
      );
      break;
    case "password":
      verifyInput(
        element.target,
        alert_pass,
        create,
        "La contraseña debe incluir entre 8 y 16 carácteres, al menos un dígito, al menos una minúscula y al menos una mayúscula." +
          " La contraseña debe de incluir al menos uno de estos símbolos (@,#,$,%,_,<,>,{,},&,!).",
        expr.Password
      );
      break;
  }
};

document.querySelectorAll("#form-create .input-form").forEach((element) => {
  element.addEventListener("blur", verifyInputCreate);
});

document.getElementById("form-create").addEventListener("submit", (event) => {
  event.preventDefault();

  if (create.name && create.lastname && create.password && create.nickname) {
    let form = new FormData(document.getElementById("form-create"));

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", link + "Main/create");
    xmlhttp.onload = () => {
      if (xmlhttp.status === 200) {
        let response = JSON.parse(xmlhttp.responseText);
        switch (response["message"]) {
          case "Account was created.":
            acept(alert_confirm);
            window.location = link + "Main/confirm/a26bf5c5";
            break;
          case "Passwords not equals.":
            notAcept(alert_confirm, "Las contraseñas no son iguales.");
            break;
          case "Account already exist.":
            notAcept(alert_confirm, "La cuenta ya existe.");
            break;
          default:
            notAcept(alert_confirm, "Ha ocurrido un error.");
            console.log(response["message"]);
        }
        xmlhttp.abort();
      }
    };
    xmlhttp.send(form);
  } else {
    notAcept(alert_confirm, "Rellene los campos de manera correcta.");
  }
});
