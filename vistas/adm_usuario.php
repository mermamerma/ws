<?php
include("../include/inc_sesion_existe.phtml");

//include("../clases/controlador/OpcionControl.php");
//include("../clases/controlador/OficinaControl.php");
//*-------------------------------------------------------
//*  INCLUYE LA RUTINA DE CONEXION Y FUNCIONES VARIAS
//*-------------------------------------------------------
include('../clases/class.php');     // Objeto de Conexion
include("../funciones/funciones.php");   // Depurador
//*-------------------------------------------------------
//*  DEFINICION DE CONSTANTES
//*-------------------------------------------------------
DEFINE("MODULO", "apoderados");   // NOMBRE DEL ARCHIVO PARA COMPLETAR EL URL

DEFINE("MAX_REG_PAGINA", $lib->_lib_MAX_REG_PAGINA - 5);    // CANTIDAD DE REGISTROS POR PAGINA
DEFINE("TITULO", strtoupper('APODERADOS: CITAS PENDIENTES POR TITULAR'));
DEFINE("IR_A_ANTERIOR", "../menu/menu.php");

$usuarioControl = new UsuarioControl();
$oficinaControl = new OficinaControl();
//$opcionControl = new OpcionControl();
$rolControl = new RolControl();
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
        <link rel="stylesheet" type="text/css" href="../vistas/css/imagenes.css">
        <script type="text/javascript" src="../vistas/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="../vistas/js/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="../vistas/js/jquery.edatagrid.js"></script> 
        <script type="text/javascript" src="../vistas/js/datagrid-filter.js"></script> 
        <script type="text/javascript" src="../vistas/js/custom.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#dg').edatagrid({                    
                    url: 'crud_usuarios.php?param=1',
                    saveUrl: 'crud_usuarios.php?param=2',
                    updateUrl: 'crud_usuarios.php?param=3'
                });
            });
        </script>
        
            <script>
        (function($){
            function pagerFilter(data){
                if ($.isArray(data)){    // is array
                    data = {
                        total: data.length,
                        rows: data
                    }
                }
                var dg = $(this);
                var state = dg.data('datagrid');
                var opts = dg.datagrid('options');
                if (!state.allRows){
                    state.allRows = (data.rows);
                }
                var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
                var end = start + parseInt(opts.pageSize);
                data.rows = $.extend(true,[],state.allRows.slice(start, end));
                return data;
            }
            
            var loadDataMethod = $.fn.datagrid.methods.loadData;
            $.extend($.fn.datagrid.methods, {
                clientPaging: function(jq){
                    return jq.each(function(){
                        var dg = $(this);
                        var state = dg.data('datagrid');
                        var opts = state.options;
                        opts.loadFilter = pagerFilter;
                        var onBeforeLoad = opts.onBeforeLoad;
                        opts.onBeforeLoad = function(param){
                            state.allRows = null;
                            return onBeforeLoad.call(this, param);
                        }
                        dg.datagrid('getPager').pagination({
                            onSelectPage:function(pageNum, pageSize){
                                opts.pageNumber = pageNum;
                                opts.pageSize = pageSize;
                                $(this).pagination('refresh',{
                                    pageNumber:pageNum,
                                    pageSize:pageSize
                                });
                                dg.datagrid('loadData',state.allRows);
                            }
                        });
                        $(this).datagrid('loadData', state.data);
                        if (opts.url){
                            $(this).datagrid('reload');
                        }
                    });
                },
                loadData: function(jq, data){
                    jq.each(function(){
                        $(this).data('datagrid').allRows = null;
                    });
                    return loadDataMethod.call($.fn.datagrid.methods, jq, data);
                },
                getAllRows: function(jq){
                    return jq.data('datagrid').allRows;
                }
            })
        })(jQuery);
 
        $(function(){
            //$('#dg')./*datagrid({data:getData()}).*/datagrid('clientPaging');
            $('#dg').datagrid('clientPaging');
        });
        
        /*
        $(function(){
            var dg = $('#dg').datagrid();            
            dg.datagrid('enableFilter');
        });  */    
    </script>
        
    </head>

    <body class="body">

        <?php $lib->setTablaPrincipal(); ?>
        <?php $lib->setEncabezado(); ?>
        <?php $lib->setIrA_menu(); ?>

    <tr><td>
            <div align="center">
            <table id="dg" title="Administrar Usuarios" style="width:900px;height:380px"
                toolbar="#toolbar" data-options="
                rownumbers:true,
                singleSelect:true,
                autoRowHeight:false,
                pagination:true,
                pageSize:50">
                <thead>
                    <tr>
                        <th data-options="field:'usuario'" width="10%" editor="{type:'validatebox',options:{required:true}}">Usuario</th>
                        <th data-options="field:'id_taquilla'" width="10%" editor="{type:'image'}">Taquilla</th>
                        <th data-options="field:'nivel'" width="10%" editor="{type:'image'}">Nivel</th>
                        <th field="nombre" width="10%" editor="{type:'validatebox',options:{required:true}}">Nombre</th>
                        <th field="apellido" width="10%" editor="{type:'validatebox',options:{required:true}}">Apellido</th>
                        <th field="oficina" width="10%" editor="{type:'image'}">Oficina</th>
                        <th field="fec_registro" width="10%" editor="{type:'image'}">Fec. Registro</th>
                        <th field="fec_ult_acceso" width="10%" editor="{type:'image'}">Fec. Ult. Acceso</th>
                        <th field="web" width="5%" editor="{type:'image',options:{required:true}}">Web</th>
                        <th field="inicial" width="5%" editor="{type:'validatebox',options:{required:true}}">Inicial</th>
                        <th field="activo" width="5%" editor="{type:'image'}">Activo</th>  
                        <th field="reset" width="5%" editor="{type:'image'}">Reset</th> 
                        <th field="estado" width="7%" editor="{type:'image'}">Estado</th>  
                        <th field="roles" width="5%" editor="{type:'image'}">Roles</th>                          
                    </tr>
                </thead>
                
            <div id="toolbar">
                <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">Agregar</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Actualizar</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancelar</a>
            </div>

        </td></tr>

    <?php //$lib->setPie(); ?>

