var identifikator = 0;
var castStranky = "";

$(".zatvorit").click(function () {
    $( "#dialog" ).fadeOut()
});



$("#novy_pouzivatel_admin_formular").on('submit',(function(e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/registracia/registrovat_sa", this, false);
}));

$( "#pouzivatel_admin_dialog_vytvorit" ).click(function() {
    $( "#novy_pouzivatel_admin_formular" ).trigger( "submit" );
});

$("#aktulizovat_pouzivatel_admin_formular").on('submit',(function(e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/pouzivatelia/aktualizuj_pouzivatela/"+identifikator, this, false);
}));

$( "#pouzivatel_admin_dialog_aktualizuj" ).click(function() {
    $( "#aktulizovat_pouzivatel_admin_formular" ).trigger( "submit" );
});

$( ".pouzivatel_admin_dialog_odstranit" ).click(function() {
    spracujData("/udalosti/index.php/pouzivatelia/odstran_pouzivatela/"+identifikator, null, false);
});



$("#nova_udalost_formular").on('submit',(function(e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/udalosti/nova_udalost", this, false);
}));

$( "#udalost_dialog_vytvorit" ).click(function() {
    $( "#nova_udalost_formular" ).trigger( "submit" );
});

$("#aktulizovat_udalost_formular").on('submit',(function(e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/udalosti/aktualizuj_udalost/"+identifikator, this, false);
}));

$( "#udalost_dialog_aktualizuj" ).click(function() {
    $( "#aktulizovat_udalost_formular" ).trigger( "submit" );
});

$( ".udalost_dialog_odstranit" ).click(function() {
    spracujData("/udalosti/index.php/udalosti/odstran_udalost/"+identifikator, null, false);
});



$( ".odstranit" ).click(function() {
    identifikator = parseInt($(this).attr('id'));
});

$( ".editovat" ).click(function() {
    var adresa = window.location.href;

    castStranky = adresa.substr(adresa.lastIndexOf("/")+1,adresa.length);
    identifikator = parseInt($(this).attr('id'));

    if(castStranky == "udalosti"){
        spracujData("/udalosti/index.php/udalosti/informacia_o_udalosti/"+identifikator, null, true);
    }else if((castStranky == "pouzivatelia") || (castStranky == "administratori")){
        spracujData("/udalosti/index.php/pouzivatelia/informacia_o_pouzivatelovi/"+identifikator, null, true);
    }
});



function dataFormulara(_this){
    var data;
    if(_this == null){
        data = "";
    }else{
        data = new FormData(_this);
    }
    return data;
}

function odpovedServera(data){
    var uspech = "uspech";

    if(data.substr(0,uspech.length) == uspech) {
        setTimeout(function(){ location.reload(); }, 1500);
    }

    $(".modal").append(data);
}



function spracujData(adresa, _this, aktualneUdaje) {
    $.ajax({
        url: window.location.origin+adresa,
        type: 'POST',
        data: dataFormulara(_this),

        contentType: false,
        cache: false,
        processData: false,

        success: function(data){
            if(aktualneUdaje){
                naplnPoleExistujucimyUdajmy(data)
            }else{
                odpovedServera(data)
            }
        }
    });
}



function naplnPoleExistujucimyUdajmy(data) {
    if(castStranky == "udalosti"){
        var udalost = data.udaje_udalosti;

        $("#cennik-aktualizovat-udalost").val(udalost.idCennik);
        $("#nazov-aktualizovat-udalost").val(udalost.nazov);
        $("#obrazok_udalosti-aktualizovat-udalost").val(udalost.obrazok);
        $("#datum-aktualizovat-udalost").val(udalost.datum);
        $("#cas-aktualizovat-udalost").val(udalost.cas);
        $("#miesto-aktualizovat-udalost").val(udalost.miesto);
        $("#stat-aktualizovat-udalost").val(udalost.stat);
        $("#okres-aktualizovat-udalost").val(udalost.okres);
        $("#mesto-aktualizovat-udalost").val(udalost.mesto);

    }else if((castStranky == "pouzivatelia") || (castStranky == "administratori")){
        var pouzivatel = data.udaje_pouzivatela;

        $("#meno-aktualizovat-pouzivatel_admin").val(pouzivatel.meno);
        $("#email-aktualizovat-pouzivatel_admin").val(pouzivatel.email);
        $("#rola-aktualizovat-pouzivatel_admin").val(pouzivatel.nazov);
    }
}