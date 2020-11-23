<?php
/**
 *@package pXP
 *@file VBPlanificacionAuditoria.php
 *@author  MMV
 *@date 18-09-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AccionesPropuestaRechazar = {
        require:'../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php',
        requireclase:'Phx.vista.AccionPropuesta',
        nombreVista: 'AccionesPropuestaRechazar',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        dblclickEdit: true,
        tipoStore: 'GroupingStore',//GroupingStore o JsonStore #
        remoteGroup: true,
        groupField: 'nro_tramite_no',
        viewGrid: new Ext.grid.GroupingView({
            forceFit: false,
        }),
        bodyStyleForm: 'padding:5px;',
        borderForm: true,
        frameForm: false,
        paddingForm: '5 5 5 5',
        constructor: function(config) {
            this.Atributos[this.getIndAtributo('implementar')].grid=false;
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            Phx.vista.AccionesPropuestaRechazar.superclass.constructor.call(this,config);
            this.getBoton('atras').setVisible(false);
            this.init();
            this.store.baseParams.interfaz = this.nombreVista;
            this.load({params:{start:0, limit:50}});
        },
        onButtonEdit:function(){
            const record = this.sm.getSelected().data;
            this.onCrearFormulario(record);
            this.formularioVentana.show();
        },
        onCrearFormulario:function(record){
            if(this.formularioVentana){
                this.form.destroy();
                this.formularioVentana.destroy();
            }
            console.log(record);
            this.form = new Ext.form.FormPanel({
                id: this.idContenedor + '_formulario_aud',
                items: [{ region: 'center',
                    layout: 'column',
                    border: false,
                    autoScroll: true,
                    items: [{
                        xtype: 'tabpanel',
                        plain: true,
                        activeTab: 0,
                        height: 570,
                        deferredRender: false,
                        items: [{
                            title: 'Datos de la Accion',
                            layout: 'form',
                            defaults: {width: 540},
                            autoScroll: true,
                            defaultType: 'textfield',
                            items: [
                                new Ext.form.FieldSet({
                                    collapsible: false,
                                    border: true,
                                    layout: 'form',
                                    items: [
                                        {
                                            fieldLabel: 'Auditoria',
                                            xtype: 'box',
                                            autoEl: {
                                                tag: 'a',
                                                html: record.auditoria,
                                            },
                                            style: 'cursor:pointer;',
                                            listeners: {
                                                render: function (component) {
                                                    component.getEl().on('click', function (e) {
                                                        // me.onCrearAuditoria(data);
                                                        // me.formularioVentana.show();
                                                    });
                                                }
                                            }
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Area',
                                            name: 'area',
                                            anchor: '100%',
                                            value: record.area_noc,
                                            readOnly: true,
                                            style: 'background-image: none;'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Resp. Aera',
                                            name: 'auditor_respo',
                                            anchor: '100%',
                                            value: record.funcionario_noc,
                                            readOnly: true,
                                            style: 'background-image: none;'
                                        },
                                    ]}),
                                new Ext.form.FieldSet({
                                    collapsible: false,
                                    border: true,
                                    layout: 'form',
                                    items: [
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Area NC',
                                            name: 'area',
                                            anchor: '100%',
                                            value: record.area_noc,
                                            readOnly: true,
                                            style: 'background-image: none;'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Resp. Aera NC',
                                            name: 'auditor_respo',
                                            anchor: '100%',
                                            value: record.funcionario_noc,
                                            readOnly: true,
                                            style: 'background-image: none;'
                                        },
                                        {
                                            fieldLabel: 'No Conformidad',
                                            xtype: 'box',
                                            autoEl: {
                                                tag: 'a',
                                                html: record.descrip_nc,
                                            },
                                            style: 'cursor:pointer;',
                                            listeners: {
                                                render: function (component) {
                                                    component.getEl().on('click', function (e) {
                                                        // me.formularioNoConformidad(data);
                                                        // me.ventanaNoConformidad.show();
                                                    });
                                                }
                                            }
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Tipo de Accion',
                                            name: 'auditor_respo',
                                            anchor: '100%',
                                            value: record.funcionario_noc,
                                            readOnly: true,
                                            style: 'background-image: none;'
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'descripcion_ap',
                                            fieldLabel: 'Descripcion accion propuesta',
                                            allowBlank: true,
                                            style: 'margin: 10px',
                                            anchor: '100%',
                                            gwidth: 210,
                                            style: 'background-image: none;'
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'efectividad_cumpl_ap',
                                            fieldLabel: 'Efectividad Cumplimiento ',
                                            allowBlank: true,
                                            style: 'margin: 10px',
                                            anchor: '100%',
                                            gwidth: 210,
                                            style: 'background-image: none;'

                                        },
                                        {
                                            xtype: 'datefield',
                                            fieldLabel: 'Inicio',
                                            name: 'fecha_inicio_ap',
                                            disabled: false,
                                            anchor: '100%',
                                        },
                                        {
                                            xtype: 'datefield',
                                            fieldLabel: 'Fin',
                                            name: 'fecha_fin_ap',
                                            disabled: false,
                                            anchor: '100%',
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Criterio / Efectividad',
                                            name: 'auditor_respo',
                                            anchor: '100%',
                                            value: record.funcionario_noc,
                                            readOnly: true,
                                            style: 'background-image: none;'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Resp. Implementacion',
                                            name: 'auditor_respo',
                                            anchor: '100%',
                                            value: record.funcionario_noc,
                                            readOnly: true,
                                            style: 'background-image: none;'
                                        },


                                    ]})
                            ]
                        },
                            {
                                title: 'Datos de la Implementación',
                                layout: 'form',
                                defaults: {width: 540},
                                autoScroll: true,
                                defaultType: 'textfield',
                                items: [
                                    new Ext.form.FieldSet({
                                            collapsible: false,
                                            border: true,
                                            layout: 'form',
                                            defaults: {width: 400},
                                            items: [
                                                {
                                                    xtype: 'field',
                                                    fieldLabel: 'Estado de la tarea',
                                                    name: 'estado',
                                                    anchor: '100%',
                                                    value: record.funcionario_noc,
                                                    readOnly: true,
                                                    style: 'background-image: none;'
                                                },
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Fecha',
                                                    name: 'fecha',
                                                    disabled: false,
                                                    anchor: '100%',
                                                },
                                                {
                                                    xtype: 'textarea',
                                                    name: 'comentario',
                                                    fieldLabel: 'Descripcion / Comentario',
                                                    allowBlank: true,
                                                    style: 'margin: 10px',
                                                    anchor: '100%',
                                                    gwidth: 210,
                                                    style: 'background-image: none;'

                                                },
                                                {
                                                    xtype: 'textarea',
                                                    name: 'revicion',
                                                    fieldLabel: 'Comentario de Revision',
                                                    allowBlank: true,
                                                    style: 'margin: 10px',
                                                    anchor: '100%',
                                                    gwidth: 210,
                                                    style: 'background-image: none;'

                                                },
                                            ]
                                        }
                                    )
                                ]
                            }
                        ]
                    }]
                }],
                padding: this.paddingForm,
                bodyStyle: this.bodyStyleForm,
                border: this.borderForm,
                frame: this.frameForm,
                autoDestroy: true,
                autoScroll: true,
                region: 'center'
            });
            this.formularioVentana = new Ext.Window({
                width: 580,
                height: 650,
                modal: true,
                closeAction: 'hide',
                labelAlign: 'top',
                title: 'Auditoria Planificacion',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: [this.form],
                buttons: [{
                    text: 'Guardar',
                    handler: this.onSubmit,
                    scope: this
                }, {
                    text: 'Declinar',
                    handler: function() {
                        this.formularioVentana.hide();
                    },
                    scope: this
                }]
            });
        },
        onButtonSiguiente:function () {
            Phx.CP.loadingShow();
            const rec = this.sm.getSelected();
            const id_estado_wf = rec.data.id_estado_wf;
            const id_proceso_wf = rec.data.id_proceso_wf;
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
        successWizard:function(){
            Phx.CP.loadingHide();
            this.reload();
        },
    }
</script>
