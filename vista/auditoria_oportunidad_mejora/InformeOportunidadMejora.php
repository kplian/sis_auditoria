<?php
/**
 *@package pXP
 *@file InformeOportunidadMejora.php
 *@author  Maximilimiano Camacho
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.InformeOportunidadMejora = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:'AuditoriaOportunidadMejora',
        nombreVista: 'InformeOportunidadMejora',
        //v_oportunidad: 'si',

        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            Phx.vista.InformeOportunidadMejora.superclass.constructor.call(this,config);
            //this.store.baseParams.hyomin = 'si';
            this.init();
            this.load({params:{start:0, limit:this.tam_pag, v_tipo_om: 'OM', v_estado_wf_om:'informe'}});
            this.getBoton('btnInformeOM').hide();
            this.getBoton('btnHelpAOM').hide();

            this.addButton('btnInformeAuditoria', {
                text : 'Datos generales OM',
                iconCls : 'bballot', /*'bballot','block','bgood','block'*/
                disabled : false,
                handler : this.onBtnInformeAuditoria,
                tooltip : '<b>Informe Auditoria</b>'
            });
            this.addButton('btnAuditSummary', {
                text : 'Resumen',
                iconCls : 'bballot', /*'bballot','block','bgood','block'*/
                disabled : false,
                handler : this.onBtnAuditSummary,
                tooltip : '<b>Resumen de Auditoria</b>'
            });
            this.addButton('btnAuditActaComite', {
                text : 'Acta de Reunion del Comite',
                iconCls : 'bballot', /*'bballot','block','bgood','block'*/
                disabled : false,
                handler : this.onBtnAuditActaComite,
                tooltip : '<b>Acto de Reunion del Comite</b>'
            });
            this.addButton('btnAuditInformeTecnicoAF', {
                text : 'Informe Tecnico AF',
                iconCls : 'bballot', /*'bballot','block','bgood','block'*/
                disabled : false,
                handler : this.onBtnAuditInformeTecnicoAF,
                tooltip : '<b>Informe Tecnico de Analisis de Fallas</b>'
            });
            this.addButton('btnAuditRecomendation', {
                text : 'Recomendacion',
                iconCls : 'bballot', /*'bballot','block','bgood','block'*/
                disabled : false,
                handler : this.onBtnAuditRecomendation,
                tooltip : '<b>Recomendacion de Auditoria</b>'
            });
            this.addButton('NoConformidades', {
                text : 'No Conformidades',
                iconCls : 'bdocuments', /*'bballot','block','bgood','block', 'bengineadd' */
                disabled : false,
                handler : this.onButtonNoConformidades,
                tooltip : '<b>Gestion de No conformidades</b>',
                scope:this
            });
            /*this.addButton('btnNotificarInformeOM', {
                text : 'Notificar Informe OM',
                iconCls : 'badelante',
                disabled : false,
                handler : this.onBtnNotificarInformeOM,
                tooltip : '<b>Notificar Informe Oportunidad Mejora</b>'
            });*/
            this.addButton('sig_estado',{
                text:'Siguiente',
                grupo:[0,2],
                iconCls: 'badelante',
                disabled: true,
                handler: this.sigEstado,
                tooltip: '<b>Pasar al Siguiente Estado</b>'
            });

            this.addBotonesGantt();
            this.TabPanelSouth.getItem(this.idContenedor + '-south-0').setDisabled(true);
        },
        arrayDefaultColumHidden:[/*'documento','id_tipo_om','id_gconsultivo',*/'codigo_aom','id_funcionario','nombre_aom2',/*'lugar',*/'descrip_aom2',/*'fecha_prev_inicio','fecha_prev_fin',*/
            'id_tnorma','id_tobjeto','resumen','recomendacion','fecha_prev_inicio','fecha_prev_fin','formulario_ingreso','estado_form_ingreso',/*'fecha_prev_inicio','fecha_prev_fin',*/
            'id_proceso_wf','id_estado_wf','usuario_ai'],
        tabsouth:[
            {
                url:'../../../sis_auditoria/vista/destinatario/Destinatario.php',
                title:':: Destinatario(s)',
                height:'45%',
                width: '40%',
                cls:'Destinatario'
            },
            /*{
                url:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/FormSummaryAudit.php',
                title:':: Resumen(s)',
                height:'45%',
                width: '40%',
                cls:'FormSummaryAudit'
            }*/
        ],
        onBtnInformeAuditoria: function(){
            var data = this.getSelectedData();
            //if(data.es_oportunidad == 0 || data.es_oportunidad == 1){
            if(data.estado_wf == 'programado' || data.estado_wf == 'ejecutada' || data.estado_wf == 'informe'){
                this.onButtonEdit();
                this.Cmp.id_gconsultivo.on('select',function (combo,record,index) {
                    console.log('combo',combo, 'record',record, 'index',index);
                    //console.log("Entra a data this",data);
                    console.log("[Req. Prog, Req. Form]->","("+record.data.requiere_programacion+","+record.data.requiere_formulario+")");
                    this.Cmp.requiere_programacion.setValue(record.data.requiere_programacion);
                    this.Cmp.requiere_formulario.setValue(record.data.requiere_formulario);

                },this);
                this.formInformeAuditoria();
            }
            else{
                alert('La Auditoria ya ha sido remitido el informe, ya no es posible modificar.!!!');
            }

        },
        onBtnAuditSummary: function(){
            //var rec = '';
            var rec = this.sm.getSelected();
            console.log('valor del rec->:',this.sm.getSelected());
            Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/FormSummaryAudit.php', 'Resumen de Auditoria', {
                modal : true,
                width : '50%',
                height : '60%',
            }, rec, this.idContenedor, 'FormSummaryAudit');
            //this.store.baseParams.id_tipo_auditoria = 1;
        },
        onBtnAuditActaComite: function(){
            //var rec = '';
            var rec = this.sm.getSelected();
            console.log('valor del rec->:',this.sm.getSelected());
            Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/FormSummaryAudit.php', 'Acta de Reunion del Comite', {
                modal : true,
                width : '50%',
                height : '60%',
            }, rec, this.idContenedor, 'FormSummaryAudit');
            //this.store.baseParams.id_tipo_auditoria = 1;
        },
        onBtnAuditInformeTecnicoAF: function(){
            //var rec = '';
            var rec = this.sm.getSelected();
            console.log('valor del rec->:',this.sm.getSelected());
            Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/FormSummaryAudit.php', 'Informe Tecnico de Analisis de Fallas', {
                modal : true,
                width : '50%',
                height : '60%',
            }, rec, this.idContenedor, 'FormSummaryAudit');
            //this.store.baseParams.id_tipo_auditoria = 1;
        },
        onBtnAuditRecomendation: function(){
            //var rec = '';
            var rec = this.sm.getSelected();
            console.log('valor del rec->:',this.sm.getSelected());
            Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/FormRecomendacionAudit.php', 'Recomendacion de Auditoria', {
                modal : true,
                width : '50%',
                height : '60%',
            }, rec, this.idContenedor, 'FormRecomendacionAudit');
            //this.store.baseParams.id_tipo_auditoria = 1;
        },
        onButtonNoConformidades: function(){
            var rec = this.sm.getSelected();  //los valores del registro seleccionado
            if (rec.data === undefined){
                alert('Seleccione un registro')
            }
            console.log ('Data',rec.data);
            Phx.CP.loadWindows('../../../sis_auditoria/vista/no_conformidad/NoConformidadGestion.php', // direciones de la vista
                'Gestion No conformidades', // titulo de la ventana
                {
                    //modal : true,
                    width:'90%',
                    height:'90%'
                },  /// dimensiones
                rec.data, // record dara padres para filtrado de datos padre e hijo
                this.idContenedor, /// los datos de padre
                'NoConformidadGestion'); // clase de la vista hijo

        },
        /*onButtonEdit: function () {
            Phx.vista.InformeAuditoria.superclass.onButtonEdit.call(this);
            this.formInformeAuditoria();
        },*/
        EnableSelect: function(){
            Phx.vista.InformeOportunidadMejora.superclass.EnableSelect.call(this);
            this.TabPanelSouth.getItem(this.idContenedor + '-south-0').setDisabled(true);
            var data = this.getSelectedData();
            //console.log("valor de getSelected-->",this.getSelectedData());
            if(this.getSelectedData() && this.getSelectedData().lugar!="" ) {
                this.TabPanelSouth.getItem(this.idContenedor + '-south-0').setDisabled(false);
            }
        },
        /**
         * ======================================================================
         * =====================< worflow Process start >========================
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
            resp.argument.wizard.panel.destroy();
            this.reload();
        },
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
        /*==================================< End worflow method >=====================================*/
        preparaMenu:function(n){
            var data = this.getSelectedData();
            Phx.vista.InformeOportunidadMejora.superclass.preparaMenu.call(this);
            this.getBoton('btnPlanificarAudit').enable();

            this.getBoton('btnInformeAuditoria').enable();

            if(data.requiere_programacion == "0" && data.requiere_formulario == "0"){
                this.getBoton('btnAuditActaComite').hide();
                this.getBoton('btnAuditInformeTecnicoAF').hide();
                this.getBoton('btnAuditSummary').show();
                this.getBoton('btnAuditSummary').enable();
            }
            else{
                if(data.requiere_programacion == "1" && data.requiere_formulario == "1"){
                    this.getBoton('btnAuditSummary').hide();
                    this.getBoton('btnAuditInformeTecnicoAF').hide();
                    this.getBoton('btnAuditActaComite').show();
                    this.getBoton('btnAuditActaComite').enable();
                }
                else{
                    if(data.requiere_programacion == "0" && data.requiere_formulario == "1"){
                        this.getBoton('btnAuditSummary').hide();
                        this.getBoton('btnAuditActaComite').hide();
                        this.getBoton('btnAuditInformeTecnicoAF').show();
                        this.getBoton('btnAuditInformeTecnicoAF').enable();
                    }

                }
            }
            this.getBoton('btnAuditRecomendation').enable();
            this.getBoton('NoConformidades').enable();

            //this.getBoton('btnNotificarInformeOM').enable();
            this.getBoton('sig_estado').enable();
            this.getBoton('diagrama_gantt').enable();
        },
        liberaMenu:function(n){
            //var data = this.getSelectedData();
            Phx.vista.InformeOportunidadMejora.superclass.liberaMenu.call(this);
            this.getBoton('btnPlanificarAudit').hide();

            this.getBoton('btnInformeAuditoria').disable();
            this.getBoton('btnAuditSummary').disable();
            this.getBoton('btnAuditActaComite').disable();
            this.getBoton('btnAuditInformeTecnicoAF').disable();
            this.getBoton('btnAuditRecomendation').disable();
            this.getBoton('NoConformidades').disable();

            //this.getBoton('btnNotificarInformeOM').disable();
            this.getBoton('sig_estado').disable();
            this.getBoton('diagrama_gantt').disable();
        },
        formInformeAuditoria: function () {
            this.ocultarComponente(this.Cmp.documento);
            this.ocultarComponente(this.Cmp.codigo_aom);

            //this.ocultarComponente(this.Cmp.id_tipo_auditoria);
            this.ocultarComponente(this.Cmp.id_uo);

            //this.ocultarComponente(this.Cmp.descrip_aom1);
            this.ocultarComponente(this.Cmp.id_funcionario);
            //this.ocultarComponente(this.Cmp.fecha_prog_inicio);
            //this.ocultarComponente(this.Cmp.fecha_prog_fin);

            //this.ocultarComponente(this.Cmp.resumen);
            //this.ocultarComponente(this.Cmp.recomendacion);
            //this.ocultarComponente(this.Cmp.fecha_eje_inicio);
            //this.ocultarComponente(this.Cmp.fecha_eje_fin);

            //this.ocultarComponente(this.Cmp.id_tipo_om);
            //this.ocultarComponente(this.Cmp.id_gconsultivo);

            this.ocultarComponente(this.Cmp.nombre_aom2);
            this.ocultarComponente(this.Cmp.id_tnorma);
            this.ocultarComponente(this.Cmp.id_tobjeto);
            this.ocultarComponente(this.Cmp.fecha_prev_inicio);
            this.ocultarComponente(this.Cmp.fecha_prev_fin);

            this.ocultarComponente(this.Cmp.resumen);
            this.ocultarComponente(this.Cmp.recomendacion);

            this.ocultarComponente(this.Cmp.id_proceso_wf);
            this.ocultarComponente(this.Cmp.id_estado_wf);
            this.ocultarComponente(this.Cmp.estado_wf);


            this.ocultarComponente(this.Cmp.nombre_estado);
            this.ocultarComponente(this.Cmp.formulario_ingreso);
            this.ocultarComponente(this.Cmp.estado_form_ingreso);

            //Muestra los campos de formulario de programacion de Auditoria


            this.Cmp.nombre_aom2.disable(true);
            this.mostrarComponente(this.Cmp.lugar);
            //this.Cmp.lugar.disable(true);


            //this.mostrarComponente(this.Cmp.descrip_aom2);
            this.Cmp.descrip_aom2.disable(true);

            this.Cmp.id_tnorma.disable(true);

            this.Cmp.id_tobjeto.disable(true);
            this.Cmp.fecha_prev_inicio.disable(true);
            //this.Cmp.fecha_prev_inicio.grid = false;

            this.Cmp.fecha_prev_fin.disable(true);

            //
            this.mostrarComponente(this.Cmp.nro_tramite_wf);
            this.Cmp.nro_tramite_wf.disable(true);
            this.mostrarComponente(this.Cmp.id_tipo_auditoria);
            this.Cmp.id_tipo_auditoria.disable(true);
            this.mostrarComponente(this.Cmp.nombre_aom1);
            this.mostrarComponente(this.Cmp.id_tipo_om);
            this.mostrarComponente(this.Cmp.id_gconsultivo);
            this.mostrarComponente(this.Cmp.descrip_aom1);
            this.mostrarComponente(this.Cmp.fecha_prog_inicio);
            this.Cmp.fecha_prog_inicio.disable(true);
            this.mostrarComponente(this.Cmp.fecha_prog_fin);
            this.Cmp.fecha_prog_fin.disable(true);
            //

            this.mostrarComponente(this.Cmp.fecha_eje_inicio);
            this.mostrarComponente(this.Cmp.fecha_eje_fin);

        },
        validarEstado:function () {

        }

    };
</script>
