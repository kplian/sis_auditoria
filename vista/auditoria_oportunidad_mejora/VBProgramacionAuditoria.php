<?php
/**
 *@package pXP
 *@file VBProgramacionAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 13-08-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.VBProgramacionAuditoria = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:' :: Formulario Registro de Auditoria - Oportunidad Mejora',
        nombreVista: 'VBProgramacionAuditoria',

        constructor: function(config) {
            Phx.vista.VBProgramacionAuditoria.superclass.constructor.call(this,config);
            this.init();
            this.load({params:{start:0, limit:this.tam_pag, v_estado_wf_vb:'vob_programado', v_estado_wf_vb1: 'observado'/*, v_tipo_auditoria:'AI'*/}});
            this.getBoton('btnPlanificarAudit').hide();
            this.getBoton('btnInformeOM').hide();
            this.getBoton('btnHelpAOM').hide();

            /*this.addButton('btnNotificarAuditoriaProgramada', {
                text : 'Notificar Programacion',
                iconCls : 'badelante', /*'bballot','block','bgood','block'
                disabled : false,
                handler : this.onBtnNotificarAuditoriaProgramada,
                tooltip : '<b>Notificar Auditoria Programada</b>'
            });*/
            /*this.addButton('btnChequeoDocumentosWf',
                {	text: 'Documentos',
                    iconCls: 'bchecklist',
                    disabled: true,
                    handler: this.loadCheckDocumentosPlanWf,
                    tooltip: '<b>Documentos de la No conformidad</b><br/>Subir los documentos de evidencia.'
                }
            );*/
            /*this.addButton('btnObs',{//#11
                text :'Obs Wf',
                grupo:[0,1,2],
                iconCls : 'bchecklist',
                disabled: true,
                handler : this.onOpenObs,
                tooltip : '<b>Observaciones</b><br/><b>Observaciones del WF</b>'
            });*/
            this.addButton('ant_estado', {
                argument: {estado: 'anterior'},
                text:'Anterior',
                grupo:[0,2],
                iconCls: 'batras',
                disabled:true,
                handler:this.antEstado,
                tooltip: '<b>Pasar al Anterior Estado</b>'
            });
            this.addButton('sig_estado',{
                text:'Siguiente',
                grupo:[0,2],
                iconCls: 'badelante',
                disabled: true,
                handler: this.sigEstado,
                tooltip: '<b>Pasar al Siguiente Estado</b>'
            });
            this.addBotonesGantt();

        },
        arrayDefaultColumHidden:[/*'documento',*/'codigo_aom','nombre_aom2','lugar','descrip_aom2','fecha_prev_inicio','fecha_prev_fin',
            'id_tnorma','id_tobjeto','id_tipo_om','id_gconsultivo','resumen','recomendacion','fecha_eje_inicio','fecha_eje_fin',
            'formulario_ingreso','estado_form_ingreso','usuario_ai','id_proceso_wf','id_estado_wf'],

        /**
         * ======================================================================
         * ===============     Inicio de Proceso Worflow        =================
         * ======================================================================
         * */
        sigEstado:function(){
            var data = this.getSelectedData();
            this.objWizard = Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/FormEstadoWf.php',
                'Estado de Wf',
                {
                    modal:true,
                    width:700,
                    height:450
                }, {data:{
                        id_aom:data.id_aom,
                        id_estado_wf:data.id_estado_wf,
                        id_proceso_wf:data.id_proceso_wf,

                    }}, this.idContenedor,'FormEstadoWf',
                {
                    config:[{
                        event:'beforesave',
                        delegate: this.onSaveWizard,

                    }],

                    scope:this
                });

        },
        onSaveWizard:function(wizard,resp){
            //var estado = this.getSelectedData();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/siguienteEstado',
                params:{
                    id_aom:      wizard.data.id_aom,
                    id_proceso_wf_act:  resp.id_proceso_wf_act,
                    id_estado_wf_act:   resp.id_estado_wf_act,
                    id_tipo_estado:     resp.id_tipo_estado,
                    id_funcionario_wf:  resp.id_funcionario_wf,
                    id_depto_wf:        resp.id_depto_wf,
                    obs:                resp.obs,
                    json_procesos:      Ext.util.JSON.encode(resp.procesos)
                },
                success:this.successWizard,
                failure: this.conexionFailure,
                argument:{wizard:wizard},
                timeout:this.timeout,
                scope:this
            });

        },
        successWizard:function(resp){
            Phx.CP.loadingHide();
            resp.argument.wizard.panel.destroy()
            this.reload();
        },
        antEstado: function(res){
            var data = this.getSelectedData();
            Phx.CP.loadingHide();
            Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/AntFormEstadoWf.php',
                'Estado de Wf',
                {   modal: true,
                    width: 450,
                    height: 250
                },
                {    data: data,
                    estado_destino: res.argument.estado
                },
                this.idContenedor,'AntFormEstadoWf',
                {
                    config:[{
                        event:'beforesave',
                        delegate: this.onAntEstado,
                    }],
                    scope:this
                });

        },
        onAntEstado: function(wizard,resp){
            console.log('resp',wizard.data.id_help_desk);
            Phx.CP.loadingShow();
            var operacion = 'cambiar';

            Ext.Ajax.request({
                url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/anteriorEstado',
                params:{
                    id_aom: wizard.data.id_aom,
                    id_proceso_wf: resp.id_proceso_wf,
                    id_estado_wf:  resp.id_estado_wf,
                    obs: resp.obs,
                    operacion: operacion
                },
                argument:{wizard:wizard},
                success: this.successAntEstado,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        successAntEstado:function(resp){
            Phx.CP.loadingHide();
            resp.argument.wizard.panel.destroy()
            this.reload();

        },
        onOpenObs:function() {//#11
            var rec=this.sm.getSelected();

            var data = {
                id_proceso_wf: rec.data.id_proceso_wf,
                id_estado_wf: rec.data.id_estado_wf,
                num_tramite: rec.data.num_tramite
            }

            Phx.CP.loadWindows('../../../sis_workflow/vista/obs/Obs.php',
                'Observaciones del WF',
                {
                    width:'80%',
                    height:'70%'
                },
                data,
                this.idContenedor,
                'Obs'
            )
        },
        /*loadCheckDocumentosPlanWf:function(){
            var rec=this.sm.getSelected();
            rec.data.nombreVista = this.nombreVista;
            Phx.CP.loadWindows('../../../sis_workflow/vista/documento_wf/DocumentoWf.php',
                'Chequear documento del WF',
                {
                    width:'90%',
                    height:500
                },
                rec.data,
                this.idContenedor,
                'DocumentoWf'
            )
        },*/
        /****** implementamos el Gantt *******/
        diagramGanttDinamico : function(){
            var data=this.sm.getSelected().data.id_proceso_wf;
            window.open('../../../sis_workflow/reportes/gantt/gantt_dinamico.html?id_proceso_wf='+data)
        },

        addBotonesGantt: function() {
            this.menuAdqGantt = new Ext.Toolbar.SplitButton({
                id: 'b-diagrama_gantt-' + this.idContenedor,
                text: 'Gantt',
                disabled: true,
                //grupo:[0,1,2,3,4],
                iconCls : 'bgantt',
                handler:this.diagramGanttDinamico,
                scope: this,
                menu:{
                    items: [{
                        id:'b-gantti-' + this.idContenedor,
                        text: 'Gantt Imagen',
                        tooltip: '<b>Muestra un reporte gantt en formato de imagen</b>',
                        handler:this.diagramGantt,
                        scope: this
                    }, {
                        id:'b-ganttd-' + this.idContenedor,
                        text: 'Gantt Dinámico',
                        tooltip: '<b>Muestra el reporte gantt facil de entender</b>',
                        handler:this.diagramGanttDinamico,
                        scope: this
                    }
                    ]}
            });
            this.tbar.add(this.menuAdqGantt);
        },

        diagramGantt : function (){
            var data=this.sm.getSelected().data.id_proceso_wf;
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_workflow/control/ProcesoWf/diagramaGanttTramite',
                params: { 'id_proceso_wf': data },
                success: this.successExport,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        /*===================================<Fin method Worflow>======================================*/
        preparaMenu:function(n){
            var data = this.getSelectedData();
            Phx.vista.VBProgramacionAuditoria.superclass.preparaMenu.call(this);
            //this.getBoton('btnPlanificarAudit').enable();

            //this.getBoton('btnNotificarAuditoriaProgramada').enable();
            //this.getBoton('btnChequeoDocumentosWf').enable();
            //this.getBoton('btnObs').enable();
            this.getBoton('ant_estado').enable();
            if(data.estado_wf == 'observado'){
                this.getBoton('sig_estado').disable();
            }
            else{
                this.getBoton('sig_estado').enable();
            }
            this.getBoton('diagrama_gantt').enable();
        },
        liberaMenu:function(n){
            //var data = this.getSelectedData();
            //console.log('valor n de liberaMenu:',n);
            Phx.vista.VBProgramacionAuditoria.superclass.liberaMenu.call(this);
            //this.getBoton('btnNotificarAuditoriaProgramada').disable();
            //this.getBoton('btnChequeoDocumentosWf').disable();
            //this.getBoton('btnObs').disable();
            //this.getBoton('ant_estado').disable();
            this.getBoton('sig_estado').disable();

            this.getBoton('diagrama_gantt').disable();
        },
        formProgramarAuditoria: function () {
            //Ocultar campos de formulario Planificacion de Aditoria, programacion de OM
            //y Formulario de Informe de Ejecucion AOM

            this.ocultarComponente(this.Cmp.documento);
            this.ocultarComponente(this.Cmp.codigo_aom);

            this.ocultarComponente(this.Cmp.nombre_aom2);
            this.ocultarComponente(this.Cmp.lugar);
            this.ocultarComponente(this.Cmp.descrip_aom2);
            this.ocultarComponente(this.Cmp.fecha_prev_inicio);
            this.ocultarComponente(this.Cmp.fecha_prev_fin);
            this.ocultarComponente(this.Cmp.id_tnorma);
            this.ocultarComponente(this.Cmp.id_tobjeto);

            this.ocultarComponente(this.Cmp.resumen);
            this.ocultarComponente(this.Cmp.recomendacion);
            this.ocultarComponente(this.Cmp.fecha_eje_inicio);
            this.ocultarComponente(this.Cmp.fecha_eje_fin);

            this.ocultarComponente(this.Cmp.id_tipo_om);

            this.ocultarComponente(this.Cmp.id_gconsultivo);

            this.ocultarComponente(this.Cmp.id_proceso_wf);
            this.ocultarComponente(this.Cmp.id_estado_wf);
            this.ocultarComponente(this.Cmp.nro_tramite_wf);
            this.ocultarComponente(this.Cmp.estado_wf);

            //Muestra los campos de formulario de programacion de Auditoria

            this.mostrarComponente(this.Cmp.id_tipo_auditoria);
            this.Cmp.codigo_aom.disable(true);
            this.mostrarComponente(this.Cmp.id_uo);
            this.mostrarComponente(this.Cmp.nombre_aom1);
            this.mostrarComponente(this.Cmp.descrip_aom1);

            this.mostrarComponente(this.Cmp.id_funcionario);
            this.mostrarComponente(this.Cmp.fecha_prog_inicio);
            this.mostrarComponente(this.Cmp.fecha_prog_fin);

        },
        formProgramarOportunidadMejora:function () {
            //Ocultar campos de formulario Planificacion de Aditoria, programacion de OM
            //y Formulario de Informe de Ejecucion AOM

            this.ocultarComponente(this.Cmp.documento);
            this.ocultarComponente(this.Cmp.codigo_aom);

            this.ocultarComponente(this.Cmp.nombre_aom2);
            this.ocultarComponente(this.Cmp.lugar);
            this.ocultarComponente(this.Cmp.descrip_aom2);
            this.ocultarComponente(this.Cmp.fecha_prev_inicio);
            this.ocultarComponente(this.Cmp.fecha_prev_fin);
            this.ocultarComponente(this.Cmp.id_tnorma);
            this.ocultarComponente(this.Cmp.id_tobjeto);

            this.ocultarComponente(this.Cmp.resumen);
            this.ocultarComponente(this.Cmp.recomendacion);
            this.ocultarComponente(this.Cmp.fecha_eje_inicio);
            this.ocultarComponente(this.Cmp.fecha_eje_fin);

            this.ocultarComponente(this.Cmp.id_funcionario);
            this.ocultarComponente(this.Cmp.id_proceso_wf);
            this.ocultarComponente(this.Cmp.id_estado_wf);
            this.ocultarComponente(this.Cmp.nro_tramite_wf);
            this.ocultarComponente(this.Cmp.estado_wf);

            //Muestra los campos de formulario de programacion de Auditoria

            this.mostrarComponente(this.Cmp.id_tipo_auditoria);
            this.Cmp.codigo_aom.disable(true);
            this.mostrarComponente(this.Cmp.id_tipo_om);
            this.mostrarComponente(this.Cmp.id_uo);
            this.mostrarComponente(this.Cmp.id_gconsultivo);
            this.mostrarComponente(this.Cmp.nombre_aom1);
            this.mostrarComponente(this.Cmp.descrip_aom1);

            this.mostrarComponente(this.Cmp.fecha_prog_inicio);
            this.mostrarComponente(this.Cmp.fecha_prog_fin);

        },

    };
</script>
