<?php
/**
 *@package pXP
 *@file VBAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 02-10-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.VBAuditoria = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:'VoB - Auditoria',
        nombreVista: 'VBAuditoria',

        /*gruposBarraTareas:[{name:'vob_programado',title:'<H1 align="center"><i class="fa fa-thumbs-o-down"></i> Programada</h1>',grupo:0,height:0},
            {name:'vob_planificacion',title:'<H1 align="center"><i class="fa fa-eye"></i> Planificada</h1>',grupo:1,height:0},
            {name:'vob_informe',title:'<H1 align="center"><i class="fa fa-thumbs-o-up"></i> Informe </h1>',grupo:2,height:0}],

        actualizarSegunTab: function(name, indice){
            console.log("sgsfljaslkdjfhlksjdf=>",name);
            if(this.finCons){
                this.store.baseParams.v_estado_wf = name;
                this.load({params:{start:0, limit:this.tam_pag}});
            }
        },
        beditGroups: [0,1,2,3],
        bdelGroups:  [0,1,2,3],
        bactGroups:  [0,1,2],
        //btestGroups: [0],
        bexcelGroups: [0,1,2],*/

        constructor: function(config) {
            this.initButtons=[this.cmbCodigoEstadoVB];
            Phx.vista.VBAuditoria.superclass.constructor.call(this,config);
            this.init();
            //this.store.baseParams.v_estado_wf = 'vob_programado'
            this.load({params:{start:0, limit:this.tam_pag, v_estado_wf:'vob_programado'/*, v_tipo_auditoria:'AI'*/}});
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
            this.addButton('btnChequeoDocumentosWf',
                {	text: 'Documentos',
                    iconCls: 'bchecklist',
                    disabled: true,
                    handler: this.loadCheckDocumentosPlanWf,
                    tooltip: '<b>Documentos de la No conformidad</b><br/>Subir los documentos de evidencia.'
                }
            );
            this.addButton('btnObs',{//#11
                text :'Obs Wf',
                grupo:[0,1,2],
                iconCls : 'bchecklist',
                disabled: true,
                handler : this.onOpenObs,
                tooltip : '<b>Observaciones</b><br/><b>Observaciones del WF</b>'
            });
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
            this.cmbCodigoEstadoVB.on('select', function(){

                if(this.validarFiltros()){
                    this.capturaFiltros();
                }

            },this);

        },
        tam_pag:50,
        cmbCodigoEstadoVB:new Ext.form.ComboBox({
            fieldLabel: 'id_tipo_estado',
            allowBlank: true,
            emptyText:'VoB Auditoria...',
            store:new Ext.data.JsonStore({
                //url: '../../sis_auditoria/control/TipoAuditoria/listarTipoAuditoria',
                url: '../../sis_auditoria/control/TipoAuditoria/listCodigoEstadoVoBAuditoria',
                id: 'id_tipo_estado',
                root: 'datos',
                sortInfo:{
                    field: 'id_tipo_estado',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_tipo_estado','id_tipo_proceso','codigo','nombre_estado','etapa'],
                // turn on remote sorting
                remoteSort: true,
                baseParams:{par_filtro:'codigo'}
            }),
            valueField: 'codigo',
            triggerAction: 'all',
            displayField: 'nombre_estado',
            hiddenName: 'id_tipo_estado',
            mode:'remote',
            pageSize:50,
            queryDelay:500,
            listWidth:'250',
            width:250
        }),
        capturaFiltros:function(combo, record, index){
            this.desbloquearOrdenamientoGrid();
            //console.log("kjkkkk",this.cmbCodigoEstadoVB.getValue());
            this.store.baseParams.v_estado_wf=this.cmbCodigoEstadoVB.getValue();
            console.log("combo tipo estado vob",this.cmbCodigoEstadoVB.getValue());
            this.load();
        },
        validarFiltros:function(){
            if(this.cmbCodigoEstadoVB.isValid()){
                return true;
            }
            else{
                return false;
            }

        },
        onButtonAct:function(){
            if(!this.validarFiltros()){
                alert('Especifique los filtros antes')
            }
            else{
                this.store.baseParams.v_estado_wf=this.cmbCodigoEstadoVB.getValue();
                Phx.vista.VBAuditoria.superclass.onButtonAct.call(this);
            }
        },
        arrayDefaultColumHidden:[/*'documento',*/'codigo_aom','nombre_aom2','lugar','descrip_aom2','fecha_prev_inicio','fecha_prev_fin',
            'id_tnorma','id_tobjeto','resumen','recomendacion','fecha_eje_inicio','fecha_eje_fin',
            'formulario_ingreso','estado_form_ingreso','usuario_ai'],

        /*onButtonEdit:function(){
            var data = this.getSelectedData();
            //console.log("qqqqqq  valor de data:<>",data.es_oportunidad);
            //if(data.es_oportunidad==0){
            if(data.estado_wf == 'programado'){
                if(data.tipo_auditoria == "AUDITORIA INTERNA"){
                    Phx.vista.VBAuditoria.superclass.onButtonEdit.call(this);
                    this.formProgramarAuditoria();
                    this.Cmp.id_tipo_auditoria.disable();
                }
                else{
                    if(data.tipo_auditoria == "OPORTUNIDAD MEJORA"){
                        Phx.vista.VBAuditoria.superclass.onButtonEdit.call(this);
                        this.formProgramarOportunidadMejora();
                        this.Cmp.id_tipo_auditoria.disable();
                    }
                }
            }
            else{
                if(data.tipo_auditoria == "AUDITORIA INTERNA"){
                    alert('La Auditoria ya esta Planificada, ya no es posible modificar.!!!');
                }
                else{
                    alert('La Auditoria ya ha sido emitida el Informe, ya no es posible modificar.!!!');
                }
            }

        },*/
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
        loadCheckDocumentosPlanWf:function(){
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
        },
        /*===================================<Fin method Worflow>======================================*/
        preparaMenu:function(n){
            var data = this.getSelectedData();
            Phx.vista.VBAuditoria.superclass.preparaMenu.call(this);
            //this.getBoton('btnPlanificarAudit').enable();

            //this.getBoton('btnNotificarAuditoriaProgramada').enable();
            this.getBoton('ant_estado').enable();
            this.getBoton('sig_estado').enable();

        },
        liberaMenu:function(n){
            //var data = this.getSelectedData();
            //console.log('valor n de liberaMenu:',n);
            Phx.vista.VBAuditoria.superclass.liberaMenu.call(this);
            //this.getBoton('btnNotificarAuditoriaProgramada').disable();
            this.getBoton('ant_estado').disable();
            this.getBoton('sig_estado').disable();

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
