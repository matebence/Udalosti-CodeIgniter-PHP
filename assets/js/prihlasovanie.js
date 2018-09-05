$( document ).ready(function() {

    $("#zabudnute_heslo").click(function () {
        if ( $( "#email_zabudnute" ).is( ":hidden" ) ) {
            $( "#email_prihlasenie" ).hide();
            $( "#heslo" ).hide();
            $( "#prihlasenie" ).hide();

            $("#zabudnute_heslo").text("Späť na prihlásenie");

            $( "#email_zabudnute" ).slideDown( "slow" );
            $( "#poslat" ).slideDown( "slow" );
        } else {
            $( "#email_zabudnute" ).hide();
            $( "#poslat" ).hide();

            $("#zabudnute_heslo").text("Zabudliste heslo?");

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

    $('#telo_formulara_zabudnute_heslo').submit( requestNaServer );
    $('#telo_formulara_obnovenie_hesla').submit( requestNaServer );
});