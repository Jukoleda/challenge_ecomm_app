$(function(){
    
    $(document).on("submit", "#frmIngresar", function(e) {
            e.preventDefault();

            let usuario = $("#usuario").val();
            let clave = $("#clave").val();


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            

            $.post(`home/login`,{usuario: usuario, clave: clave}).done(function(data){
                console.log(data);
                if (!data.success) {
                    if(data.view) {
                        $("#resultadoGeneral").html(data.view);
                        $("#resultadoGeneral").removeClass("alert-success").addClass("alert-danger");
                        $("#resultadoGeneral").fadeTo(2000, 500).slideUp(1500, function() {
                            $("#resultadoGeneral").slideUp(3000);
                        });
                        return;
                    }
                    
                    $("#resultadoGeneral").html(Object.values(data.errors));
                    $("#resultadoGeneral").removeClass("alert-success").addClass("alert-danger");
                    $("#resultadoGeneral").fadeTo(2000, 500).slideUp(1500, function() {
                        $("#resultadoGeneral").slideUp(3000);
                    });
                    return;
                }

                window.location.replace(data.redirect);
              

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
                console.error('Response:', jqXHR.responseText);
            });
    });

});