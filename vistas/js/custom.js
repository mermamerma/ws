jQuery(document).ready(function () {
    jQuery('#estado').change(function () {
        var id = jQuery('#estado').val();
        $.get("crud_general.php", {param: "1", id: id},
        function (resultado) {
            if (resultado == false)
            {

            }
            else
            {
//                jQuery.each(resultado,function (val){
//                    jQuery('#municipio').append("");
                jQuery('#municipio').empty().append(resultado);
                jQuery('#parroquia').empty().append("<option value=\"1\">Seleccione una opcion</option>");
//                });

            }
        });
    });

    jQuery('#municipio').change(function () {
        var id = jQuery('#municipio').val();
        $.get("crud_general.php", {param: "1", id: id},
        function (resultado) {
            if (resultado == false)
            {


            }
            else
            {
//                jQuery.each(resultado,function (val){
//                    jQuery('#municipio').append("");
                jQuery('#parroquia').empty().append(resultado);
                    jQuery('#oficina').empty().append("<option value=\"1\">Seleccione una opcion</option>");
//                });

            }
        });
    });
    
    jQuery('#parroquia').change(function () {
        var id = jQuery('#parroquia').val();
        $.get("crud_general.php", {param: "3", id: id},
        function (resultado) {
            if (resultado == false)
            {
            }
            else
            {
//                jQuery.each(resultado,function (val){
//                    jQuery('#municipio').append("");
                    jQuery('#oficina').empty().append(resultado);
                    jQuery('#taquilla').empty().append("<option value=\"1\">Seleccione una opcion</option>");
//                });                   
            }
        });
    });
    
     jQuery('#oficina').change(function () {
        var id = jQuery('#oficina').val();
        $.get("crud_general.php", {param: "4", id: id},
        function (resultado) {
            if (resultado == false)
            {
            }
            else
            {
                    jQuery('#taquilla').empty().append(resultado);                
            }
        });
    });
    
    
});

