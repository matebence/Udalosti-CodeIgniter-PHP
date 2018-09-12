var identifikator = 0;
var castStranky = "";

$(".zatvorit").click(function () {
    $( "#dialog" ).fadeOut()
});

$( "#udalost_dialog_vytvorit" ).click(function() {
    $( "#nova_udalost_formular" ).trigger( "submit" );
});

$( "#udalost_dialog_aktualizuj" ).click(function() {
    $( "#aktulizovat_udalost_formular" ).trigger( "submit" );
});

$( ".udalost_dialog_odstranit" ).click(function() {
    spracujData("/udalosti/index.php/udalosti/odstran_udalost/"+identifikator, null, false);
});

$("#nova_udalost_formular").on('submit',(function(e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/udalosti/nova_udalost", this, false);
}));

$("#aktulizovat_udalost_formular").on('submit',(function(e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/udalosti/aktualizuj_udalost/"+identifikator, this, false);
}));

$( ".odstranit" ).click(function() {
    identifikator = parseInt($(this).attr('id'));
});

$( ".editovat" ).click(function() {
    var adresa = window.location.href;

    castStranky = adresa.substr(adresa.lastIndexOf("/")+1,adresa.length);
    identifikator = parseInt($(this).attr('id'));

    if(castStranky == "udalosti"){
        spracujData("/udalosti/index.php/udalosti/informacia_o_udalosti/"+identifikator, null, true);
    }else if(castStranky == "pouzivatelia"){
    }else if(castStranky == "administratori"){
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

    }else if(castStranky == "pouzivatelia"){
    }else if(castStranky == "administratori"){
    }
}

function odpovedServera(data){
    var uspech = "uspech";

    if(data.substr(0,uspech.length) == uspech){
        setTimeout(function(){ location.reload(); }, 1500);
    }

    $(".modal").append(data);
}