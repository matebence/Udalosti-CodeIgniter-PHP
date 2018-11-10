$(document).ready(function () {
    $.ajax({
        url: window.location.origin + "/udalosti/index.php/panel/ziskaj_data",
        dataType: 'text',
        type: 'post',
        format: "json",
        data: {
            'panel': true
        },
        success: function (data) {
            var udaje = JSON.parse(data);

            if (data.length > 5000) {
                location.reload();
            } else if (udaje.length != 0) {
                kolacovyGraf(udaje);
                stlpcovyGrafOkres(udaje);
                stlpcovyGrafStat(udaje);
                ciarovyGraf(udaje);
                stlpcovyGrafZaujmy(udaje);
            } else {
                $(".grafUdalosti").html("<p>Databazá udalostí je prázdna</p>");
            }
        }
    });
});

function kolacovyGraf(udaje) {
    if (udaje.cennik == undefined) {
        $(".grafUdalosti").eq(0).html("<p>Databazá cien je prázdna</p>");
    }

    var spolu = 0;
    var pocet = new Array(udaje.cennik.length);
    var percenta = new Array(udaje.cennik.length);

    for (i = 0; i < udaje.cennik.length; i++) {
        pocet[i] = udaje.cennik[i].Pocet;
        spolu += parseInt(udaje.cennik[i].Pocet);
    }

    for (i = 0; i < udaje.cennik.length; i++) {
        percenta[i] = (parseInt(udaje.cennik[i].Pocet) / spolu) * 100;
        percenta[i] = Math.floor(percenta[i]) + "%"
    }

    var nastavenia = {
        series: [
            [25, 30, 20, 25]
        ]
    };

    var preferencie = {
        donut: true,
        donutWidth: 40,
        startAngle: 0,
        total: 100,
        showLabel: false,
        axisX: {
            showGrid: false
        }
    };

    Chartist.Pie('#kolacovyGraf', nastavenia, preferencie);
    Chartist.Pie('#kolacovyGraf', {
        labels: percenta,
        series: pocet
    });
}

function stlpcovyGrafOkres(udaje) {
    if (udaje.okres == undefined) {
        $(".grafUdalosti").eq(3).html("<p>Databazá udalostí je prázdna</p>");
    }

    var pocet = new Array(udaje.okres.length);
    var okres = new Array(udaje.okres.length);

    for (i = 0; i < udaje.okres.length; i++) {
        okres[i] = udaje.okres[i].okres;
        pocet[i] = udaje.okres[i].Pocet;
    }

    var nastavenia = {
        labels: okres,
        series: [
            pocet
        ]
    };

    var preferencie = {
        seriesBarDistance: 10,
        axisX: {
            showGrid: false
        },
        height: "245px"
    };

    var graf = [
        ['screen and (max-width: 640px)', {
            seriesBarDistance: 5
        }]
    ];

    Chartist.Bar('#stlpcovyGrafOkres', nastavenia, preferencie, graf);
}

function stlpcovyGrafStat(udaje) {
    if (udaje.stat == undefined) {
        $(".grafUdalosti").eq(4).html("<p>Databazá udalostí je prázdna</p>");
    }

    var pocet = new Array(udaje.stat.length);
    var stat = new Array(udaje.stat.length);

    for (i = 0; i < udaje.stat.length; i++) {
        stat[i] = udaje.stat[i].stat;
        pocet[i] = udaje.stat[i].Pocet;
    }

    var nastavenia = {
        labels: stat,
        series: [
            pocet
        ]
    };

    var preferencie = {
        seriesBarDistance: 10,
        axisX: {
            showGrid: false
        },
        height: "245px"
    };

    var graf = [
        ['screen and (max-width: 640px)', {
            seriesBarDistance: 5
        }]
    ];

    Chartist.Bar('#stlpcovyGrafStat', nastavenia, preferencie, graf);
}

function stlpcovyGrafZaujmy(udaje) {
    if (udaje.zaujmy == undefined) {
        $(".grafUdalosti").eq(1).html("<p>Databazá záujmov je prázdna</p>");
    }

    var pocet = new Array(udaje.zaujmy.length);
    var udalost = new Array(udaje.zaujmy.length);

    for (i = 0; i < udaje.zaujmy.length; i++) {
        udalost[i] = udaje.zaujmy[i].nazov;
        pocet[i] = udaje.zaujmy[i].pocet;
    }

    var nastavenia = {
        labels: udalost,
        series: [
            pocet
        ]
    };

    var preferencie = {
        seriesBarDistance: 10,
        axisX: {
            showGrid: false
        },
        height: "245px"
    };

    var graf = [
        ['screen and (max-width: 640px)', {
            seriesBarDistance: 5
        }]
    ];

    Chartist.Bar('#stlpcovyGrafZaujmy', nastavenia, preferencie, graf);
}

function ciarovyGraf(udaje) {
    if (udaje.mesiac == undefined) {
        $(".grafUdalosti").eq(2).html("<p>Databazá udalostí je prázdna</p>");
    }

    var pocet = new Array(udaje.mesiac.length);
    var mesiac = new Array(udaje.mesiac.length);

    for (i = 0; i < udaje.mesiac.length; i++) {
        mesiac[i] = udaje.mesiac[i].Mesiac;
        pocet[i] = udaje.mesiac[i].Pocet;
    }

    var nastavenia = {
        labels: mesiac,
        series: [
            pocet
        ]
    };

    //noinspection JSDuplicatedDeclaration
    var preferencie = {
        lineSmooth: false,
        low: 0,
        high: 30,
        showArea: true,
        height: "245px",
        axisX: {
            showGrid: false
        },
        lineSmooth: Chartist.Interpolation.simple({
            divisor: 3
        }),
        showLine: false,
        showPoint: false
    };

    var graf = [
        ['screen and (max-width: 640px)', {}]
    ];

    Chartist.Line('#ciarovyGraf', nastavenia, preferencie, graf);
}