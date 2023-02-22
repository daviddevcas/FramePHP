const btn_nav = document.getElementById('btn-nav');
const nav = document.getElementById('nav');
const header = document.querySelector('.header');
var show = false;

btn_nav.addEventListener('click', ()=>{
    showNavegator();
});

window.addEventListener('click',(e)=>{
    if(show && !btn_nav.contains(e.target)){
        if(!nav.contains(e.target)){
            showNavegator();
        }
    }
});

function showNavegator(){
    nav.classList.toggle('show');
    show = !show;
    btn_nav.classList.toggle('btn-actived');
    btn_nav.innerHTML = btn_nav.innerText=='+'? '&#9776;':'<strong>+</strong>';

     document.getElementsByTagName("html")[0].classList.toggle('block');
     let objects = document.querySelectorAll('.add-filter');

     objects.forEach( (element)=>{
         element.classList.toggle('filter');
     });
}


function sizeWindown() {
    var size = [0, 0];
    if (typeof window.innerWidth != 'undefined') {
        size = [window.innerWidth, window.innerHeight];
    }
    else if (typeof document.documentElement != 'undefined'
        && typeof document.documentElement.clientWidth !=
        'undefined' && document.documentElement.clientWidth != 0) {
        size = [
            document.documentElement.clientWidth,
            document.documentElement.clientHeight
        ];
    }
    else {
        size = [
            document.getElementsByTagName('body')[0].clientWidth,
            document.getElementsByTagName('body')[0].clientHeight
        ];
    }
    return size;
}

window.onscroll = function () {
        if(sizeWindown()[0]>1024){
            if(window.scrollY >30){
                header.classList.add('scroll');
            }else{
                header.classList.remove('scroll');
            }
        }else{
            header.classList.remove('scroll');
        } 
};
