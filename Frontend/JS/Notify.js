const notify = document.getElementById('notify');
const notify_image = document.getElementById('notify-display-image');
const notify_text = document.getElementById('notify-text');

function showNotify(src, msj){
    let image = document.createElement('img');
    image.src = src;
    image.classList.add('notify-image');
    notify_image.innerHTML = null;
    notify_image.append(image);
    notify_text.innerText = msj;
    notify.classList.toggle('notify-show');
    setTimeout(() => {
        notify.classList.toggle('notify-show');
    }, 3500); 
}

