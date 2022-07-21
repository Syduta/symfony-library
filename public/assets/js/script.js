console.log('lol');
const bouton = document.querySelector('.bttn');
bouton.addEventListener('click',function (){
    const links = document.querySelector('.boody');
    console.log(bouton);

    if(links.classList.contains("color-char")){

        links.classList.remove("color-char");

    }else{
        links.classList.add("color-char");

    }
})