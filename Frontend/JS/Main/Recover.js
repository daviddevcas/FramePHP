const form_nickname = document.getElementById("form-nickname");
const form_code = document.getElementById("form-code");
const form_pass = document.getElementById("form-pass");
const alert_nickname = document.getElementById("alert-nickname");
const alert_code = document.getElementById("alert-code");
const alert_password = document.getElementById("alert-password");
const title = document.getElementById("title");
const layout = document.getElementById("layout");
const validate = { password: false };
var account = "",
  code = false;

form_nickname.addEventListener("submit", (event) => {
  event.preventDefault();

  account = document.getElementById("nickname").value;
  let form = new FormData(form_nickname);

  let xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", link + "Main/rewrite");
  xmlhttp.onload = () => {
    if (xmlhttp.status === 200) {
      let response = JSON.parse(xmlhttp.responseText);
      switch (response["message"]) {
        case "Hash has been successfully rewritten.":
          acept(alert_nickname);
          layout.style.height = "0";

          setTimeout(() => {
            form_nickname.style.display = "none";
            form_code.style.display = "block";
            title.innerText =
              "Escriba el código de verificación que le ha dado el gerente.";
          }, 500);

          setTimeout(() => {
            layout.style.height = "80%";
            setTimeout(() => {
              form_code.style.overflow = "auto";
            }, 500);
          }, 550);
          break;
        default:
          notAcept(alert_nickname, "Su nickname no existe.");
      }
    }
  };
  xmlhttp.send(form);
});

form_code.addEventListener("submit", (event) => {
  event.preventDefault();

  let form = new FormData(form_code);
  form.append("nickname", account);

  let xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", link + "Main/verify/hash");
  xmlhttp.onload = () => {
    if (xmlhttp.status === 200) {
      let response = JSON.parse(xmlhttp.responseText);
      switch (response["message"]) {
        case "User verified.":
          acept(alert_code);
          form_code.style.overflow = "hidden";
          layout.style.height = "0";
          code = true;

          setTimeout(() => {
            form_code.style.display = "none";
            form_pass.style.display = "block";
            title.innerText = "Escriba su nueva contraseña.";
          }, 500);

          setTimeout(() => {
            layout.style.height = "80%";
            setTimeout(() => {
              form_pass.style.overflow = "auto";
            }, 500);
          }, 550);
          break;
        default:
          notAcept(alert_code, "El código que escribio es incorrecto.");
      }
    }
  };
  xmlhttp.send(form);
});

const verifyInputChange = (element) => {
  if (element.target.name == "password") {
    verifyInput(
      element.target,
      alert_password,
      validate,
      "La contraseña debe incluir entre 8 y 16 carácteres, al menos un dígito, al menos una minúscula y al menos una mayúscula." +
        " La contraseña debe de incluir al menos uno de estos símbolos (@,#,$,%,_,<,>,{,},&,!).",
      expr.Password
    );
  }
};

document.querySelectorAll("#form-pass .input-form").forEach((element) => {
  element.addEventListener("blur", verifyInputChange);
});

form_pass.addEventListener("submit", (event) => {
  event.preventDefault();

  if (validate.password && code) {
    let form = new FormData(form_pass);
    form.append("nickname", account);

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", link + "Main/update");
    xmlhttp.onload = () => {
      if (xmlhttp.status === 200) {
        let response = JSON.parse(xmlhttp.responseText);
        switch (response["message"]) {
          case "User updated.":
            acept(alert_password);
            window.location = link + "Main/confirm/f0cea769";
            break;
          case "Password repeat.":
            notAcept(
              alert_password,
              "No puede utilizar su contraseña anterior."
            );
            break;
          case "Passwords not equals.":
            notAcept(alert_password, "Las contraseñas no son iguales.");
            break;
          default:
            notAcept(
              alert_password,
              "Ha ocurrido un error al intentar cambiar la contraseña."
            );
        }
      }
    };
    xmlhttp.send(form);
  } else {
    notAcept(alert_password, "Rellene los campos de manera correcta.");
  }
});
