// formulario MI CUENTA
$(function(){
    $('.mailSubmit').on('click',function(e) {

        e.preventDefault();
        var l = Ladda.create(this);
        l.start();

        var email = $(".emailInput").val(),
            validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;

        $(".error").hide();

        if(email === "" || !validacion_email.test(email)){
            $(".emailInput").focus();
            $(".emailInput").parent().append("<span class='error'>Ingresa un email válido</span>");
            l.stop();
            return false;
        }

        $('.loader').addClass('loaderShow');
        var datos = '&email=' + email ;

        setTimeout(function(){
            $.ajax({
                type: "POST",
                url: basePath + "../views/site/suscribete.php",
                data: datos,
                success: function() {
                    l.stop();
                    $('.loader').addClass('loaderComplete');
                    $('.msg').text('¡Suscripcción Exitosa!').addClass('msg_success');

                    //setTimeout(modalHideCuenta, 2000);
                    $("#formaDeSuscripccion")[0].reset();
                },
                error: function() {
                    $('.ajaxgif').hide();
                    $('.msg').text('¡Hubo un error!').addClass('msg_error');                 
                }
            });
        }, 100);

    });
})();

var modalHideCuenta = '';

modalHideCuenta = function(){
    $('#estadoCuenta').modal('hide');
    $('.msg').html('');
    $('.msg').removeClass('msg_error');
    $('.msg').removeClass('msg_ok');
};