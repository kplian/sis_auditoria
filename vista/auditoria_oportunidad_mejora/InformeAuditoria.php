<?php
/**
 *@package pXP
 *@file InformeAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.InformeAuditoria = {
    bedit:false,
    bnew:false,
    bsave:false,
    bdel:false,

    require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
    requireclase:'Phx.vista.AuditoriaOportunidadMejora',
    title:'AuditoriaOportunidadMejora',
    nombreVista: 'InformeAuditoria',

        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            Phx.vista.InformeAuditoria.superclass.constructor.call(this,config);
            this.recomendacionForm();
            this.store.baseParams.interfaz = this.nombreVista;
            this.addButton('btmReportr',
                {	text: 'Resumen',
                    iconCls: 'bpdf32',
                    disabled: true,
                    handler: this.onReporte,
                    tooltip: '<b>Resumen</b><br/>Resumen de la auditoria.'
                }
            );
            this.addButton('btmRecomendacion', {
                text:'Recomendacion',
                iconCls:'bballot',
                disabled:true,
                handler:this.onRecomendacion,
                tooltip:'<b>Recomendacion de Auditoria</b>'
            });
            this.addButton('btnNoConformidades', {
                text : 'No Conformidades',
                iconCls : 'bengineadd', /*'bballot','block','bgood','block', 'bengineadd' */
                disabled : true,
                handler : this.onNoConformidades,
                tooltip : '<b>Gestion de No conformidades</b>'
            });

            this.init();
            this.load({params:{start:0, limit:this.tam_pag}});

        },
        preparaMenu:function(n){
            var tb =this.tbar;
            Phx.vista.InformeAuditoria.superclass.preparaMenu.call(this,n);
            this.getBoton('sig_estado').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('btnObs').enable();
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('ant_estado').enable();
            this.getBoton('btmReportr').enable();
            this.getBoton('btmRecomendacion').enable();
            this.getBoton('btnNoConformidades').enable();
            return tb
        },
        liberaMenu:function(){
            var tb = Phx.vista.InformeAuditoria.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('sig_estado').disable();
                this.getBoton('btnChequeoDocumentosWf').disable();
                this.getBoton('btnObs').disable();
                this.getBoton('diagrama_gantt').disable();
                this.getBoton('ant_estado').disable();
                this.getBoton('btmReportr').disable();
                this.getBoton('btmRecomendacion').disable();
                this.getBoton('btnNoConformidades').disable();
            }
            return tb
        },
        onReporte:function () {
            var rec=this.sm.getSelected();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/reporteResumen',
                params:{'id_aom':rec.data.id_aom},
                success: this.successExport,
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
        },
        onRecomendacion:function () {
            var data = this.getSelectedData();
            if(data){
                this.cmpRecomendacion.setValue(data.recomendacion);
                this.ventanaRecomendacion.show();
            }
        },
        recomendacionForm:function () {
            var recomendacion = new Ext.form.TextArea({
                name: 'recomendacion',
                msgTarget: 'title',
                fieldLabel: 'Recomendacion',
                allowBlank: true,
                width:400,
                height:100
            });
            this.formRecomendacion = new Ext.form.FormPanel({
                baseCls: 'x-plain',
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                items: [recomendacion]
            });
            this.ventanaRecomendacion = new Ext.Window({
                title: 'Recomendacion de Auditoria',
                collapsible: true,
                maximizable: true,
                autoDestroy: true,
                width: 550,
                height: 200,
                layout: 'fit',
                plain: true,
                bodyStyle: 'padding:5px;',
                buttonAlign: 'center',
                items: this.formRecomendacion,
                modal:true,
                closeAction: 'hide',
                buttons: [{
                    text: 'Guardar',
                    handler: this.saveRecomendacion,
                    scope: this},
                    {
                        text: 'Cancelar',
                        handler: function(){ this.ventanaRecomendacion.hide() },
                        scope: this
                    }]
            });
            this.cmpRecomendacion = this.formRecomendacion.getForm().findField('recomendacion');
        },
        saveRecomendacion:function () {
            var d = this.getSelectedData();
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/insertSummary',
                params: {
                    id_aom: d.id_aom,
                    recomendacion: this.cmpRecomendacion.getValue()
                },
                success: this.successSincExtra,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        successSincExtra:function(resp){
            Phx.CP.loadingHide();
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            if(!reg.ROOT.error){
                if(this.ventanaRecomendacion){
                    this.ventanaRecomendacion.hide();
                }
                this.load({params: {start: 0, limit: this.tam_pag}});
            }else{
                alert('ocurrio un error durante el proceso')
            }
        },
        onNoConformidades:function () {
            var rec = this.sm.getSelected();
            Phx.CP.loadWindows('../../../sis_auditoria/vista/no_conformidad/NoConformidadGestion.php', 'Gestion No conformidades',{
                //modal : true,
                width:'90%',
                height:'90%'
            }, rec.data,this.idContenedor, 'NoConformidadGestion');
        },
        tabsouth:[
            {
                url:'../../../sis_auditoria/vista/destinatario/Destinatario.php',
                title:':: Destinatario(s)',
                height:'45%',
                width: '40%',
                cls:'Destinatario'
            }
        ]
    };
</script>
