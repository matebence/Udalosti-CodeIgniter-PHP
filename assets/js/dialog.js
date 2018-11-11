var operacia = {"VYTVOR_AKTUALIZUJ": 1, "VYPLN_FORMULAR": 2, "ZISKAJ_CENNIK": 3};
var identifikator = 0;
var castStranky = "";




$(document).ready(function () {
    spracujData("/udalosti/index.php/cennik/", null, operacia.ZISKAJ_CENNIK);
});

$(".zatvorit").click(function () {
    $("#dialog").fadeOut()
});




$("#novy_pouzivatel_formular").on('submit', (function (e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/registracia/vytvorit", this, operacia.VYTVOR_AKTUALIZUJ);
}));

$("#pouzivatel_dialog_vytvorit").click(function () {
    $("#novy_pouzivatel_formular").trigger("submit");
});

$("#aktulizovat_pouzivatel_formular").on('submit', (function (e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/pouzivatelia/aktualizuj/" + identifikator, this, operacia.VYTVOR_AKTUALIZUJ);
}));

$("#pouzivatel_dialog_aktualizuj").click(function () {
    $("#aktulizovat_pouzivatel_formular").trigger("submit");
});

$(".pouzivatel_dialog_odstranit").click(function () {
    spracujData("/udalosti/index.php/pouzivatelia/odstran/" + identifikator, null, operacia.VYTVOR_AKTUALIZUJ);
});

$(".pouzivatel_dialog_akceptovat").click(function () {
    spracujData("/udalosti/index.php/pouzivatelia/akceptovat/" + identifikator, null, operacia.VYTVOR_AKTUALIZUJ);
});

$(".pouzivatel_dialog_blokovat").click(function () {
    spracujData("/udalosti/index.php/pouzivatelia/blokovat/" + identifikator, null, operacia.VYTVOR_AKTUALIZUJ);
});




$("#nova_udalost_formular").on('submit', (function (e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/udalosti/vytvorit", this, operacia.VYTVOR_AKTUALIZUJ);
}));

$("#udalost_dialog_vytvorit").click(function () {
    $("#nova_udalost_formular").trigger("submit");
});

$("#aktulizovat_udalost_formular").on('submit', (function (e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/udalosti/aktualizuj/" + identifikator, this, operacia.VYTVOR_AKTUALIZUJ);
}));

$("#udalost_dialog_aktualizuj").click(function () {
    $("#aktulizovat_udalost_formular").trigger("submit");
});

$(".udalost_dialog_odstranit").click(function () {
    spracujData("/udalosti/index.php/udalosti/odstran/" + identifikator, null, operacia.VYTVOR_AKTUALIZUJ);
});

$(".udalost_dialog_prijat").click(function () {
    spracujData("/udalosti/index.php/udalosti/prijat/" + identifikator, null, operacia.VYTVOR_AKTUALIZUJ);
});

$(".udalost_dialog_odmietnut").click(function () {
    spracujData("/udalosti/index.php/udalosti/odmietnut/" + identifikator, null, operacia.VYTVOR_AKTUALIZUJ);
});




$("#novy_cennik_formular").on('submit', (function (e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/cennik/vytvorit", this, operacia.VYTVOR_AKTUALIZUJ);
}));

$("#cennik_dialog_vytvorit").click(function () {
    $("#novy_cennik_formular").trigger("submit");
});

$("#aktulizovat_cennik_formular").on('submit', (function (e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/cennik/aktualizuj/" + identifikator, this, operacia.VYTVOR_AKTUALIZUJ);
}));

$("#cennik_dialog_aktualizuj").click(function () {
    $("#aktulizovat_cennik_formular").trigger("submit");
});

$(".cennik_dialog_odstranit").click(function () {
    spracujData("/udalosti/index.php/cennik/odstran/" + identifikator, null, operacia.VYTVOR_AKTUALIZUJ);
});




$(".obrazok_udalosti").eq(1).change(function (){
    $(".obrazok_udalosti_pozicia").eq(1).append("<input type='hidden' name='zmena_obrazka' value='1'>")
});




$(".odstranit").click(function () {
    identifikator = parseInt($(this).attr('class').split(" ")[0]);
});

$(".prijat").click(function () {
    identifikator = parseInt($(this).attr('class').split(" ")[0]);
});

