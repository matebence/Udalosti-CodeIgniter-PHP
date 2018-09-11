$(".zatvorit").click(function () {
    $( "#dialog" ).fadeOut()
});

$( "#udalost_dialog" ).click(function() {
    $( "#nova_udalost_formular" ).trigger( "submit" );
});

$("#nova_udalost_formular").on('submit',(function(e) {
    e.preventDefault();

    $.ajax({
        url: window.location.origin+"/udalosti/index.php/udalosti/nova_udalost",
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,

        success: function(data){
            var uspech = "uspech";

            if(data.substr(0,uspech.length) == uspech){
                setTimeout(function(){ location.reload(); }, 1500);
            }

            $(".modal").append(data);
        }
    });
}));