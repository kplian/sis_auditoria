<?php
/**
 *@package pXP
 *@file PlanificacionAOM.php
 *@author  Maximilimiano Camacho
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadInforme = {

        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'NoConformidad',
        nombreVista: 'NoConformidadInforme',
        bedit:false,
        bnew:false,
        bdel:false,
        dblclickEdit: false,
        constructor: function(config) {
            Phx.vista.NoConformidadInforme.superclass.constructor.call(this,config);
            this.getBoton('btnChequeoDocumentosWf').setVisible(false);

            this.init();
            this.grid.addListener('cellclick', this.oncellclick,this);
            this.addButton('btnAceptar', {
                text: 'Aceptar Todo',
                iconCls: 'bok',
                disabled: false,
                handler: this.onAceptar,
                tooltip: '<b>Aceptar toda las no conformidades...</b>',
                scope:this
            });
        },
        onReloadPage:function(m){
            this.maestro=m;
            this.store.baseParams = {id_aom: this.maestro.id_aom,interfaz : this.nombreVista};
            this.load({params:{start:0, limit:50}})
        },
        loadValoresIniciales: function () {
            Phx.vista.NoConformidadInforme.superclass.loadValoresIniciales.call(this);
            this.Cmp.id_aom.setValue(this.maestro.id_aom);
        },
        preparaMenu:function(n){
            const tb =this.tbar;
            Phx.vista.NoConformidadInforme.superclass.preparaMenu.call(this,n);
            this.getBoton('btnNoram').enable();
            return tb
        },
        liberaMenu:function(){
            const tb = Phx.vista.NoConformidadInforme.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('btnNoram').disable();
            }
            return tb
        },
        oncellclick : function(grid, rowIndex, columnIndex, e) {
            const record = this.store.getAt(rowIndex),
                fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name
            if (fieldName === 'revisar' || fieldName === 'rechazar')
                this.cambiarAsignacion(record,fieldName);
        },
        cambiarAsignacion: function(record,name){
            Phx.CP.loadingShow();
            var d = record.data;
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/aceptarNoConformidad',
                params:{ id_nc: d.id_nc, fieldName: name  },
                success: this.successRevision,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
            this.reload();
        },
        onAceptar:function () {
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/siTodoNoConformidad',
                params:{ id_aom: this.maestro.id_aom },
                success: this.successRevision,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
            this.reload();
        },
        successRevision: function(resp){
            Phx.CP.loadingHide();
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
        },
    };
</script>