</table>     

<div id="roles_usuario" align="center" class="easyui-window" title="Habilitar Roles" data-options="modal:true,closed:true" style="width:700px;height:500px;padding:10px;">

    <div style="margin:20px 0;"></div>
    <form id="roles" method="post">
        <div title="Informacion Roles" style="width:100%">
            <div style="padding:10px 80px 20px 80px">

                <div id="tabla_roles" style="text-align:center;padding:5px"></div>
                
                <div style="text-align:center;padding:5px">
                    <input type="hidden" id="id_usuario" name="id_usuario">
                    <input type="hidden" id="nivel" name="nivel">
                    <!--<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Aceptar</a>-->
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="GenerarForm()">Generar Roles</a>
                    <!--<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">Clear</a>-->
                </div>
            </div>
        </div>
    </form>
    <script>
        
        function GenerarForm() {
            $('#roles').form('submit');
            var id_usuario = jQuery('#id_usuario').val();
            //alert(id_usuario);
            
            $.get("crud_usuarios.php", {param: "9", id_usuario: id_usuario},
                function (resultado) {
                    if (resultado == false)
                    {
                        alert("Los roles no fueron generados");
                    }
                    else
                    {
                        alert("Los roles fueron asignados");
                        location.reload();
                    }
                });
            
            
        }
        
    </script>
</div>                
                
<div id="datos_usuario" class="easyui-window" title="Habilitar o Actualizar Usuario" data-options="modal:true,closed:true" style="width:700px;height:500px;padding:10px;">

    <div style="margin:20px;"></div>
    <form id="usuario" method="post">
        <div class="easyui-panel" title="Informacion Usuario" style="width:100%">
            <div style="padding:10px 80px 20px 80px">

               <table cellpadding="5">
                    <tr>
                        <td>Estados:</td>
                        <td>
                            <select  name="estado" id="estado" >
                                <option value="1">Seleccione un estado</option>
                                <?php foreach ($oficinaControl->listarGeograficoOficinasActivas() as $value) { ?>
                                    <option value="<?php echo $value['cod_estado']; ?>"><?php echo $value['estado']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>Municipios:</td>
                        <td>
                            <select name="municipio" id="municipio">
                                <option value="1">Seleccione un municipio</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Parroquia:</td>
                        <td>
                            <select  name="parroquia" id="parroquia">
                                <option value="1">Seleccione una opcion</option>
                            </select>
                        </td>
                                                
                        <td>Oficinas:</td>
                        <td>
                            <select name="oficina" id="oficina">
                                <option value="1">Seleccione una oficina</option>
                            </select>
                        </td>                        
                    </tr>
                     <tr>
                        <td>Nivel:</td>
                        <td>
                            <select name="nivelusuario" id="nivelusuario">
                                <option value="-1">Seleccione un nivel</option>
                                <?php foreach ($rolControl->listarRoles() as $value => $valor) { ?>
                                    <option value="<?php echo $valor->getID(); ?>"><?php echo $valor->getDESCRIPCION(); ?></option>
                                <?php }; ?>
                            </select>
                        </td>                        
                        <td>WEB:</td>
                        <td>
                            <select name="web" id="web">                                
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </td>
                     </tr>
                     <tr>
                        <td>Taquillas:</td>
                        <td>
                            <select name="taquilla" id="taquilla">
                                <option value="-1">Seleccione una taquilla</option>                               
                            </select>
                        </td>
                     </tr>
                </table>

                <div style="text-align:center;padding:5px">
                    <input type="hidden" id="id_usuario" name="id_usuario">
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Agregar</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">Limpiar</a>
                </div>
            </div>
        </div>
    </form>
    <script>
        function submitForm() {
            $('#usuario').form('submit');
            var estado = document.getElementById('estado').value;
            var municipio = document.getElementById('municipio').value;
            var parroquia = document.getElementById('parroquia').value;
            var oficina = document.getElementById('oficina').value;
            var nivel = document.getElementById('nivelusuario').value;
            var web = document.getElementById('web').value;
            var taquilla = document.getElementById('taquilla').value;
            var id_usuario = jQuery('#id_usuario').val();
            var activo = 'S';
            
//            alert("la puta que la pario "+ nivel);
//            alert(estado +' '+  municipio +' '+ parroquia +' '+ oficina +' '+ nivel +' '+ taquilla+' '+ id_usuario);
            
            if(estado > 1 && municipio > 1 && parroquia > 1 && oficina > 0 && nivel > 0 && taquilla > 0)
            {                
                $.get("crud_usuarios.php", {param: "7", id_usuario: id_usuario, taquilla: taquilla,
                    web: web, nivel: nivel, oficina: oficina, activo: activo},
                function (resultado) {
                    if (resultado == false)
                    {
                        alert("El usuario no fue actualizado");
                    }
                    else
                    {
                        alert("El usuario fue actualizado y activado");
                        location.reload();
                    }
                });
            }
            else
            {
                alert("Todos los datos deben ser seleccionado");
            }                        
        }
        function clearForm() {
            $('#nivelusuario').empty();              
        }
    </script>
</div>      
              
</body>
</html>

