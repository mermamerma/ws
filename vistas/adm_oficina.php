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
DEFINE("MODULO", "adm_oficina");   // NOMBRE DEL ARCHIVO PARA COMPLETAR EL URL

DEFINE("MAX_REG_PAGINA", $lib->_lib_MAX_REG_PAGINA - 5);    // CANTIDAD DE REGISTROS POR PAGINA
DEFINE("TITULO", strtoupper('ADMINISTRADOR DE OFICINAS'));
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
        <script type="text/javascript">
            function test() {
                var datalist = document.getElementById("dl");
                var item = document.createElement('option');
                var d = $('#dia').numberbox('getValue');
                var m = $('#mes').numberbox('getValue');
                var value = m + "-" + d;
                item.text = value;
                datalist.add(item);
                $('#dia').numberbox('setValue').value = '';
                $('#mes').numberbox('setValue').value = '';
            }

            $(function () {
                $('#dg').edatagrid({
                    url: 'crud_oficinas.php?param=1',
                    saveUrl: 'crud_oficinas.php?param=2',
                    updateUrl: 'crud_oficinas.php?param=3',
                    destroyUrl: 'crud_oficinas.php?param=4'
                });
            });


        </script>

    </head>

    <body class="body">

        <?php $lib->setTablaPrincipal(); ?>
        <?php $lib->setEncabezado(); ?>
        <?php $lib->setIrA_menu(); ?>

    <tr><td>
            <div align="center">
                <table id="dg" title="Administrar Oficinas" style="width:900px;height:380px"
                       toolbar="#toolbar" data-options="
                       rownumbers:true,
                       singleSelect:true,
                       autoRowHeight:false,
                       pagination:true,
                       pageSize:10">
                    <thead>
                        <tr>

                            <th field="nombre" width="20%" editor="{type:'validatebox',options:{required:true}}">Oficina</th>
                            <th field="direccion" width="20%" editor="{type:'validatebox',options:{required:true}}">Direccion</th>
                            <th field="telefono" width="10%" editor="text">Telefono</th>
                            <th field="correo" width="20%" editor="{type:'validatebox',options:{validType:'email'}}">Correo</th>
                            <th field="nombre_contacto" width="15%" editor="{type:'validatebox',options:{required:true}}">Contacto</th>
                            <th field="estatus" width="5%" align="center" editor="{type:'image'}">Status</th>

                        </tr>
                    </thead>

                </table>
                <div id="toolbar">
                    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">Agregar</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Actualizar</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancelar</a>

                </div>

        </td></tr>
</table>

