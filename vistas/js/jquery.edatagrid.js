/**
 * edatagrid - jQuery EasyUI
 * 
 * Licensed under the GPL:
 *   http://www.gnu.org/licenses/gpl.txt
 *
 * Copyright 2011-2015 www.jeasyui.com 
 * 
 * Dependencies:
 *   datagrid
 *   messager
 * 
 */
(function ($) {
    // var oldLoadDataMethod = $.fn.datagrid.methods.loadData;
    // $.fn.datagrid.methods.loadData = function(jq, data){
    // 	jq.each(function(){
    // 		$.data(this, 'datagrid').filterSource = null;
    // 	});
    // 	return oldLoadDataMethod.call($.fn.datagrid.methods, jq, data);
    // };



    var autoGrids = [];
    function setValueSelect(SelectId, Value) {
        SelectObject = document.getElementById(SelectId);
        for (index = 0; index < SelectObject.length; index++) {
            if (SelectObject[index].value == Value)
                SelectObject.selectedIndex = index;
        }
    }
    function checkAutoGrid() {
        autoGrids = $.grep(autoGrids, function (t) {
            return t.length && t.data('edatagrid');
        });
    }
    function saveAutoGrid(omit) {
        checkAutoGrid();
        $.map(autoGrids, function (t) {
            if (t[0] != $(omit)[0]) {
                t.edatagrid('saveRow');
            }
        });
        checkAutoGrid();
    }
    function addAutoGrid(dg) {
        checkAutoGrid();
        for (var i = 0; i < autoGrids.length; i++) {
            if ($(autoGrids[i])[0] == $(dg)[0]) {
                return;
            }
        }
        autoGrids.push($(dg));
    }
    function delAutoGrid(dg) {
        checkAutoGrid();
        autoGrids = $.grep(autoGrids, function (t) {
            return $(t)[0] != $(dg)[0];
        });
    }

    $(function () {
        $(document).unbind('.edatagrid').bind('mousedown.edatagrid', function (e) {
            var p = $(e.target).closest('div.datagrid-view,div.combo-panel,div.window,div.window-mask');
            if (p.length) {
                if (p.hasClass('datagrid-view')) {
                    saveAutoGrid(p.children('table'));
                }
                return;
            }
            saveAutoGrid();
        });


    });

    function buildGrid(target) {
        var opts = $.data(target, 'edatagrid').options;
        $(target).datagrid($.extend({}, opts, {
            onDblClickCell: function (index, field, value) {

                var row = opts.finder.getRow(this, index);

                if (row['usuario'])
                {

                    $.get("crud_usuarios.php", {param: "10", id_usuario: row['id']},
                    function (resultado) {
                        if (resultado == true)
                        {
                            location.reload();
                        }
                        else
                        {
                            var obj = jQuery.parseJSON(resultado);
                            //alert(resultado);
                            var id_oficina = obj[0]['OFICINA_ID'];
                            var id_nivel = obj[0]['NIVEL'];
                            var id_taquilla = obj[0]['ID_TAQUILLA'];
                            //alert(id_taquilla);
                            $.get("crud_oficinas.php", {param: "6", id_oficina: obj[0]['OFICINA_ID']},
                            function (resultado) {
                                if (resultado == false)
                                {
                                    alert("Esta oficina no esta completamente configurada");
                                }
                                else
                                {
                                    var obj = jQuery.parseJSON(resultado);
                                    var cod_parroquia = obj['OBJ_LOCALIDAD'][0]['cod_parroquia'];
                                    var parroquia = obj['OBJ_LOCALIDAD'][1]['parroquia'];
                                    var cod_municipio = obj['OBJ_LOCALIDAD'][2]['cod_municipio'];
                                    var municipio = obj['OBJ_LOCALIDAD'][3]['municipio'];
                                    var cod_estado = obj['OBJ_LOCALIDAD'][4]['cod_estado'];
                                    var estado = obj['OBJ_LOCALIDAD'][5]['estado'];

                                    jQuery('#taquilla').empty();
                                    jQuery('#taquilla').append('<option value="0" selected="selected">Seleccione una opcion</option>');
                                    jQuery.each(obj['LISTA_TAQUILLAS'], function (key, value) {
                                        if (id_taquilla == obj['LISTA_TAQUILLAS'][key]['ID'])
                                            jQuery('#taquilla').append('<option value="' + obj['LISTA_TAQUILLAS'][key]['ID'] + '" selected="selected">' + obj['LISTA_TAQUILLAS'][key]['DESCRIPCION'] + "" + obj['LISTA_TAQUILLAS'][key]['NU_TAQUILLA'] + '</option>');
                                        else
                                            jQuery('#taquilla').append('<option value="' + obj['LISTA_TAQUILLAS'][key]['ID'] + '">' + obj['LISTA_TAQUILLAS'][key]['DESCRIPCION'] + "" + obj['LISTA_TAQUILLAS'][key]['NU_TAQUILLA'] + '</option>');
                                    });

                                    setValueSelect("estado", cod_estado);
                                    jQuery('#municipio').append('<option value="' + cod_municipio + '" selected="selected">' + municipio + '</option>');
                                    jQuery('#parroquia').append('<option value="' + cod_parroquia + '" selected="selected">' + parroquia + '</option>');
                                    jQuery('#oficina').append('<option value="' + id_oficina + '" selected="selected">' + obj['NOMBRE'] + '</option>');
                                    setValueSelect("nivelusuario", id_nivel);

                                    if (row['web'] == 'SI')
                                        setValueSelect("web", 1);
                                    else
                                        setValueSelect("web", 0);



                                    jQuery('#id_usuario').val(row['id']);
                                    jQuery('#datos_usuario').window('open');
                                }
                            });

                        }
                    });

                } else {

                    $.get("crud_oficinas.php", {param: "6", id_oficina: row['id']},
                    function (resultado) {
                        if (resultado == false)
                        {
                            alert("Esta oficina no esta completamente configurada");

                        } else {
                            var obj = jQuery.parseJSON(resultado);

                            var cod_parroquia = obj['OBJ_LOCALIDAD'][0]['cod_parroquia'];
                            var parroquia = obj['OBJ_LOCALIDAD'][1]['parroquia'];
                            var cod_municipio = obj['OBJ_LOCALIDAD'][2]['cod_municipio'];
                            var municipio = obj['OBJ_LOCALIDAD'][3]['municipio'];
                            var cod_estado = obj['OBJ_LOCALIDAD'][4]['cod_estado'];
                            var estado = obj['OBJ_LOCALIDAD'][5]['estado'];

                            setValueSelect("estado", cod_estado);
                            jQuery('#municipio').append('<option value="' + cod_municipio + '" selected="selected">' + municipio + '</option>');
                            jQuery('#parroquia').append('<option value="' + cod_parroquia + '" selected="selected">' + parroquia + '</option>');
                            jQuery('#cant_citas_tit').numberbox('setValue', obj['OBJ_PARAMETROS']['CANT_CITAS_TIT']);
                            jQuery('#cant_citas_apo').numberbox('setValue', obj['OBJ_PARAMETROS']['CANT_CITAS_APO']);
                            jQuery('#claveweb').textbox('setValue', obj['OBJ_PARAMETROS']['CLAVEWEB']);
                            jQuery('#cant_taq_tit').numberbox('setValue', obj['OBJ_PARAMETROS']['CANT_TAQ_TIT']);
                            jQuery('#cant_taq_apo').numberbox('setValue', obj['OBJ_PARAMETROS']['CANT_TAQ_APO']);
                            jQuery('#horario1').textbox('setValue', obj['OBJ_PARAMETROS']['HORARIO1']);
                            if (obj['ESTATUS'])
                                jQuery('#estatus').switchbutton('check');
                            else
                                jQuery('#estatus').switchbutton('uncheck');

                            var datalist = document.getElementById("dl");

                            jQuery.each(obj['LISTA_FERIADOS'], function (item, value) {
                                var item = document.createElement('option');
                                item.text = value['FERIADO'];
                                datalist.add(item);


//                                alert("item2=" + item + " value2=" + value['FERIADO']);
                            });

                            /////////
                            jQuery("#estado").prop('disabled', 'disabled');
                            jQuery("#municipio").prop('disabled', 'disabled');
                            jQuery("#parroquia").prop('disabled', 'disabled', 'true');
                            jQuery('#id_oficina').val(row['id']);
                            jQuery('#estatus').switchbutton('disable');
                            alert("Recuerde que si cambia la distribucion de las taquillas, sera necesario reasignarlas nuevamente a los usuarios.");
                            jQuery('#w').window('open');
                        }
                    });

                }

                if (opts.editing) {
                    $(this).edatagrid('editRow', index);
                    focusEditor(target, field);
                }
                if (opts.onDblClickCell) {
                    opts.onDblClickCell.call(target, index, field, value);
                }
            },
            onClickCell: function (index, field, value) {

                var row = opts.finder.getRow(this, index);
                if (row['id'] > 0) {
                    if (field == "estatus") {

//                        alert(index + "--" + row['id'] + "--" + value);
                        $.get("crud_oficinas.php", {param: "-1", id_oficina: row['id']},
                        function (resultado) {
                            if (resultado == true)
                            {
                                location.reload();
                            }
                            else
                            {
                                
                                jQuery("#estado").removeAttr("disabled");
                                jQuery("#municipio").removeAttr("disabled");
                                jQuery("#parroquia").removeAttr("disabled");
//                                jQuery('#ff').form('clear');
                                jQuery('#id_oficina').val(row['id']);
                                jQuery('#estatus').switchbutton('disable');
                                setValueSelect("estado", 1);
                                setValueSelect("municipio", 1);
                                setValueSelect("parroquia", 1);
                                jQuery('#dl').empty();
                                jQuery('#w').window('open');
                            }
                        });


//                    $.w.window('open');
                    }
                    if (field == "reset") {

                        $.get("crud_usuarios.php", {param: 4, id_usuario: row['id'], usuario: row['usuario']},
                        function (resultado) {
                            if (resultado == false)
                            {
                                alert("La clave no ha sido actualizada");
                                //mensaje("Actualizar", "La clave a sido actualizada: 1234", 200, 400, true, "");
                            }
                            else
                            {
                                alert("La clave ha sido actualizada: 1234");
                                //mensaje("Actualizar", "La clave no ha sido actualizada", 200, 400, true, "");
                            }
                        });
                    }

                    if (field == "estado") {

                        $.get("crud_general.php", {param: "2", id_usuario: row['id'], estado: row['activo']},
                        function (resultado) {
                            if (resultado == false)
                            {
                                jQuery('#id_usuario').val(row['id']);
                                jQuery('#datos_usuario').window('open');
                            }
                            else
                            {
                                alert("La accion fue procesada");
                                location.reload();
                            }
                        });
                    }

                    if (field == "roles") {
                        jQuery('#id_usuario').val(row['id']);
                        jQuery('#id_nivel').val(row['nivel']);
                        $.get("crud_usuarios.php", {param: "8", id_usuario: row['id'], nivel: ['nivel']},
                        function (resultado) {
                            if (resultado == false)
                            {
                                alert("Los Roles no fueron listados");
                            }
                            else
                            {
                                //alert(resultado); 

                                jQuery('#tabla_roles').empty().append(resultado);
                                jQuery('#roles_usuario').window('open');
                            }
                        });

                    }
                }
                if (opts.editing && opts.editIndex >= 0) {
                    $(this).edatagrid('editRow', index);
                    focusEditor(target, field);
                }
                if (opts.onClickCell) {
                    opts.onClickCell.call(target, index, field, value);
                }
            },
            onBeforeEdit: function (index, row) {
                if (opts.onBeforeEdit) {
                    if (opts.onBeforeEdit.call(target, index, row) == false) {
                        return false;
                    }
                }
                if (opts.autoSave) {
                    addAutoGrid(this);
                }
                opts.originalRow = $.extend(true, [], row);
            },
            onAfterEdit: function (index, row) {
                delAutoGrid(this);
                opts.editIndex = -1;
                var url = row.isNewRecord ? opts.saveUrl : opts.updateUrl;
                if (url) {
                    var changed = false;
                    var fields = $(this).edatagrid('getColumnFields', true).concat($(this).edatagrid('getColumnFields'));
                    for (var i = 0; i < fields.length; i++) {
                        var field = fields[i];
                        var col = $(this).edatagrid('getColumnOption', field);
                        if (col.editor && opts.originalRow[field] != row[field]) {
                            changed = true;
                            break;
                        }
                    }
                    if (changed) {
                        $.post(url, row, function (data) {
                            if (data.isError) {
                                $(target).edatagrid('cancelRow', index);
                                $(target).edatagrid('selectRow', index);
                                $(target).edatagrid('editRow', index);
                                opts.onError.call(target, index, data);
                                return;
                            }
                            data.isNewRecord = null;
                            $(target).datagrid('updateRow', {
                                index: index,
                                row: data
                            });
                            if (opts.tree) {
                                var idValue = row[opts.idField || 'id'];
                                var t = $(opts.tree);
                                var node = t.tree('find', idValue);
                                if (node) {
                                    node.text = row[opts.treeTextField];
                                    t.tree('update', node);
                                } else {
                                    var pnode = t.tree('find', row[opts.treeParentField]);
                                    t.tree('append', {
                                        parent: (pnode ? pnode.target : null),
                                        data: [{id: idValue, text: row[opts.treeTextField]}]
                                    });
                                }
                            }
                            opts.onSuccess.call(target, index, row);
                            opts.onSave.call(target, index, row);
                        }, 'json');
                    } else {
                        opts.onSave.call(target, index, row);
                    }
                } else {
                    opts.onSave.call(target, index, row);
                }
                if (opts.onAfterEdit)
                    opts.onAfterEdit.call(target, index, row);
            },
            onCancelEdit: function (index, row) {
                delAutoGrid(this);
                opts.editIndex = -1;
                if (row.isNewRecord) {
                    $(this).datagrid('deleteRow', index);
                }
                if (opts.onCancelEdit)
                    opts.onCancelEdit.call(target, index, row);
            },
            onBeforeLoad: function (param) {
                if (opts.onBeforeLoad.call(target, param) == false) {
                    return false
                }
                $(this).edatagrid('cancelRow');
                if (opts.tree) {
                    var node = $(opts.tree).tree('getSelected');
                    param[opts.treeParentField] = node ? node.id : undefined;
                }
            }
        }));



        if (opts.tree) {
            $(opts.tree).tree({
                url: opts.treeUrl,
                onClick: function (node) {
                    $(target).datagrid('load');
                },
                onDrop: function (dest, source, point) {
                    var targetId = $(this).tree('getNode', dest).id;
                    $.ajax({
                        url: opts.treeDndUrl,
                        type: 'post',
                        data: {
                            id: source.id,
                            targetId: targetId,
                            point: point
                        },
                        dataType: 'json',
                        success: function () {
                            $(target).datagrid('load');
                        }
                    });
                }
            });
        }
    }

    function focusEditor(target, field) {
        var opts = $(target).edatagrid('options');
        var t;
        var editor = $(target).datagrid('getEditor', {index: opts.editIndex, field: field});
        if (editor) {
            t = editor.target;
        } else {
            var editors = $(target).datagrid('getEditors', opts.editIndex);
            if (editors.length) {
                t = editors[0].target;
            }
        }
        if (t) {
            if ($(t).hasClass('textbox-f')) {
                $(t).textbox('textbox').focus();
            } else {
                $(t).focus();
            }
        }
    }

    $.fn.edatagrid = function (options, param) {
        if (typeof options == 'string') {
            var method = $.fn.edatagrid.methods[options];
            if (method) {
                return method(this, param);
            } else {
                return this.datagrid(options, param);
            }
        }

        options = options || {};
        return this.each(function () {
            var state = $.data(this, 'edatagrid');
            if (state) {
                $.extend(state.options, options);
            } else {
                $.data(this, 'edatagrid', {
                    options: $.extend({}, $.fn.edatagrid.defaults, $.fn.edatagrid.parseOptions(this), options)
                });
            }
            buildGrid(this);
        });
    };

    $.fn.edatagrid.parseOptions = function (target) {
        return $.extend({}, $.fn.datagrid.parseOptions(target), {
        });
    };

    $.fn.edatagrid.methods = {
        options: function (jq) {
            var opts = $.data(jq[0], 'edatagrid').options;
            return opts;
        },
        loadData: function (jq, data) {
            return jq.each(function () {
                $(this).edatagrid('cancelRow');
                $(this).datagrid('loadData', data);
            });
        },
        enableEditing: function (jq) {
            return jq.each(function () {
                var opts = $.data(this, 'edatagrid').options;
                opts.editing = true;
            });
        },
        disableEditing: function (jq) {
            return jq.each(function () {
                var opts = $.data(this, 'edatagrid').options;
                opts.editing = false;
            });
        },
        isEditing: function (jq, index) {
            var opts = $.data(jq[0], 'edatagrid').options;
            var tr = opts.finder.getTr(jq[0], index);
            return tr.length && tr.hasClass('datagrid-row-editing');
        },
        editRow: function (jq, index) {
            return jq.each(function () {
                var dg = $(this);
                var opts = $.data(this, 'edatagrid').options;
                var editIndex = opts.editIndex;
                if (editIndex != index) {
                    if (dg.datagrid('validateRow', editIndex)) {
                        if (editIndex >= 0) {
                            if (opts.onBeforeSave.call(this, editIndex) == false) {
                                setTimeout(function () {
                                    dg.datagrid('selectRow', editIndex);
                                }, 0);
                                return;
                            }
                        }
                        dg.datagrid('endEdit', editIndex);
                        dg.datagrid('beginEdit', index);
                        if (!dg.edatagrid('isEditing', index)) {
                            return;
                        }
                        opts.editIndex = index;
                        focusEditor(this);

                        var rows = dg.datagrid('getRows');
                        opts.onEdit.call(this, index, rows[index]);
                    } else {
                        setTimeout(function () {
                            dg.datagrid('selectRow', editIndex);
                        }, 0);
                    }
                }
            });
        },
        addRow: function (jq, index) {
            return jq.each(function () {
                var dg = $(this);
                var opts = $.data(this, 'edatagrid').options;
                if (opts.editIndex >= 0) {
                    if (!dg.datagrid('validateRow', opts.editIndex)) {
                        dg.datagrid('selectRow', opts.editIndex);
                        return;
                    }
                    if (opts.onBeforeSave.call(this, opts.editIndex) == false) {
                        setTimeout(function () {
                            dg.datagrid('selectRow', opts.editIndex);
                        }, 0);
                        return;
                    }
                    dg.datagrid('endEdit', opts.editIndex);
                }
                var rows = dg.datagrid('getRows');

                function _add(index, row) {
                    if (index == undefined) {
                        dg.datagrid('appendRow', row);
                        opts.editIndex = rows.length - 1;
                    } else {
                        dg.datagrid('insertRow', {index: index, row: row});
                        opts.editIndex = index;
                    }
                }
                if (typeof index == 'object') {
                    _add(index.index, $.extend(index.row, {isNewRecord: true}))
                } else {
                    _add(index, {isNewRecord: true});
                }

//				if (index == undefined){
//					dg.datagrid('appendRow', {isNewRecord:true});
//					opts.editIndex = rows.length - 1;
//				} else {
//					dg.datagrid('insertRow', {
//						index: index,
//						row: {isNewRecord:true}
//					});
//					opts.editIndex = index;
//				}

                dg.datagrid('beginEdit', opts.editIndex);
                dg.datagrid('selectRow', opts.editIndex);

                if (opts.tree) {
                    var node = $(opts.tree).tree('getSelected');
                    rows[opts.editIndex][opts.treeParentField] = (node ? node.id : 0);
                }

                opts.onAdd.call(this, opts.editIndex, rows[opts.editIndex]);
            });
        },
        saveRow: function (jq) {
            return jq.each(function () {
                var dg = $(this);
                var opts = $.data(this, 'edatagrid').options;
                if (opts.editIndex >= 0) {
                    if (opts.onBeforeSave.call(this, opts.editIndex) == false) {
                        setTimeout(function () {
                            dg.datagrid('selectRow', opts.editIndex);
                        }, 0);
                        return;
                    }
                    $(this).datagrid('endEdit', opts.editIndex);
//                    location.reload();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            });
        },
        cancelRow: function (jq) {
            return jq.each(function () {
                var opts = $.data(this, 'edatagrid').options;
                if (opts.editIndex >= 0) {
                    $(this).datagrid('cancelEdit', opts.editIndex);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            });
        },
        destroyRow: function (jq, index) {
            return jq.each(function () {
                var dg = $(this);
                var opts = $.data(this, 'edatagrid').options;

                var rows = [];
                if (index == undefined) {
                    rows = dg.datagrid('getSelections');
                } else {
                    var rowIndexes = $.isArray(index) ? index : [index];
                    for (var i = 0; i < rowIndexes.length; i++) {
                        var row = opts.finder.getRow(this, rowIndexes[i]);
                        if (row) {
                            rows.push(row);
                        }
                    }
                }

                if (!rows.length) {
                    $.messager.show({
                        title: opts.destroyMsg.norecord.title,
                        msg: opts.destroyMsg.norecord.msg
                    });
                    return;
                }

                $.messager.confirm(opts.destroyMsg.confirm.title, opts.destroyMsg.confirm.msg, function (r) {
                    if (r) {
                        for (var i = 0; i < rows.length; i++) {
                            _del(rows[i]);
                        }
                        dg.datagrid('clearSelections');
                    }
                });

                function _del(row) {
                    var index = dg.datagrid('getRowIndex', row);
                    if (index == -1) {
                        return
                    }
                    if (row.isNewRecord) {
                        dg.datagrid('cancelEdit', index);
                    } else {
                        if (opts.destroyUrl) {
                            var idValue = row[opts.idField || 'id'];
                            $.post(opts.destroyUrl, {id: idValue}, function (data) {
                                var index = dg.datagrid('getRowIndex', idValue);
                                if (data.isError) {
                                    dg.datagrid('selectRow', index);
                                    opts.onError.call(dg[0], index, data);
                                    return;
                                }
                                if (opts.tree) {
                                    dg.datagrid('reload');
                                    var t = $(opts.tree);
                                    var node = t.tree('find', idValue);
                                    if (node) {
                                        t.tree('remove', node.target);
                                    }
                                } else {
                                    dg.datagrid('cancelEdit', index);
                                    dg.datagrid('deleteRow', index);
                                }
                                opts.onDestroy.call(dg[0], index, row);
                                var pager = dg.datagrid('getPager');
                                if (pager.length && !dg.datagrid('getRows').length) {
                                    dg.datagrid('options').pageNumber = pager.pagination('options').pageNumber;
                                    dg.datagrid('reload');
                                }
                            }, 'json');
                        } else {
                            dg.datagrid('cancelEdit', index);
                            dg.datagrid('deleteRow', index);
                            opts.onDestroy.call(dg[0], index, row);
                        }
                    }
                }
            });
        }
    };

    $.fn.edatagrid.defaults = $.extend({}, $.fn.datagrid.defaults, {
        singleSelect: true,
        editing: true,
        editIndex: -1,
        destroyMsg: {
            norecord: {
                title: 'Advertensia',
                msg: 'No ha seleccionado ningun registro.'
            },
            confirm: {
                title: 'Confirmacion',
                msg: 'Seguro que desa borrar este registro.'
            }
        },
//		destroyConfirmTitle: 'Confirm',
//		destroyConfirmMsg: 'Are you sure you want to delete?',

        autoSave: false, // auto save the editing row when click out of datagrid
        url: null, // return the datagrid data
        saveUrl: null, // return the added row
        updateUrl: null, // return the updated row
        destroyUrl: null, // return {success:true}

        tree: null, // the tree selector
        treeUrl: null, // return tree data
        treeDndUrl: null, // to process the drag and drop operation, return {success:true}
        treeTextField: 'name',
        treeParentField: 'parentId',
        onAdd: function (index, row) {
        },
        onEdit: function (index, row) {
        },
        onBeforeSave: function (index) {
        },
        onSave: function (index, row) {
        },
        onSuccess: function (index, row) {
        },
        onDestroy: function (index, row) {
        },
        onError: function (index, row) {
        }
    });

    ////////////////////////////////
    $.parser.plugins.push('edatagrid');
})(jQuery);
