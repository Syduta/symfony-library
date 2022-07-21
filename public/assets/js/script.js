// console.log('lol');
//
// const body = document.querySelector('.body');
// const chartreuseMode  = localStorage.getItem('color-char')=== 'true';
//
//
// if (chartreuseMode) {
//     document.querySelector('.body').classList.add('color-char');
// }
//
// const bouton = document.querySelector('.bttn');
// bouton.addEventListener('click',function (){
//
//
//     if(body.classList.contains("color-char")){
//         body.classList.remove("color-char");
//         localStorage.removeItem('color-char');
//
//     }else{
//         body.classList.add("color-char");
//         localStorage.setItem('color-char', 'true');
//
//     }
// })
// console.log(localStorage);
//
const body = document.querySelector('.js-body');

// je check si le mode chartreuse est activé dans le local storage,
// si oui je l'active avec le CSS
const chartreuseMode  = localStorage.getItem('color-char')=== 'true';
if (chartreuseMode) {
    body.classList.add('color-char');
}

const nightToggleBtn = document.querySelector('.js-night-toggle');

nightToggleBtn.addEventListener('click', function() {

    // si le mode chartreuse est activé, je le désactive
    if (body.classList.contains('color-char')) {
        body.classList.remove('color-char');
        // je supprime le mode nuit du local storage
        localStorage.removeItem('color-char');
        console.log(localStorage);
        // si le mode chartreuse n'est pas activé, je l'active
    } else {
        body.classList.add('color-char');
        // j'enregistre le mode nuit dans le local storage
        localStorage.setItem('color-char', "true");
        console.log(localStorage);
    }

});