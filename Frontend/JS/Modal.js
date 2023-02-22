const window_page = document.getElementById("window-page");
const window_content = document.getElementById("window-content");
const window_body = document.getElementById("window-body");
var show_window = false;

function showWindowModal(
  Uri = String,
  width = "700px",
  height = "500px",
  margin = "auto"
) {
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      window_body.innerHTML = this.responseText;
    }
  };

  xmlhttp.onloadend = function () {
    window_content.style.width = width;
    window_content.style.height = height;
    window_content.style.margin = margin;
    window_page.classList.add("show-window");
    setTimeout(() => {
      window_content.style.transform = "scale(1)";
      window_page.style.background = "rgba(211, 211, 211, .5)";
      show_window = true;
    }, 50);
  };

  xmlhttp.open("POST", link + Uri, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send(header);
}

function closeWindowModal() {
  window_content.style.transform = "scale(.7)";
  window_page.style.background = "rgba(211, 211, 211, 0)";
  setTimeout(() => {
    window_page.classList.remove("show-window");
    show_window = false;
  }, 300);
}

window.addEventListener("click", (event) => {
  let region = window_content.getBoundingClientRect();

  if (show_window) {
    if (
      event.clientX <= region.x ||
      event.clientX >= region.x + region.width ||
      event.clientY <= region.y ||
      event.clientY >= region.y + region.height
    ) {
      closeWindowModal();
    }
  }
});
