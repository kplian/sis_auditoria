<?php
/**
 *@package pXP
 *@file    FormAuditoria.php
 *@author  MMV
 *@date    30-01-2014
 *@description permites subir archivos a la tabla de documento_sol
 */
/**
HISTORIAL DE MODIFICACIONES:
ISSUE 		   FECHA   			 AUTOR				 DESCRIPCION:

 */
header("content-type: text/javascript; charset=UTF-8");
?>

<script>
    Phx.vista.FormAuditoria=Ext.extend(Phx.frmInterfaz,{
        constructor:function(config){
            this.panelResumen = new Ext.Panel({html:''});
            this.Grupos = [{
                        xtype: 'fieldset',
                        border: true,
                        autoScroll: true,
                        layout: 'form',
                        items:[],
                        id_grupo: 0
                    },
                    this.panelResumen
            ];
            Phx.vista.FormAuditoria.superclass.constructor.call(this,config);
            this.init();
            this.mostrarComponente(this.Cmp.desde);
            this.mostrarComponente(this.Cmp.hasta);
            this.iniciarEventos();
            if(config.detalle){
                //cargar los valores para el filtro
                this.loadForm({data: config.detalle});
                var me = this;
                setTimeout(function(){
                    me.onSubmit()
                }, 1500);
            }
        },

        Atributos:[
            {
                config:{
                    name : 'tipo_filtro',
                    fieldLabel : 'Filtros',
                    items: [
                        {boxLabel: 'Gestión', name: 'tipo_filtro', inputValue: 'gestion', checked: true},
                        {boxLabel: 'Solo fechas', name: 'tipo_filtro', inputValue: 'fechas'}
                    ],
                },
                type : 'RadioGroupField',
                id_grupo : 0,
                form : true
            },
            {
                config:{
                    name : 'id_gestion',
                    origen : 'GESTION',
                    fieldLabel : 'Gestion',
                    gdisplayField: 'desc_gestion',
                    allowBlank : false,
                    width: 150
                },
                type : 'ComboRec',
                id_grupo : 0,
                form : true
            },
            {
                config:{
                    name: 'desde',
                    fieldLabel: 'Desde',
                    allowBlank: true,
                    format: 'd/m/Y',
                    width: 150
                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            },
            {
                config:{
                    name: 'hasta',
                    fieldLabel: 'Hasta',
                    allowBlank: true,
                    format: 'd/m/Y',
                    width: 150
                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            },

        ],
        labelSubmit: '<i class="fa fa-check"></i> Aplicar Filtro',
        east: {
            url: '../../../sis_auditoria/vista/form_auditoria/VBAuditoria.php',
            title: undefined,
            width: '70%',
            cls: 'VBAuditoria'
        },
        title: 'Filtro de Auditorias',
        autoScroll: true,
        onSubmit: function(o) {
            var me = this;
           if (me.form.getForm().isValid()) {
                var parametros = me.getValForm();
                var gest=this.Cmp.id_gestion.lastSelectionText;
                this.onEnablePanel(this.idContenedor + '-east',
                    Ext.apply(parametros,{
                        'gest': gest
                    }));
            }
        },
        iniciarEventos:function(){
            this.Cmp.tipo_filtro.on('change', function(cmp, check){
                if(check.getRawValue() !=='gestion'){
                    this.Cmp.id_gestion.reset();
                    this.ocultarComponente(this.Cmp.id_gestion);
                }
                else{
                    this.mostrarComponente(this.Cmp.id_gestion);
                    
                }
            }, this);
        },
        loadValoresIniciales: function(){
            Phx.vista.FormAuditoria.superclass.loadValoresIniciales.call(this);
        }

    })
</script>