<div id="w" class="easyui-window" title="Habilitar Oficina" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,closable:false" style="width:100%;height:500px;padding:10px;">

    <div style="margin:20px 0;"></div>
    <form id="ff" method="post">
        <div class="easyui-panel" title="Informacion Geografica" style="width:100%">
            <div style="padding:10px 60px 20px 60px">

                <table cellpadding="5">
                    <tr>
                        <td>Estado:</td>
                        <td>
                            <select  name="estado" id="estado" >
                                <option value="1">Seleccione una opcion</option>
                                <?php foreach ($oficinaControl->listarGeograficoCombo() as $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['nombre']; ?></option>
                                <?php }; ?>

                            </select>
                        </td>
                        <td>Municipio:</td>
                        <td>
                            <select  name="municipio" id="municipio">
                                <option value="1">Seleccione una opcion</option>


                            </select>
                        </td>
                        <td>Parroquia:</td>
                        <td>
                            <select  name="parroquia" id="parroquia">
                                <option value="1">Seleccione una opcion</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Cantidad de citas para titulares:</td>
                        <td><input class="easyui-numberbox" type="text" name="cant_citas_tit" id="cant_citas_tit" data-options="required:true" style="width:60px"></input></td>
                        <td>Cantidad de citas para apoderados:</td>
                        <td><input class="easyui-numberbox" type="text" name="cant_citas_apo" id="cant_citas_apo" data-options="required:true"  style="width:60px"></input></td>
                        <td>Clave web:</td>
                        <td><input class="easyui-textbox" type="text" name="claveweb" id="claveweb" data-options="required:true"></input></td>

                    </tr>
                    <tr>
                        <td>Cantidad de taquillas para titulares:</td>
                        <td><input class="easyui-numberbox" type="text" name="cant_taq_tit" id="cant_taq_tit" data-options="required:true" style="width:60px"></input></td>
                        <td>Cantidad de taquillas para apoderados:</td>
                        <td><input class="easyui-numberbox" type="text" name="cant_taq_apo" id="cant_taq_apo" data-options="required:true" style="width:60px"></input></td>
                        <td>Texto en pantalla:</td>
                        <td><input class="easyui-textbox" type="text" name="pantallatexto" id="pantallatexto" value="TAQ." data-options="required:true"></input></td>
                    </tr>
                    <tr>
                        <td>
                            <h2>Ingrese día y mes feriado</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Dia <input class="easyui-numberbox" name="dia" id="dia" data-options="min:1,max:31,required:true" style="width:40px"> Mes
                            <input class="easyui-numberbox" name="mes" id="mes" data-options="min:1,max:12,required:true" style="width:40px">
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="test()">Agregar</a>
                        </td>
                        <td>
                            <h3>Dias Feriados</h3>
                            <select id="dl" size="6">

                            </select>

                        </td>
                        <td style="width:180px">Activar:
                            <input class="easyui-switchbutton" id="estatus" name="estatus"></td>
                    </tr>
                    <tr>
                        <td>
                            Ingrese el horario de atencion al publico ej.(00:00 am - 00:00 am):
                        </td>
                        <td>
                            <input class="easyui-textbox" type="text" name="horario1" id="horario1" value="07:00 am - 10:00 am" data-options="required:true"></input>
                        </td>
                    </tr>
                </table>
                <div style="text-align:center;padding:5px">
                    <input type="hidden" id="id_oficina" name="id_oficina">
                    <a href="javascript:void(0)" id="agregar" class="easyui-linkbutton" onclick="submitForm()">Agregar</a>
                   <!-- <a href="javascript:void(0)" id="limpiar" class="easyui-linkbutton" onclick="clearForm()">Limpiar</a> -->
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="setTimeout(function () {
                        location.reload();
                    }, 1000);">Cerrar</a>
                </div>
            </div>
        </div>
    </form>

    <script>
        function submitForm() {
            var estado = jQuery('#estado').val();
            var municipio = jQuery('#municipio').val();
            var parroquia = jQuery('#parroquia').val();
            var id_oficina = jQuery('#id_oficina').val();
            var cant_citas_tit = jQuery('#cant_citas_tit').val();
            var cant_citas_apo = jQuery('#cant_citas_apo').val();
            var claveweb = jQuery('#claveweb').val();
            var cant_taq_tit = jQuery('#cant_taq_tit').val();
            var cant_taq_apo = jQuery('#cant_taq_apo').val();
            var pantallatexto = jQuery('#pantallatexto').val();
            var estatus = jQuery('#estatus').val();
            var horario1 = jQuery('#horario1').val();
            var feriados = [];

            jQuery("#dl option").each(function () {
                feriados.push($(this).text());
//                alert(feriados);
            });

//            alert(id_oficina);
            if (estado > 1 && municipio > 1 && parroquia > 1) {
                $.get("crud_oficinas.php", {param: "4", id_oficina: id_oficina, parroquia: parroquia,
                    cant_citas_tit: cant_citas_tit, cant_citas_apo: cant_citas_apo, claveweb: claveweb, cant_taq_tit: cant_taq_tit,
                    cant_taq_apo: cant_taq_apo, pantallatexto: pantallatexto, feriados: feriados, estatus: estatus, horario1: horario1},
                function (resultado) {
                    if (resultado == false)
                    {
                        alert("Fallo en los datos de Configuracion de la Oficina");

                    }
                    else
                    {
//                      jQuery('#w').window('close');
                        location.reload();

                    }
                });
            } else {
                alert("Ingrese el Estado, Municipio y la Parroquia.");
            }

        }
        function clearForm() {
            jQuery('#ff').form('clear');

        }
    </script>

</div>

</body>
</html>