$(".odmietnut").click(function () {
    identifikator = parseInt($(this).attr('class').split(" ")[0]);
});

$(".akceptovat").click(function () {
    identifikator = parseInt($(this).attr('class').split(" ")[0]);
});

$(".blokovat").click(function () {
    identifikator = parseInt($(this).attr('class').split(" ")[0]);
});

$(".editovat").click(function () {
    var adresa = window.location.href;

    castStranky = adresa.substr(adresa.lastIndexOf("/") + 1, adresa.length);
    identifikator = parseInt($(this).attr('class').split(" ")[0]);

    if (castStranky == "udalosti") {
        spracujData("/udalosti/index.php/udalosti/informacia/" + identifikator, null, operacia.VYPLN_FORMULAR);
    } else if ((castStranky == "administratori") || (castStranky == "organizatori") || (castStranky == "pouzivatelia")) {
        spracujData("/udalosti/index.php/pouzivatelia/informacia/" + identifikator, null, operacia.VYPLN_FORMULAR);
    } else if(castStranky == "cennik"){
        spracujData("/udalosti/index.php/cennik/informacia/" + identifikator, null, operacia.VYPLN_FORMULAR);
    }
});




function dataFormulara(_this) {
    var data;
    if (_this == null) {
        data = "";
    } else {
        data = new FormData(_this);
    }
    return data;
}

function odpovedServera(data) {
    var uspech = "<p style='display: none'>uspech</p>";

    if (data.substr(0, uspech.length) == uspech) {
        setTimeout(function () {
            location.reload();
        }, 1500);
    }

    $(".modal").append(data);
}

function naplnCennik(data) {
    for (var i = 0; i < data.zoznam_cien.length; i++) {
        $("#cennik-aktualizovat-udalost").append("<option value='"+data.zoznam_cien[i].idCennik+"'>"+data.zoznam_cien[i].suma+" €</option>");
        $("#cennik-nova-udalost").append("<option value='"+data.zoznam_cien[i].idCennik+"'>"+data.zoznam_cien[i].suma+" €</option>");
    }
}

function spracujData(adresa, _this, aktualneUdaje) {
    $.ajax({
        url: window.location.origin + adresa,
        type: 'POST',
        data: dataFormulara(_this),

        contentType: false,
        cache: false,
        processData: false,

        success: function (data) {
            if(data.length > 5000){
                location.reload();
            } else if (aktualneUdaje == operacia.VYPLN_FORMULAR) {
                naplnPoleExistujucimyUdajmy(data)
            } else if (aktualneUdaje == operacia.VYTVOR_AKTUALIZUJ) {
                odpovedServera(data);
            } else if (aktualneUdaje == operacia.ZISKAJ_CENNIK) {
                naplnCennik(data)
            }
        }
    });
}

function naplnPoleExistujucimyUdajmy(data) {
    if (castStranky == "udalosti") {
        var udalost = data.udaje_udalosti;

        $("#cennik-aktualizovat-udalost").val(udalost.idCennik);
        $("#nazov-aktualizovat-udalost").val(udalost.nazov);
        $("#obrazok_udalosti-aktualizovat-udalost").val(udalost.obrazok);
        $("#datum-aktualizovat-udalost").val(udalost.datum);
        $("#cas-aktualizovat-udalost").val(udalost.cas);
        $("#vstupenka-aktualizovat-udalost").val(udalost.vstupenka);
        $("#ulica-aktualizovat-udalost").val(udalost.ulica);
        $("#stat-aktualizovat-udalost").val(udalost.stat);
        $("#okres-aktualizovat-udalost").val(udalost.okres);
        $("#mesto-aktualizovat-udalost").val(udalost.mesto);

    } else if ((castStranky == "administratori") || (castStranky == "organizatori") || (castStranky == "pouzivatelia")) {
        var pouzivatel = data.udaje_pouzivatela;

        $("#meno-aktualizovat-pouzivatel").val(pouzivatel.meno);
        $("#email-aktualizovat-pouzivatel").val(pouzivatel.email);
        $("#rola-aktualizovat-pouzivatel").val(pouzivatel.nazov);

    } else if (castStranky == "cennik"){
        var cennik = data.udaje_cennika;

        $("#vaha-aktualizovat-cennik").val(cennik.vaha);
        $("#suma-aktualizovat-cennik").val(cennik.suma);
    }
}