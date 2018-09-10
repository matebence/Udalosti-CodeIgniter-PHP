$(document).ready(function(){
    $("ul.nav li").on("click", navigacia());

    nacitanieMapy();
    nacitanieSuborov();
    zvolenySubor();
});

function navigacia() {
    var adresa = window.location.href;
    var castStranky = adresa.substr(adresa.lastIndexOf("/")+1,adresa.length);

    if(castStranky == "panel"){
        aktivnyPrvokNavigacie($(".nav li"), 0);
        $("#nova_udalost").show();

    }else if(castStranky == "udalosti"){
        aktivnyPrvokNavigacie($(".nav li"), 1);
        $("#nova_udalost").hide();

    }else if(castStranky == "pouzivatelia"){
        aktivnyPrvokNavigacie($(".nav li"), 2);
        $("#nova_udalost").show();

    }else if(castStranky == "miesta"){
        aktivnyPrvokNavigacie($(".nav li"), 3);
        $("#nova_udalost").show();

    }else if(castStranky == "administratori"){
        aktivnyPrvokNavigacie($(".nav li"), 4);
        $("#nova_udalost").show();

    }
}

function aktivnyPrvokNavigacie(prvok, pozicia){
    if(prvok.eq(pozicia).hasClass("active")){
        prvok.eq(pozicia).removeClass("active");
    }else{
        prvok.eq(pozicia).addClass("active");
    }
}

function nacitanieMapy(){
    var adresa = window.location.origin+"/mapa.php";
    if(implementaciaMapy(adresa)){
        $("#mapa").attr('src',adresa);
    }else{
        alert("Súbor nebol nájdený "+window.location.origin+"/mapa.php");
        alert("Funkcia MIESTA je nefunkčná");
    }
}

function nacitanieSuborov(){
    $(':file').on('fileselect', function(event, subor, nazov) {

        var vstup = $(this).parents('.input-group').find(':text'),
            data = subor > 1 ? subor + ' files selected' : nazov;

        if( vstup.length ) {
            vstup.val(data);
        } else {
            if( data ) alert(data);
        }
    });
}

function zvolenySubor(){
    $(document).on('change', ':file', function() {
        var vstup = $(this),
            subor = vstup.get(0).files ? vstup.get(0).files.length : 1,
            nazov = vstup.val().replace(/\\/g, '/').replace(/.*\//, '');
        vstup.trigger('fileselect', [subor, nazov]);
    });
}

function implementaciaMapy(adresa){
    var poziadavka;
    if(window.XMLHttpRequest){
        poziadavka = new XMLHttpRequest();
    }else{
        poziadavka = new ActiveXObject("Microsoft.XMLHTTP");
    }
    poziadavka.open('GET', adresa, false);
    poziadavka.send();
    return poziadavka.status !== 404;
}