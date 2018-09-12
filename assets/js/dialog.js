var identifikator = 0;

$(".zatvorit").click(function () {
    $( "#dialog" ).fadeOut()
});

$( ".odstranit" ).click(function() {
    identifikator = parseInt($(this).attr('id'));
});

$( "#udalost_dialog_vytvorit" ).click(function() {
    $( "#nova_udalost_formular" ).trigger( "submit" );
});

$( ".udalost_dialog_odstranit" ).click(function() {
    spracujData("/udalosti/index.php/udalosti/odstran_udalost/"+identifikator);
});

$("#nova_udalost_formular").on('submit',(function(e) {
    e.preventDefault();
    spracujData("/udalosti/index.php/udalosti/nova_udalost", this);
}));

function spracujData(adresa, _this) {
    $.ajax({
        url: window.location.origin+adresa,
        type: 'POST',
        data: new FormData(_this),
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
}