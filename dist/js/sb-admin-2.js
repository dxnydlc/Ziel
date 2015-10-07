var _servicio = '../php/servicios/proc-caja.php';
$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }

    $(document).ready(function(){
        /* ----------------------------------------------------------- */
        $('#abrirCaja').click(function(event) {
            // prompt dialog
            alertify.prompt("Ingrese monto de apertura de caja", function (e, str) {
                // str is the input text
                if (e) {
                    $.post( _servicio , {f:'abrir',monto:str, idu: _idUsuario} , function(data, textStatus, xhr) {
                        alertify.success('Se ha aperturado la caja');
                    },'json');
                } else {
                    // user clicked "cancel"
                }
            }, "0.0");
            event.preventDefault();
        });
        /* ----------------------------------------------------------- */
        $('#cerrarCaja').click(function(event) {
            // prompt dialog
            alertify.prompt("Ingrese monto de cierre de caja", function (e, str) {
                // str is the input text
                if (e) {
                    $.post( _servicio , {f:'cerrar',monto:str, idu: _idUsuario} , function(data, textStatus, xhr) {
                        alertify.error('Se ha cerrado la caja');
                    },'json');
                } else {
                    // user clicked "cancel"
                }
            }, "0.0");
            event.preventDefault();
        });
        /* ----------------------------------------------------------- */
    });

});
