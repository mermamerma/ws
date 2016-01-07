<?php
include("../include/inc_sesion_existe.phtml");
//include ('../clases/controlador/OficinaControl.php');
//*-------------------------------------------------------
//*  INCLUYE LA RUTINA DE CONEXION Y FUNCIONES VARIAS
//*-------------------------------------------------------
include('../clases/class.php');     // Objeto de Conexion
include("../funciones/funciones.php");   // Depurador
//*-------------------------------------------------------
//*  DEFINICION DE CONSTANTES
//*-------------------------------------------------------
DEFINE("MODULO", "adm_parametrosweb");   // NOMBRE DEL ARCHIVO PARA COMPLETAR EL URL

DEFINE("MAX_REG_PAGINA", $lib->_lib_MAX_REG_PAGINA - 5);    // CANTIDAD DE REGISTROS POR PAGINA
DEFINE("TITULO", strtoupper('ADMINISTRACION DE PARAMETROS GENERALES'));
DEFINE("IR_A_ANTERIOR", "../menu/menu.php");
$oficinaControl = new OficinaControl();
$roles = new roles(MODULO);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title> <?= strtoupper($lib->_lib_Sistema) ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= $lib->_lib_charset ?>">
        <META HTTP-EQUIV="Refresh" CONTENT="<?= $lib->_lib_Refrescar ?>">
        <link href="../imagenes/mppre.ico" type="image/x-icon" rel="SHORTCUT ICON"/>
        <link href="../estilos/Estilos.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../vistas/css/easyui.css">
        <link rel="stylesheet" type="text/css" href="../vistas/css/icon.css">
        <link rel="stylesheet" type="text/css" href="../vistas/css/demo.css">
        <script type="text/javascript" src="../vistas/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="../vistas/js/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="../vistas/js/jquery.edatagrid.js"></script> 
        <script type="text/javascript" src="../vistas/js/custom.js"></script>


    </head>

    <body class="body">

        <?php $lib->setTablaPrincipal(); ?>
        <?php $lib->setEncabezado(); ?>


    <tr><td>


            <div style="margin:20px 0;"></div>
            <form id="ff" method="post">
                <div class="easyui-panel" title="Administracion de parametros Generales" style="width:100%">
                    <div style="padding:10px 60px 20px 60px">

                        <table cellpadding="5">
                            <tr>
                                <td>Horario:</td>
                                <td><input class="easyui-textbox" type="text" name="horario" id="horario" data-options="required:true"></input></td>
                                <td>Dia de la semana donde no se procesan citas:</td>
                                <td><input class="easyui-numberbox" type="text" name="dia_nocita" id="dia_no_cita" data-options="required:true" style="width:60px"></input></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Cant. Max Documentos Titular:</td>
                                <td><input class="easyui-numberbox" type="text" name="maxdoctitular" id="maxdoctitular" data-options="required:true" style="width:60px"></input></td>
                                <td>Cant. Max Documentos Apoderado:</td>
                                <td><input class="easyui-numberbox" type="text" name="maxdocapoderado" id="maxdocapoderado" data-options="required:true" style="width:60px"></input></td>
                                <td>Dias mostrar en pantalla:</td>
                                <td><input class="easyui-numberbox" type="text" name="diasmostrar" id="diasmostrar" data-options="required:true" style="width:60px"></input></td>                               

                            </tr>
                            <tr>
                                <td>Cantidad de dias Maximo:</td>
                                <td><input class="easyui-numberbox" type="text" name="diasmaximo" id="diasmaximo" data-options="required:true" style="width:60px"></input></td>
                                <td>Cantidad dias Recordatorio de citas:</td>
                                <td><input class="easyui-numberbox" type="text" name="dias_recordarcitas" id="dias_recordarcitas" data-options="required:true" style="width:60px"></input></td>
                                <td>Cant. Max Citas Apoderado:</td>
                                <td><input class="easyui-numberbox" type="text" name="maxcitas_porapoderado" id="maxcitas_porapoderado" data-options="required:true" style="width:60px"></input></td>
                                <td>Min Citas Titular:</td>
                                <td><input class="easyui-numberbox" type="text" name="mincitas_titular" id="mincitas_titular" data-options="required:true" style="width:60px"></input></td>
                                <td>Min Citas Apoderado:</td>
                                <td><input class="easyui-numberbox" type="text" name="mincitas_apoderado" id="mincitas_apoderado" data-options="required:true" style="width:60px"></input></td>

                            </tr>

                        </table>

                        <div style="text-align:center;padding:5px">
                            <input type="hidden" id="id_parametrosweb" name="id_parametrosweb">
                            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Submit</a>
                            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">Clear</a>
                        </div>
                    </div>
                </div>
            </form>

            <script>
                function submitForm() {
                    var id = jQuery('#id_parametrosweb').val();
                    var horario = jQuery('#horario').val();
                    var dia_nocita = jQuery('#dia_nocita').val();
                    var maxdoctitular = jQuery('#maxdoctitular').val();
                    var maxdocapoderado = jQuery('#maxdocapoderado').val();
                    var diasmostrar = jQuery('#diasmostrar').val();
                    var diasmaximo = jQuery('#diasmaximo').val();
                    var dias_recordarcitas = jQuery('#dias_recordarcitas').val();
                    var maxcitas_porapoderado = jQuery('#maxcitas_porapoderado').val();
                    var mincitas_titular = jQuery('#mincitas_titular').val();
                    var mincitas_apoderado = jQuery('#mincitas_apoderado').val();



                    //            alert(id_oficina);

                    $.get("crud_parametrosweb.php", {param: "1", id: id, horario: horario, dia_nocita: dia_nocita, maxdoctitular: maxdoctitular,
                        maxdocapoderado: maxdocapoderado, diasmostrar: diasmostrar, diasmaximo: diasmaximo, dias_recordarcitas: dias_recordarcitas,
                        maxcitas_porapoderado: maxcitas_porapoderado, mincitas_titular: mincitas_titular, mincitas_apoderado: mincitas_apoderado},
                    function (resultado) {
                        if (resultado == false)
                        {
                            alert("Fallo en los datos de Configuracion de la Oficina");

                        }
                        else
                        {
                            //                
                            //                        jQuery('#w').window('close');
                            location.reload();

                        }
                    });


                }
                function clearForm() {
                    jQuery('#ff').form('clear');
                }
            </script>

        </div>
    </td></tr>

</table>
</body>
</html>
