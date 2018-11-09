$( document ).ready(function() {

    $("#zabudnute_heslo").click(function () {
        if ( $( "#email_zabudnute" ).is( ":hidden" ) ) {
            $( "#email_prihlasenie" ).hide();
            $( "#heslo" ).hide();
            $( "#prihlasenie" ).hide();

            $( "#registracia" ).hide();
            $( "#oddelovac" ).hide();

            $("#zabudnute_heslo").text("Späť na prihlásenie");

            $( "#email_zabudnute" ).slideDown( "slow" );
            $( "#poslat" ).slideDown( "slow" );
        } else {
            $( "#email_zabudnute" ).hide();
            $( "#poslat" ).hide();

            $( "#registracia" ).show();
            $( "#oddelovac" ).show();

            $("#zabudnute_heslo").text("Zabudnuté heslo");

            $( "#email_prihlasenie" ).slideDown( "slow" );
            $( "#heslo" ).slideDown( "slow" );
            $( "#prihlasenie" ).slideDown( "slow" );
        }
    });

    $("#registracia").click(function () {
        if ( $( "#registracia_meno" ).is( ":hidden" ) ) {
            $( "#email_prihlasenie" ).hide();
            $( "#heslo" ).hide();
            $( "#prihlasenie" ).hide();

            $( "#zabudnute_heslo" ).hide();
            $( "#oddelovac" ).hide();

            $("#registracia").text("Späť na prihlásenie");

            $( "#registracia_meno" ).slideDown( "slow" );
            $( "#registracia_email" ).slideDown( "slow" );
            $( "#registracia_heslo" ).slideDown( "slow" );
            $( "#registracia_potvrd" ).slideDown( "slow" );
            $( "#registrovat" ).slideDown( "slow" );
        } else {
            $( "#registracia_meno" ).hide();
            $( "#registracia_email" ).hide();
            $( "#registracia_heslo" ).hide();
            $( "#registracia_potvrd" ).hide();
            $( "#registrovat" ).hide();

            $( "#zabudnute_heslo" ).show();
            $( "#oddelovac" ).show();

            $("#registracia").text("Registrácia");

            $( "#email_prihlasenie" ).slideDown( "slow" );
            $( "#heslo" ).slideDown( "slow" );
            $( "#prihlasenie" ).slideDown( "slow" );
        }
    });

    function requestNaServer(e){
        var adresa = this.getAttribute("action");
        $.ajax({
            url: adresa,
            dataType: 'text',
            type: 'post',
            contentType: 'application/x-www-form-urlencoded',
            data: $(this).serialize(),
            success: function(data){

                if($( "#dialog" )){
                    $( "#dialog" ).remove();
                }

                $(".telo").append(data);
            }
        });
        e.preventDefault();
    }

    $('#telo_formulara_registracia').submit( requestNaServer );
    $('#telo_formulara_zabudnute_heslo').submit( requestNaServer );
    $('#telo_formulara_obnovenie_hesla').submit( requestNaServer );
});