<?php
/**
 *@package pXP
 *@file AccionesPropuestaPendientes.php
 *@author  MMV
 *@date 18-09-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AccionesPropuestaPendientes = {
        require:'../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php',
        requireclase:'Phx.vista.AccionPropuesta',
        nombreVista: 'AccionesPropuestaPendientes',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
       
        constructor: function(config) {  
            this.Atributos[this.getIndAtributo('implementar')].grid=false;
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            Phx.vista.AccionesPropuestaPendientes.superclass.constructor.call(this,config);
            this.getBoton('siguiente').setVisible(true);
            this.getBoton('atras').setVisible(true);
            this.getBoton('diagrama_gantt').setVisible(true);
            this.getBoton('btnChequeoDocumentosWf').setVisible(true);
            this.init();
        },
        onReloadPage:function(m){
            this.maestro=m;
            this.store.baseParams = {id_nc : this.maestro.id_nc, interfaz : this.nombreVista};
            this.load({params:{start:0, limit:50}});
        },
        loadValoresIniciales: function () {
            Phx.vista.AccionesPropuestaPendientes.superclass.loadValoresIniciales.call(this);
        },
        onButtonSiguiente:function () {
            const record = this.sm.getSelected().data;
            this.onResponsable(record ,'Aprobar', 'Aprobar Accion Propuesta por No Conformidad');
            this.ventanaResponsable.show();
        },
        onButtonAtras : function(res){
            const record = this.sm.getSelected().data;
            this.onResponsable(record, 'Rechazar', 'Rechazar Accion Propuesta por No Conformidad');
            this.ventanaResponsable.show();	
	    },
        onResponsable: function(record , btn, titulo ){

            console.log(record);
            const me = this;
            const informe =  {
                fieldLabel: 'Informe',
                xtype: 'box',
                autoEl: {
                    tag: 'a',
                    html: this.maestro.nombre_aom1,
                },
                style: 'cursor:pointer;',
                listeners: {
                    render: function(component) {
                        component.getEl().on('click', function(e) {
                            me.onCrearAuditoria(record);
                            me.formularioVentana.show();
                        });
                    }
                }
            };
            const area = new Ext.form.TextField({
                name: 'area',
                msgTarget: 'title',
                fieldLabel: 'Area',
                allowBlank: true,
                readOnly :true,
                anchor: '100%',
                style: 'background-image: none;',
                value: this.maestro.nombre_unidad,
                maxLength:50
            });
            const responsable_area = new Ext.form.TextField({
                name: 'responsable_area',
                msgTarget: 'title',
                fieldLabel: 'Responsable area',
                allowBlank: true,
                readOnly :true,
                anchor: '100%',
                style: 'background-image: none;',
                value: this.maestro.desc_funcionario_resp,
                maxLength:50
            });
            const no_conformidad =  {
                fieldLabel: 'No Conformidad',
                xtype: 'box',
                autoEl: {
                    tag: 'a',
                    html: record.descrip_nc,
                },
                style: 'cursor:pointer; ',
                listeners: {
                    render: function(component) {
                        component.getEl().on('click', function(e) {
                            me.formularioNoConformidad(record);
                            me.ventanaNoConformidad.show();
                        });
                    }
                }
            };
            const area_nc = new Ext.form.TextField({
                name: 'area',
                msgTarget: 'title',
                fieldLabel: 'Area NC',
                allowBlank: true,
                readOnly :true,
                anchor: '100%',
                style: 'background-image: none;',
                value: this.maestro.gerencia_uo1,
                maxLength:50
            });
            const responsable_noc = new Ext.form.TextField({
                name: 'responsable_area',
                msgTarget: 'title',
                fieldLabel: 'Resp. de Aprobar NC',
                allowBlank: true,
                readOnly :true,
                anchor: '100%',
                style: 'background-image: none;',
                value: this.maestro.funcionario_uo,
                maxLength:50
            });
            const tipo_accion = new Ext.form.TextField({
                name: 'tipo_accion',
                msgTarget: 'title',
                fieldLabel: 'Tipo Accion',
                allowBlank: true,
                readOnly :true,
                anchor: '100%',
                style: 'background-image: none;',
                value: record.valor_parametro,
                maxLength:50
            });
            const descripcion_ap = new Ext.form.TextArea({
                name: 'descripcion_ap',
                msgTarget: 'title',
                fieldLabel: 'Causa',
                allowBlank: false,
                readOnly :true,
                anchor: '100%',
                style: 'background-image: none;',
                value: record.descripcion_ap,
                maxLength:50
            });
            const efectividad_cumpl_ap = new Ext.form.TextArea({
                name: 'efectividad_cumpl_ap',
                msgTarget: 'title',
                fieldLabel: 'Descripcion',
                allowBlank: false,
                readOnly :true,
                anchor: '100%',
                style: 'background-image: none;',
                value: record.efectividad_cumpl_ap,
                maxLength:50
            });
            const observacion = new Ext.form.TextArea({
                name: 'area',
                msgTarget: 'observacion',
                fieldLabel: 'Observacion',
                allowBlank: true,
                readOnly :false,
                anchor: '100%',
                style: 'background-image: none;',
                value: record.obs_resp_area,
                maxLength:50
            });
            this.formAuto = new Ext.form.FormPanel({
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                autoScroll: true,
                region: 'center',
                //defaults: { height: 450},
                items: [
                    new Ext.form.FieldSet({
                        collapsible: false,
                        border: true,
                        layout: 'form',
                        items: [
                            informe,
                            area,
                            responsable_area
                        ]
                    }),
                    new Ext.form.FieldSet({
                        collapsible: false,
                        border: true,
                        layout: 'form',
                        items: [
                            no_conformidad,
                            area_nc,
                            responsable_noc
                        ]
                    }),
                    new Ext.form.FieldSet({
                        collapsible: false,
                        border: true,
                        layout: 'form',
                        items: [
                            tipo_accion,
                            descripcion_ap,
                            efectividad_cumpl_ap,
                            observacion
                        ]
                    })
                ],
                padding: this.paddingForm,
                bodyStyle: this.bodyStyleForm,
                border: this.borderForm,
                frame: this.frameForm,
            });
            this.ventanaResponsable = new Ext.Window({
                title: titulo,
                width: 600,
                height: 620,
                closeAction: 'hide',
                labelAlign: 'bottom',
                items: this.formAuto,
                modal:true,
                bodyStyle: 'padding:5px',
                layout: 'form',
                buttons: [{
                    text: btn,
                    handler: function(){
                        Phx.CP.loadingShow();
                        const id_estado_wf = record.id_estado_wf;
                        const id_proceso_wf = record.id_proceso_wf;
                        if(confirm('¿Acción Aprobada por Responsable?')){
                            Ext.Ajax.request({
                                url:'../../sis_auditoria/control/AccionPropuesta/aprobarEstado',
                                params:{
                                    id_proceso_wf:  id_proceso_wf,
                                    id_estado_wf:   id_estado_wf
                                },
                                success:this.successWizard,
                                failure: this.conexionFailure,
                                timeout:this.timeout,
                                scope:this
                            });
                        }else {
                            Phx.CP.loadingHide();
                        }
                    },
                    scope: this},
                    {
                        text: 'Cancelar',
                        handler: function(){ this.ventanaResponsable.hide() },
                        scope: this
                    }]
            });
            this.cmpResponsable = this.formAuto.getForm().findField('id_funcionario_nc');
        },
       
        successWizard:function(){
            Phx.CP.loadingHide();
            this.ventanaResponsable.hide();
            this.reload();
        },
    }
</script>
