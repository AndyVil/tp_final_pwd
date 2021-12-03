<?php
$Titulo = "Listar Menus";
require_once("../structure/headermenu.php");
$objControl = new AbmMenu();
$List_Menu = $objControl->buscar(null);
$combo = '<select class="easyui-combobox" id="idpadre" name="idpadre" label="Submenu de?:" labelPosition="top" style="width:90%;">
<option></option>';
foreach ($List_Menu as $objMenu) {
    $combo .= '<option value="' . $objMenu->getIdmenu() . '">' . $objMenu->getMenombre() . ':' . $objMenu->getMedescripcion() . '</option>';
}
$combo .= '</select>';
?>
<div class="p-2 mt-2 mb-2">
    <h2 class="text-center">Administración menu</h2>
    <table id="dg" title="Menu" class="easyui-datagrid" url="listar_menu.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idmenu" width="20">ID</th>
                <th field="menombre" width="90">Nombre</th>
                <th field="medescripcion" width="70">Descripcion</th>
                <th field="idpadre" width="30">ID padre</th>
                <th field="medeshabilitado" width="70">Deshabilitado</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMenu()">Nuevo
            Menu</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMenu()">Editar
            Menu</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyMenu()">Baja/Alta</a>
    </div>

    <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Menu Informacion</h3>
            <div style="margin-bottom:10px">
                <input name="menombre" id="menombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="medescripcion" id="medescripcion" class="easyui-textbox" required="true" label="Descripcion:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <?php
                echo $combo;
                ?>
            </div>

            <div>
                <input id="idmenu" name="idmenu" value="idmenu" type="hidden">
            </div>
            <!-- <div style="margin-bottom:10px">
                <input class="easyui-checkbox" name="medeshabilitado" value="medeshabilitado" label="Deshabilitado:"> 
                <input class="easyui-textbox" label="Deshabilitado:" labelPosition="top" style="width:100%;"> 
            </div> -->
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>

    <script type="text/javascript">
        var url;

        /* Nuevo */
        function newMenu() {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Menu');
            $('#fm').form('clear');
            url = 'alta_menu.php';
        }

        /* Editar */
        function editMenu() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Menu');
                $('#fm').form('load', row);
                url = 'edit_menu.php?accion=mod&idmenu=' + row.idmenu;
            }
        }

        /* Alert */
        function saveMenu() {
            //alert(" Accion");
            $('#fm').form('submit', {
                url: url,
                onSubmit: function() {
                    return $(this).form('validate');
                },
                success: function(result) {
                    var result = eval('(' + result + ')');

                    alert("Volvio Serviodr");
                    if (!result.respuesta) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {

                        $('#dlg').dialog('close'); // close the dialog
                        $('#dg').datagrid('reload'); // reload 
                    }
                }
            });
        }

        /* Borrar */
        function destroyMenu() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Seguro que desea eliminar el menu?', function(r) {
                    if (r) {
                        $.post('baja_menu.php?idmenu=' + row.idmenu, {
                                idmenu: row.id
                            },
                            function(result) {
                                alert("Volvio Serviodr");
                                if (result.respuesta) {

                                    $('#dg').datagrid('reload'); // reload the  data
                                } else {
                                    $.messager.show({ // show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            }, 'json');
                    }
                });
            }
        }
    </script>

    <?php

   require_once("../structure/footermenu.php");
    ?>