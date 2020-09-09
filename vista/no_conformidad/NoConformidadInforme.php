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
            this.crearFormResponsableNC();
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
            this.ventanaResponsable.show();
        },
        crearFormResponsableNC:function(){
            // Peticion ajax al metodo controlador
            var storeCombo = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/NoConformidad/listarFuncionariosUO',
                id: 'id_funcionario',
                root: 'datos',
                sortInfo:{
                    field: 'desc_funcionario',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_funcionario','desc_funcionario','desc_funcionario_cargo'],
                remoteSort: true,
                baseParams: {par_filtro: 'vfc.desc_funcionario1 '}
            });

            var combo = new Ext.form.ComboBox({
                name:'id_funcionario_nc',
                fieldLabel:'Responsable de No Conformidad',
                allowBlank : false,
                typeAhead: true,
                store: storeCombo,
                mode: 'remote',
                pageSize: 15,
                triggerAction: 'all',
                valueField : 'id_funcionario',
                displayField : 'desc_funcionario',
                forceSelection: true,
                allowBlank : false,
                anchor: '100%',
                resizable : true,
                enableMultiSelect: false
            });
            this.formAuto = new Ext.form.FormPanel({
                baseCls: 'x-plain',
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                items: [combo]
            });
            this.ventanaResponsable = new Ext.Window({
                title: 'Configuracion',
                collapsible: true,
                maximizable: true,
                autoDestroy: true,
                width: 380,
                height: 170,
                layout: 'fit',
                plain: true,
                bodyStyle: 'padding:5px;',
                buttonAlign: 'center',
                items: this.formAuto,
                modal:true,
                closeAction: 'hide',
                buttons: [{
                    text: 'Guardar',
                    handler: this.saveResponsable,
                    scope: this},
                    {
                        text: 'Cancelar',
                        handler: function(){ this.ventanaResponsable.hide() },
                        scope: this
                    }]
            });
            this.cmpResponsable = this.formAuto.getForm().findField('id_funcionario_nc');
        },

        saveResponsable: function(){
            var d = this.getSelectedData();
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/asignarFuncRespNC',
                params: {
                    id_nc: d.id_nc,
                    id_funcionario_nc: this.cmpResponsable.getValue()
                },
                success: this.successWizard,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },

        successWizard:function(resp){
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            if(!reg.ROOT.error){
                if(this.ventanaResponsable){
                    this.ventanaResponsable.hide();
                }
                Phx.CP.loadingHide();
                this.reload();
            }else{
                alert("Error no se no se registro el funcionario")
            }

        },

    };
</script>
