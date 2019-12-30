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
        //v_oportunidad: 'si',
        string_head_inicion: "En fecha ",
        string_head_fin: " conforme al Programa Anual de Auditorias Internas de la Empresa se realizó la auditoria:\n",
        string_title_responsable: "El Equipo auditor estuvo conformado por:\n",
        string_glosa: "Se visitaron los trabajos en las estructuras 104 (Excavación); 105 (Nivelación y puesta de Grillas); 108 (Excavación) en la zona de Paracti, y levantamiento de estructuras 8 y 10 en Santibáñez.\n" +
            "El equipo auditor pondera el compromiso y responsabilidad del personal del Area y Proceso Auditados, Asi como el personal de la Gerencia y Administración.",
        string_glosa_fin: "Como resultado de la auditoria se encontraron oportunidades de mejora que se presentan en el Informe de No Conformidades.\n",

        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            //console.log("valor del maestrito-->",this.maestro);
            Phx.vista.InformeAuditoria.superclass.constructor.call(this,config);
            //this.store.baseParams.hyomin = 'si';
            this.init();
            this.load({params:{start:0, limit:this.tam_pag, v_tipo_aii: 'AI', v_estado_wf_ai:'plani_aprob', v_estado_wf_ai1:'ejecutada', v_estado_wf_ai2:'informe', v_estado_wf_ai3:'vob_informe', v_estado_wf_ai4: 'informe_observado', v_estado_wf_ai5: 'acept_resp_area' /*v_tipo_auditoria_etapa2: 'AI'*/}});
            this.getBoton('btnInformeOM').hide();
            this.getBoton('btnHelpAOM').hide();

            this.addButton('btnInformeAuditoria', {
                text : 'Datos Generales',
                iconCls : 'bballot', /*'bballot','block','bgood','block'*/
                disabled : false,
                handler : this.onBtnInformeAuditoria,
                tooltip : '<b>Registrar datos generales de Auditoria</b>'
            });
            this.addButton('btnExamples', {
                text : 'Examples',
                iconCls : 'bballot', /*'bballot','block','bgood','block'*/
                disabled : false,
                handler : this.onBtnExamples,
                //handler : this.validarEstado,
                tooltip : '<b>Registrar datos generales de Auditoria</b>'
            });
            this.addButton('btnEjecutar', {
                text : 'Ejecutar',
                iconCls : 'bgood',/*'badelante','bballot','block','block','bwrong','bok'*/
                disabled : false,
                handler : this.sigEstadoAutomatico,
                tooltip : '<b>Establecer planificacion</b>'
            });
            this.addButton('btnInforme', {
                text : 'Informe',
                iconCls : 'bgood',/*'badelante','bballot','block','block','bwrong','bok'*/
                disabled : false,
                handler : this.sigEstadoAutomatico,
                tooltip : '<b>Establecer planificacion</b>'
            });
            this.addButton('btnAuditSummary', {
                text : 'Resumen',
                iconCls : 'bballot', /*'bballot','block','bgood','block'*/
                disabled : false,
                handler : this.onBtnAuditSummary,
                tooltip : '<b>Resumen de Auditoria</b>'
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

            /*this.addButton('btnNotificaInformeAuditoria', {
                text : 'Notificar Informe',
                iconCls : 'badelante', /*'bballot','block','bgood','block'*/
                /*disabled : false,
                handler : this.onBtnNotificaInformeAuditoria,
                tooltip : '<b>Notificar Informe de Auditoria</b>'
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
            //this.getBotonEjecutar('ejecutada');
            //this.getBoton('btnInforme').hide();
            //this.TabPanelSouth.getItem(this.idContenedor + '-south-0').setDisabled(true);
        },

        /*gruposBarraTareas:[{name:'borrador',title:'<H1 align="center"><i class="fa fa-thumbs-o-down"></i> Borradores</h1>',grupo:0,height:0},
            {name:'proceso',title:'<H1 align="center"><i class="fa fa-eye"></i> Iniciados</h1>',grupo:1,height:0},
            {name:'finalizados',title:'<H1 align="center"><i class="fa fa-thumbs-o-up"></i> Finalizados</h1>',grupo:2,height:0}],*/


        arrayDefaultColumHidden:[/*'documento',*/'codigo_aom','id_tipo_om','id_gconsultivo','nombre_aom2',/*'lugar',/*/'descrip_aom2',/*'fecha_prev_inicio','fecha_prev_fin',*/
            /*'id_tnorma','id_tobjeto'*/,'resumen','recomendacion','formulario_ingreso','estado_form_ingreso',
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
        getBotonEjecutar: function(name){

            this.addButton('btnQuesito', {
                text : this.getNombre(name),
                iconCls : 'bballot', /*'bballot','block','bgood','block'*/
                disabled : false,
                handler : this.onBtnInformeAuditoria,
                tooltip : '<b>Registrar datos generales de Auditoria</b>'
            });

        },
        getNombre: function(v_name){
            if(v_name=='plani_aprob'){
                return 'Ejecutar';
            }
            if(v_name=='ejecutada'){
                return 'Informe';
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
            }, {data:rec.data, interfaz: 'vob' }, this.idContenedor, 'FormSummaryAudit');
            //this.store.baseParams.id_tipo_auditoria = 1;{data:rec.data, contenedor: this.idContenedor }
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
        onBtnInformeAuditoria: function(){
            var data = this.getSelectedData();

            //if(data.estado_wf == 'plani_aprob' || data.estado_wf == 'ejecutada' || data.estado_wf == 'informe'){
                //console.log("dadita:>",data);
                this.onButtonEdit();
                this.formInformeAuditoria();
            /*}
            else{
                alert('La Auditoria ya ha sido remitido el informe, ya no es posible modificar.!!!');
            }*/

        },
        onButtonNoConformidades: function(){
            var rec = this.sm.getSelected();  //los valores del registro seleccionado
			if (rec.data === undefined){
				alert('Seleccione un registro');
            }
			console.log ('Data',rec.data);
			Phx.CP.loadWindows('../../../sis_auditoria/vista/no_conformidad/NoConformidadGestion.php', 'Gestion No conformidades',{
                //modal : true,
                width:'90%',
                height:'90%'
            }, rec.data,this.idContenedor, 'NoConformidadGestion'); // clase de la vista hijo

        },
        /*onButtonEdit: function () {
            Phx.vista.InformeAuditoria.superclass.onButtonEdit.call(this);
            this.formInformeAuditoria();
        },*/
        EnableSelect: function(){
            Phx.vista.InformeAuditoria.superclass.EnableSelect.call(this);
            var data = this.getSelectedData();
            //console.log("valor de getSelected-->",this.getSelectedData().estado_wf);///*||(this.getSelectedData() && this.getSelectedData().estado_wf== "ejecutada"*/
            if((this.getSelectedData() && this.getSelectedData().estado_wf=="plani_aprob") ) {
                this.TabPanelSouth.getItem(this.idContenedor + '-south-0').setDisabled(true);
            }
            else{
                this.TabPanelSouth.getItem(this.idContenedor + '-south-0').setDisabled(false);
            }
        },
        /**
         * ======================================================================
         * =====================< worflow Process start >========================
         * ======================================================================
         * */

        sigEstadoAutomatico: function(){
            var data = this.getSelectedData();
            console.log("valor del id aom -->",data.id_aom);
            //alert("Entra sigEstadoAutomatico:",data.id_aom);
            if(confirm("Usted esta seguro de ejecutar la Auditoria ?")){
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/verificarPlanificacion',
                    params:{/*start:0, limit:50,*/
                        'p_id_aom': data.id_aom,
                        'p_lugar': data.lugar,
                        'p_id_tnorma': data.id_tnorma,
                        'p_id_tobjeto':data.id_tobjeto,
                        'p_fecha_eje_inicio': data.fecha_eje_inicio,
                        'p_fecha_eje_fin': data.fecha_eje_fin
                    },
                    //dataType:"JSON",
                    //success:this.success,
                    success:function (resp) {
                        //var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                        console.log("Valor del funcion success:",resp);
                        this.reload();
                    },
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
            }

        },
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
            Phx.vista.InformeAuditoria.superclass.preparaMenu.call(this);

            this.getBoton('btnPlanificarAudit').enable();
            this.getBoton('btnInformeAuditoria').enable();

            if(data.estado_wf == 'plani_aprob'){
                this.getBoton('btnInforme').hide();
                this.getBoton('btnEjecutar').show();
                this.getBoton('btnEjecutar').enable();
            }
            if(data.estado_wf == 'ejecutada'){
                this.getBoton('btnEjecutar').hide();
                this.getBoton('btnInforme').show();
                this.getBoton('btnInforme').enable();
            }

            this.getBoton('btnAuditSummary').enable();
            this.getBoton('btnAuditRecomendation').enable();
			this.getBoton('NoConformidades').enable();

			if(data.estado_wf == 'informe'){
                this.getBoton('sig_estado').enable();
            }
			this.getBoton('diagrama_gantt').enable();
        },
        liberaMenu:function(n){
            //var data = this.getSelectedData();
            //console.log('valor n de liberaMenu:',n);
            Phx.vista.InformeAuditoria.superclass.liberaMenu.call(this);
            this.getBoton('btnPlanificarAudit').hide();

            this.getBoton('btnInformeAuditoria').disable();

            this.getBoton('btnEjecutar').disable();
            this.getBoton('btnInforme').disable();
            this.getBoton('btnAuditSummary').disable();
            this.getBoton('btnAuditRecomendation').disable();

            this.getBoton('NoConformidades').disable();
            this.getBoton('sig_estado').disable();
            this.getBoton('diagrama_gantt').disable();
        },
        formInformeAuditoria: function () {
            this.ocultarComponente(this.Cmp.documento);
            this.ocultarComponente(this.Cmp.codigo_aom);

            this.ocultarComponente(this.Cmp.nombre_aom1);
            this.ocultarComponente(this.Cmp.descrip_aom1);
            this.ocultarComponente(this.Cmp.id_funcionario);

            this.ocultarComponente(this.Cmp.resumen);
            this.ocultarComponente(this.Cmp.recomendacion);

            this.ocultarComponente(this.Cmp.id_tipo_om);
            this.ocultarComponente(this.Cmp.id_gconsultivo);
            this.ocultarComponente(this.Cmp.id_proceso_wf);
            this.ocultarComponente(this.Cmp.id_estado_wf);
            this.ocultarComponente(this.Cmp.estado_wf);

            this.ocultarComponente(this.Cmp.nombre_estado);
            this.ocultarComponente(this.Cmp.formulario_ingreso);
            this.ocultarComponente(this.Cmp.estado_form_ingreso);

            //Muestra los campos de formulario de programacion de Auditoria

            this.mostrarComponente(this.Cmp.nro_tramite_wf);
            this.Cmp.nro_tramite_wf.disable(true);
            this.mostrarComponente(this.Cmp.id_tipo_auditoria);
            this.Cmp.id_tipo_auditoria.disable(true);
            this.mostrarComponente(this.Cmp.id_uo);
            this.Cmp.id_uo.disable(true);
            this.mostrarComponente(this.Cmp.nombre_aom2);
            this.Cmp.nombre_aom2.disable(true);
            this.mostrarComponente(this.Cmp.lugar);
            this.Cmp.lugar.disable(true);
            this.mostrarComponente(this.Cmp.descrip_aom2);
            this.Cmp.descrip_aom2.disable(true);
            this.mostrarComponente(this.Cmp.id_tnorma);
            this.Cmp.id_tnorma.disable(true);
            this.mostrarComponente(this.Cmp.id_tobjeto);
            this.Cmp.id_tobjeto.disable(true);


            this.mostrarComponente(this.Cmp.fecha_prog_inicio);
            this.Cmp.fecha_prog_inicio.disable(true);
            this.mostrarComponente(this.Cmp.fecha_prog_fin);
            this.Cmp.fecha_prog_fin.disable(true);

            this.mostrarComponente(this.Cmp.fecha_prev_inicio);
            this.Cmp.fecha_prev_inicio.disable(true);
            //this.Cmp.fecha_prev_inicio.grid = false;
            this.mostrarComponente(this.Cmp.fecha_prev_fin);
            this.Cmp.fecha_prev_fin.disable(true);
            this.mostrarComponente(this.Cmp.fecha_eje_fin);

            this.mostrarComponente(this.Cmp.fecha_eje_inicio);

        },
        onBtnExamples: function(){
            var rec = this.sm.getSelected();  //los valores del registro seleccionado

            console.log ('Data',rec.data);
            Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/Form.php', 'Formulario examples',{
                //modal : true,
                width:'90%',
                height:'90%'
            }, rec,this.idContenedor, 'Form'); // clase de la vista hijo

        },

    };
</script>
