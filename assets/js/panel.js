$(document).ready(function () {
    $("ul.nav li").on("click", navigacia());

    nacitanieMapy();
    nacitanieSuborov();
    zvolenySubor();
});

$(".nova_udalost").click(function () {
    zoznamMiestOkresov("#mesto-nova-udalost", "#mesta-obce", "mesta_obce.json");
    zoznamMiestOkresov("#mesto-aktualizovat-udalost", "#mesta-obce", "mesta_obce.json");

    zoznamMiestOkresov("#okres-nova-udalost", "#okresy", "okresy.json");
    zoznamMiestOkresov("#okres-aktualizovat-udalost", "#okresy", "okresy.json");
});

function navigacia() {
    var adresa = window.location.href;
    var castStranky = adresa.substr(adresa.lastIndexOf("/") + 1, adresa.length);

    if (castStranky == "panel") {
        aktivnyPrvokNavigacie($(".nav li > a > p"), "panel");
        $("#vytvorit_udalost").show();

    } else if (castStranky == "udalosti") {
        aktivnyPrvokNavigacie($(".nav li > a > p"), "udalosti");
        $("#vytvorit_udalost").hide();

    } else if (castStranky == "pouzivatelia") {
        aktivnyPrvokNavigacie($(".nav li > a > p"), "používatelia");
        $("#vytvorit_udalost").show();

    } else if (castStranky == "cennik") {
        aktivnyPrvokNavigacie($(".nav li > a > p"), "cenník");
        $("#vytvorit_udalost").show();

    } else if (castStranky == "zaujmy") {
        aktivnyPrvokNavigacie($(".nav li > a > p"), "záujmy používatelov");
        $("#vytvorit_udalost").show();

    } else if (castStranky == "miesta") {
        aktivnyPrvokNavigacie($(".nav li > a > p"), "miesta");
        $("#vytvorit_udalost").show();

    } else if (castStranky == "lokalizacia") {
        aktivnyPrvokNavigacie($(".nav li > a > p"), "lokalizácia");
        $("#vytvorit_udalost").show();

    } else if (castStranky == "organizatori") {
        aktivnyPrvokNavigacie($(".nav li > a > p"), "organizátori");
        $("#vytvorit_udalost").show();
    } else if (castStranky == "administratori") {
        aktivnyPrvokNavigacie($(".nav li > a > p"), "administrátori");
        $("#vytvorit_udalost").show();
    }
}

function aktivnyPrvokNavigacie(prvok, nazov) {
    for (var i = 0; i < prvok.length; i++) {
        if (prvok.eq(i).text() === nazov) {
            if (prvok.eq(i).parent().parent().hasClass("active")) {
                prvok.eq(i).parent().parent().removeClass("active");
            } else {
                prvok.eq(i).parent().parent().addClass("active");
            }
        }
    }
}

function nacitanieMapy() {
    var adresa = window.location.origin + "/mapa.php";
    if (implementaciaMapy(adresa)) {
        $("#mapa").attr('src', adresa);
    } else {
        alert("Súbor nebol nájdený " + window.location.origin + "/mapa.php");
        alert("Funkcia LOKALIZACIA je nefunkčná");
    }
}

function nacitanieSuborov() {
    $(':file').on('fileselect', function (event, subor, nazov) {

        var vstup = $(this).parents('.input-group').find(':text'),
            data = subor > 1 ? subor + ' files selected' : nazov;

        if (vstup.length) {
            vstup.val(data);
        } else {
            if (data) alert(data);
        }
    });
}

function zvolenySubor() {
    $(document).on('change', ':file', function () {
        var vstup = $(this),
            subor = vstup.get(0).files ? vstup.get(0).files.length : 1,
            nazov = vstup.val().replace(/\\/g, '/').replace(/.*\//, '');
        vstup.trigger('fileselect', [subor, nazov]);
    });
}

function implementaciaMapy(adresa) {
    var poziadavka;
    if (window.XMLHttpRequest) {
        poziadavka = new XMLHttpRequest();
    } else {
        poziadavka = new ActiveXObject("Microsoft.XMLHTTP");
    }
    poziadavka.open('GET', adresa, false);
    poziadavka.send();
    return poziadavka.status !== 404;
}

function zoznamMiestOkresov(prvok, vysledok, subor) {
    $.ajaxSetup({cache: false});
    $(prvok).keyup(function () {
        $(vysledok).html('');
        var vstup = $(prvok).val();
        var vyraz = new RegExp(vstup, "i");
        $.getJSON(window.location.origin + "/udalosti/assets/json/" + subor, function (udaje) {
            $.each(udaje, function (kluc, hodnota) {
                if (hodnota.name.search(vyraz) != -1) {
                    $(vysledok).append('<li class="list-group-item okres-mesta-obce-odpoved">' + hodnota.name + '</span></li>');
                }
            });
        });
    });

    $(vysledok).on('click', 'li', function () {
        var zvolenyPrvok = $(this).text().split('|');
        $(prvok).val($.trim(zvolenyPrvok[0]));
        $(vysledok).html('');
    });
}