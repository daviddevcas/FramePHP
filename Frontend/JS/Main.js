const slider_right = document.getElementById('btn-right-slider');
const slider_left = document.getElementById('btn-left-slider');
const slider = document.getElementById('slider');
var slides = document.querySelectorAll('.slide');
var slide_last = slides[slides.length -1];

slider.insertAdjacentElement('afterbegin', slide_last);

function moveNext(){
    let slide_firts = document.querySelectorAll('.slide')[0];
    slider.style.transition = 'all .5s';
    slider.style.marginLeft = '-200%';

    setTimeout(()=>{
        slider.style.transition = 'none';
        slider.insertAdjacentElement('beforeend', slide_firts);
        slider.style.marginLeft = '-100%';
    },500);
}

function movePrev(){
    let slides = document.querySelectorAll('.slide');
    let slide_last = slides[slides.length -1];
    slider.style.transition = 'all .5s';
    slider.style.marginLeft = '0';

    setTimeout(()=>{
        slider.style.transition = 'none';
        slider.insertAdjacentElement('afterbegin', slide_last);
        slider.style.marginLeft = '-100%';
    },500);
}

var intervalSlider = setInterval(()=>{
    moveNext();
},6000);


slider_right.addEventListener('click',()=>{
    clearInterval(intervalSlider);
    intervalSlider = null;
    moveNext();
    intervalSlider = setInterval(()=>{
        moveNext();
    },6000);
});


slider_left.addEventListener('click',()=>{
    clearInterval(intervalSlider);
    intervalSlider = null;
    movePrev();
    intervalSlider = setInterval(()=>{
        moveNext();
    },6000);
});


