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
//je sélectionne le body grâce à sa classe et je le mets dans une variable
const body = document.querySelector('.js-body');

// je check si le mode chartreuse est activé dans le local storage,
// si oui je l'active avec le CSS en lui ajoutant la classe adéquate
const chartreuseMode  = localStorage.getItem('color-char')=== 'true';
if (chartreuseMode) {
    body.classList.add('color-char');
}
//je sélectionne le bouton grâce à sa classe et je le mets dans une variable
const toggleBtn = document.querySelector('.js-night-toggle');
//j'écoute les clicks sur le bouton pour lui ordonner
toggleBtn.addEventListener('click', function() {
    //d'activer le mode chartreuse ou pas
    // si le mode chartreuse est activé, je le désactive
    if (body.classList.contains('color-char')) {
        body.classList.remove('color-char');
        // je supprime le mode chartreuse du local storage
        localStorage.removeItem('color-char');
        console.log(localStorage);
        // si le mode chartreuse n'est pas activé, je l'active
    } else {
        body.classList.add('color-char');
        // j'enregistre le mode chartreuse dans le local storage
        localStorage.setItem('color-char', "true");
        console.log(localStorage);
    }

});