$(document).ready(function(){
    $("ul.nav li").on("click", navigacia());
});

function navigacia() {
    var adresa = window.location.href;
    var castStranky = adresa.substr(adresa.lastIndexOf("/")+1,adresa.length);

    if(castStranky == "panel"){
        aktivnyPrvokNavigacie($(".nav li"), 0);

    }else if(castStranky == "udalosti"){
        aktivnyPrvokNavigacie($(".nav li"), 1);

    }else if(castStranky == "pouzivatelia"){
        aktivnyPrvokNavigacie($(".nav li"), 2);

    }else if(castStranky == "miesta"){
        aktivnyPrvokNavigacie($(".nav li"), 3);

    }else if(castStranky == "administratori"){
        aktivnyPrvokNavigacie($(".nav li"), 4);
    }
}

function aktivnyPrvokNavigacie(prvok, pozicia){
    if(prvok.eq(pozicia).hasClass("active")){
        prvok.eq(pozicia).removeClass("active");
    }else{
        prvok.eq(pozicia).addClass("active");
    }
}