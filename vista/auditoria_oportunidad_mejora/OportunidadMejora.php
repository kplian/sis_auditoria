<?php
/**
 *@package pXP
 *@file OportunidadMejora.php
 *@author  Maximilimiano Camacho
 *@date 13-08-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.OportunidadMejora = {
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        nombreVista: 'OportunidadMejora',
        dblclickEdit: true,
        constructor: function(config) {
            this.eventoGrill();
            this.idContenedor = config.idContenedor;
            Phx.vista.OportunidadMejora.superclass.constructor.call(this,config);
            this.getBoton('ant_estado').setVisible(false);
            this.init();
            this.store.baseParams.interfaz = 'OportunidadMejora';
            this.iniciarEventoOM();
            this.load({params:{ start:0, limit:this.tam_pag}});
        },
        onButtonNew: function () {
            Phx.vista.OportunidadMejora.superclass.onButtonNew.call(this);
            this.Cmp.id_tipo_auditoria.setValue(2);
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getCorrelativo',
                params: {id_tipo_auditoria: 2},
                success: function(resp){
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    this.Cmp.nro_tramite.setValue(reg.ROOT.datos.correlativo);
                    this.Cmp.axuliar.setValue('Estado :');
                    this.Cmp.nombre_estado.setValue('Programada');
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        onButtonEdit:function(){
            Phx.vista.OportunidadMejora.superclass.onButtonEdit.call(this);
        },
        preparaMenu:function(n){
            const tb =this.tbar;
            Phx.vista.OportunidadMejora.superclass.preparaMenu.call(this,n);
            this.getBoton('sig_estado').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('ant_estado').enable();
            return tb
        },
        liberaMenu:function(){
            const tb = Phx.vista.OportunidadMejora.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('sig_estado').disable();
                this.getBoton('btnChequeoDocumentosWf').disable();
                this.getBoton('diagrama_gantt').disable();
                this.getBoton('ant_estado').disable();
            }
            return tb
        },
        sigEstado:function(){
            Phx.CP.loadingShow();
            const rec = this.sm.getSelected();
            const id_estado_wf = rec.data.id_estado_wf;
            const id_proceso_wf = rec.data.id_proceso_wf;
            if(confirm('¿Desea APROBAR la Oportunidad de mejora')){
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/aprobarEstado',
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
        eventoGrill:function () {
            this.Atributos[this.getIndAtributo('descrip_aom1')].grid=false;
            this.Atributos[this.getIndAtributo('lugar')].grid=false;
            this.Atributos[this.getIndAtributo('recomendacion')].grid=false;
            this.Atributos[this.getIndAtributo('id_gconsultivo')].grid=false;
            this.Atributos[this.getIndAtributo('id_tnorma')].grid=false;
            this.Atributos[this.getIndAtributo('id_tobjeto')].grid=false;
            this.Atributos[this.getIndAtributo('fecha_prev_inicio')].grid=false;
            this.Atributos[this.getIndAtributo('fecha_prev_fin')].grid=false;
            this.Atributos[this.getIndAtributo('fecha_eje_inicio')].grid=false;
            this.Atributos[this.getIndAtributo('fecha_eje_fin')].grid=false;
            this.Atributos[this.getIndAtributo('id_funcionario')].grid=false;
            this.Atributos[this.getIndAtributo('id_destinatario')].grid=false;
            this.Atributos[this.getIndAtributo('resumen')].grid=false;
        },

        onReloadPage : function(m){
            this.maestro = m;
            console.log('=22222>',this);
            this.store.baseParams = {
                id_gestion:  this.maestro.id_gestion,
                desde:  this.maestro.desde,
                hasta:  this.maestro.hasta,
                start:0,
                limit:50,
                sort:'id_aom',
                dir:'DESC',
                interfaz:'OportunidadMejora',
                contenedor: this.idContenedor
            };
            this.store.reload({ params: this.store.baseParams});
        },
        iniciarEventoOM:function () {
           //  this.ocultarComponente(this.Cmp.id_tipo_om);
            this.ocultarComponente(this.Cmp.lugar);
            this.ocultarComponente(this.Cmp.id_tnorma);
            this.ocultarComponente(this.Cmp.id_tobjeto);
            // this.ocultarComponente(this.Cmp.id_gconsultivo);

            this.ocultarComponente(this.Cmp.fecha_prog_inicio);
            this.ocultarComponente(this.Cmp.fecha_prog_fin);
            this.ocultarComponente(this.Cmp.fecha_eje_inicio);
            this.ocultarComponente(this.Cmp.fecha_eje_fin);
        },
        fwidth: 600,
        fheight: '60%',
        Grupos:[
            {
                layout: 'column',
                border: false,
                defaults: {
                    border: false
                },
                items : [{
                    bodyStyle : 'padding-left:5px;padding-left:5px;',
                    border : false,
                    defaults : {
                        border : false
                    },
                    width : 560,
                    items: [
                        {
                            items: [{
                                xtype: 'fieldset',
                                autoHeight: true,
                                items: [
                                    {
                                        xtype: 'compositefield',
                                        msgTarget : 'side',
                                        fieldLabel: 'Codigo',
                                        defaults: {
                                            flex: 1,
                                            padding: 5
                                        },
                                        items: [],
                                        id_grupo: 6
                                    },

                                ]
                            }]
                        },
                        {
                            items: [{
                                xtype: 'fieldset',
                                autoHeight: true,
                                items: [],
                                id_grupo:0
                            }]
                        }]
                }] //
            }
        ]
    };
</script>
