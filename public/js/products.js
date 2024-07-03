$(function(){
    
    // $.ajax({
    //     method: "GET",
    //     url: `products/productsList/`,
    //     success: function (data) {
    //         console.log(data);
    //         $("#main").html(data);

    //     },
    //     error: function(error) {
    //         console.error(error);
    //     }
    // });
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    
    // $.post(`products/productsSearchPage`,{pagina: 1}).done(function(data){
    //     console.log(data);

    //     $("#main").html(data);

    // });
    $("#resultadoGeneral").hide();
    $("#resultadoModal").hide();


    getPageWithFilters(1);

    $(document).on("click", ".btnProductModif", function() {
        console.log($(this).data("productid"));
        $("#modalLabel").html("Editar producto");
        let productId = $(this).data("productid");
        $.ajax({
            method: "GET",
            url: `products/productEdit/${productId}`,
            success: function (data) {
                console.log(data);
                $("#modalBody").html(data);
                $("#modalOperation").modal("show");

            },
            error: function(error) {
                console.error(error);
            }
        })
    });



    $(document).on("click", "#deleteProduct", function() {

        console.log($(this).data("productid"));
        let productId = $(this).data("productid");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        

        $.ajax({
            method: "DELETE",
            url: `products/productDelete/${productId}`,
            success: function (data) {
                console.log(data);

                if (!data.success) {
                    $("#resultadoGeneral").html(data.errors);
                    $("#resultadoGeneral").removeClass("alert-success").addClass("alert-danger");
                    $("#resultadoGeneral").fadeTo(2000, 500).slideUp(1500, function() {
                        $("#resultadoGeneral").slideUp(3000);
                    });
                    return;
                }
                $("#resultadoGeneral").html((data.message));
                $("#resultadoGeneral").removeClass("alert-danger").addClass("alert-success");
                $("#resultadoGeneral").fadeTo(2000, 500).slideUp(1500, function() {
                    $("#resultadoGeneral").slideUp(3000);
                });

                let page = $("#page").val() ?  $("#page").val() : 1;
                getPageWithFilters(page);

                $("#modalConfirm").modal("hide");

            },
            error: function(error) {
                console.error(error);
            }
        })

    });
    $(document).on("click", ".btnProductRemove", function() {
        $("#modalConfirm").modal("show");
        $("#deleteProduct").data("productid", $(this).data("productid"));
    });

    $(document).on("click", "#btnNewProduct", function() {
        
        $("#modalLabel").html("Nuevo producto");

        $.ajax({
            method: "GET",
            url: `products/productCreate/`,
            success: function (data) {
                console.log(data);
                $("#modalBody").html(data);            
            
            },
            error: function(error) {
                console.error(error);
            }
        })
    });

    $(document).on("submit", "#frmCreateProduct", function(e) {
            e.preventDefault();
            let title = $("#title").val();
            let price = $("#price").val();


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            

            $.post(`products/createNew`,{titulo: title, precio: price}).done(function(data){
                console.log(data);
                if (!data.success) {
                    $("#resultadoModal").html((Object.values(data.errors)));
                    $("#resultadoModal").removeClass("alert-success").addClass("alert-danger");
                    $("#resultadoModal").fadeTo(2000, 500).slideUp(1500, function() {
                        $("#resultadoModal").slideUp(3000);
                    });
                    return;
                }
                $("#resultadoGeneral").html((data.message));
                $("#resultadoGeneral").removeClass("alert-danger").addClass("alert-success");
                $("#resultadoGeneral").fadeTo(2000, 500).slideUp(1500, function() {
                    $("#resultadoGeneral").slideUp(3000);
                });

                let page = $("#page").val() ?  $("#page").val() : 1;
                getPageWithFilters(page);
                $("#resultadoModal").html();
                $("#modalOperation").modal("hide");
            

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
                console.error('Response:', jqXHR.responseText);
            });
    });

    $(document).on("submit", "#frmUpdateProduct", function(e) {
            e.preventDefault();
            let id = $("#id").val();
            let title = $("#title").val();
            let price = $("#price").val();

            $("#modalOperation").modal("hide");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            

            $.post(`products/productUpdate`,{id: id, titulo: title, precio: price}).done(function(data){
                console.log(data);

                if (!data.success) {
                    $("#resultadoModal").html((Object.values(data.errors)));
                    $("#resultadoModal").removeClass("alert-success").addClass("alert-danger");
                    $("#resultadoModal").fadeTo(2000, 500).slideUp(1500, function() {
                        $("#resultadoModal").slideUp(3000);
                    });
                    return;
                }
                $("#resultadoGeneral").html((data.message));
                $("#resultadoGeneral").removeClass("alert-danger").addClass("alert-success");
                $("#resultadoGeneral").fadeTo(2000, 500).slideUp(1500, function() {
                    $("#resultadoGeneral").slideUp(3000);
                });


                let page = $("#page").val() ?  $("#page").val() : 1;
                getPageWithFilters(page);
                

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
                console.error('Response:', jqXHR.responseText);
            });
    });

    $(document).on("submit", "#frmSearch", function(e) {
            e.preventDefault();

            getPageWithFilters(1);

    });

    
   

});


function getPageWithFilters(page) {
    
    let tituloProducto = $("#tituloProducto").val();
    let precioMinimo = $("#precioMinimo").val();
    let precioMaximo = $("#precioMaximo").val();
    let fechaCreacion = $("#fechaCreacion").val();
    console.log(
        tituloProducto,
        precioMinimo,
precioMaximo,
fechaCreacion
    );

    let error = "";

    if (precioMinimo && precioMaximo) {
        if (precioMaximo < precioMinimo) {
            error += "El precio Hasta no puede ser menor que el precio Desde.";
        }
    }
    
    if (fechaCreacion > (new Date().toISOString().split("T")[0])) {
        error += "La fecha debe ser menor o igual a Hoy."; 
    }

    if (error.length > 0) {
        $("#resultadoGeneral").html(error);
        $("#resultadoGeneral").removeClass("alert-success").addClass("alert-danger");
        $("#resultadoGeneral").fadeTo(2000, 500).slideUp(1500, function() {
            $("#resultadoGeneral").slideUp(3000);
        });
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

    $.post(`products/productsSearchPage`,{titulo: tituloProducto, desde: precioMinimo, hasta: precioMaximo, fechaCreacion: fechaCreacion, pagina: page}).done(function(data){
        console.log(data);

        $("#main").html(data);


    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Error:', textStatus, errorThrown);
        console.error('Response:', jqXHR.responseText);
    });
}