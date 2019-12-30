<?php
/**
 *@package pXP
 *@file PlanificarAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PlanificarAuditoria = {
    bedit:false,
    bnew:false,
    bsave:false,
    bdel:false,
    require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
    requireclase:'Phx.vista.AuditoriaOportunidadMejora',
    title: string = ' :: Formulario Planificacion de Auditoria',
    nombreVista: 'PlanificarAuditoria',
    v_global_id_tn: undefined,

    constructor: function(config) {
        this.idContenedor = config.idContenedor;
        Phx.vista.PlanificarAuditoria.superclass.constructor.call(this,config);
        this.init();
        this.load({params:{start:0, limit:this.tam_pag, v_estado_wfpl:'prog_aprob', v_estado_wfpl1:'planificacion', v_estado_wfpl2:'vob_planificacion',v_estado_wfpl3:'plan_observado',v_estado_wfpl4:'plani_aprob', v_tipo_auditoria:'AI'/*,v_codigo_estado:'PROGRAMM'*/}});
        this.getBoton('btnInformeOM').hide();
        this.getBoton('btnHelpAOM').hide();
        //this.verValores();
        //alert("ewerwertwet",Phx.CP.getPagina(this.idContenedorPadre).nombreVista);
        this.addButton('btnPlanificarAuditoria', {
            text : 'Datos Generales',
            iconCls : 'bchecklist', /*'bballot','block','bgood','block'*/
            disabled : false,
            handler : this.onBtnPlanificarAuditoria,
            tooltip : '<b>Planificar Auditoria</b>'
        });
        this.addButton('btnPlanificar', {
            text : 'Planificar',
            iconCls : 'bgood',/*'badelante','bballot','block','block','bwrong','bok'*/
            disabled : false,
            handler : this.sigEstadoAutomatico,
            tooltip : '<b>Establecer planificacion</b>'
        });
        this.addButton('sig_estado', {
            text : 'Siguiente',
            iconCls : 'badelante', /*'bballot','block','bgood','block','bwrong','bok'*/
            disabled : false,
            handler : this.sigEstado,
            tooltip : '<b>Notificar Auditoria Planificada</b>'
        });

        /*this.addButton('btnDeshacerPlanificacion', {
            text : 'Deshacer',
            iconCls : 'bchecklist',
            disabled : false,
            handler : this.onBtnDeshacerPlanificacion,
            tooltip : '<b>Deshacer Planificacion de Auditoria</b>'
        });*/
        this.addBotonesGantt();
        //Se desactiva el tab de Itinerario por defecto
        this.TabPanelSouth.getItem(this.idContenedor + '-south-0').setDisabled(true);
        this.TabPanelSouth.getItem(this.idContenedor + '-south-1').setDisabled(true);
        this.TabPanelSouth.getItem(this.idContenedor + '-south-2').setDisabled(true);
        this.TabPanelSouth.getItem(this.idContenedor + '-south-3').setDisabled(true);
    },
    arrayDefaultColumHidden:[/*'documento',*/'codigo_aom','id_tipo_om','id_gconsultivo','nombre_aom2'/*,'lugar'*/,'descrip_aom2',/*'fecha_prev_inicio','fecha_prev_fin',*/
        /*'id_tnorma','id_tobjeto'*/'resumen','recomendacion',/*'fecha_eje_inicio','fecha_eje_fin',*/
        'formulario_ingreso','estado_form_ingreso','usuario_ai','id_proceso_wf','id_estado_wf'],
    tabsouth:[
                {

                    url:'../../../sis_auditoria/vista/auditoria_proceso/AuditoriaProceso.php',
                    title:'Proceso(s)',
                    height:'45%',
                    width: '35%',
                    cls:'AuditoriaProceso'
                },
                {
                    url:'../../../sis_auditoria/vista/equipo_responsable/EquipoResponsable.php',
                    title:'Responsable(s)',
                    height:'45%',
                    width: '35%',
                    cls:'EquipoResponsable'
                },
                {
                    url:'../../../sis_auditoria/vista/auditoria_npn/AuditoriaNpn.php',
                    title:'Puntos de Norma',
                    height:'40%',
                    width: '60%',
                    cls:'AuditoriaNpn'
                },
                {
                    url:'../../../sis_auditoria/vista/cronograma/Cronograma.php',
                    title:'Cronograma',
                    height:'50%',
                    width: '40%',
                    cls:'Cronograma'
                },
                {
                    url:'../../../sis_auditoria/vista/aom_riesgo_oportunidad/AomRiesgoOportunidad.php',
                    title:'Riesgo Oportunidad',
                    height:'50%',
                    width: '40%',
                    cls:'AomRiesgoOportunidad'
                }
    ],
    /*onButtonEdit: function () {
        var data = this.getSelectedData();
        Phx.vista.PlanificarAuditoria.superclass.onButtonEdit.call(this);
        this.formPlanificarAuditoria();
    },*/
    /*verValores: function(){
        var padre = Phx.CP.getPagina(this.idContenedorPadre).nombreVista;
        alert("ggggggg", padre);
    },*/
    /**
     * ======================================================================
     * =====================< worflow Process start >========================
     * ======================================================================
     * */

    sigEstadoAutomatico: function(){
        var data = this.getSelectedData();
        console.log("valor del id aom -->",data.id_aom);
        //alert("Entra sigEstadoAutomatico:",data.id_aom);
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
                /*if(reg.datos.length>0){
                    //alert("Ya existe un Responsable, no es permitido tener mas...!!!");
                    Ext.Msg.alert("status","Ya existe un Responsable, no es permitido tener mas...!!!");

                    this.Cmp.id_funcionario.disable(true);
                    this.Cmp.obs_participante.disable(true);
                    this.Cmp.id_parametro.setValue(null);
                    this.Cmp.exp_tec_externo.setValue(null);
                }*/
                this.reload();
            },
            failure: this.conexionFailure,
            timeout:this.timeout,
            scope:this
        });

    },
    sigEstado:function(){
        var data = this.getSelectedData();

        //Se aumento
        configExtra = [],

        this.eventosExtra = function(obj){
            obj.Cmp.id_funcionario_wf.on('expand',function(field){
                obj.Cmp.id_funcionario_wf.store.baseParams.id_depto_wf = obj.Cmp.id_depto_wf.getValue();
                obj.Cmp.id_funcionario_wf.store.load({params:{start:0,limit:50},
                    callback : function (r) {
                        if (r.length > 0 ) {
                            obj.Cmp.id_funcionario_wf.setValue(r[0].data.id_funcionario_wf);
                        }

                    }, scope : obj
                });
            } ,this);

        };
        //Fin de aumento
        if(data.lugar != ""){
            this.objWizard = Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/FormEstadoWf.php',
                'Estado de Wf',
                {
                    modal:true,
                    width:700,
                    height:450
                }, {
                    configExtra: configExtra,
                    eventosExtra: this.eventosExtra,
                    data:{
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
        }
        else{
            //alert("Para notificar es necesario completar datos de planificacion...!!!");
            Ext.Msg.alert("status","Para notificar es necesario completar Datos Generales de Planificación...!!!");
        }

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
    EnableSelect: function(){
        Phx.vista.PlanificarAuditoria.superclass.EnableSelect.call(this);
        this.TabPanelSouth.getItem(this.idContenedor + '-south-0').setDisabled(true);
        this.TabPanelSouth.getItem(this.idContenedor + '-south-1').setDisabled(true);
        this.TabPanelSouth.getItem(this.idContenedor + '-south-2').setDisabled(true);
        this.TabPanelSouth.getItem(this.idContenedor + '-south-3').setDisabled(true);
        var data = this.getSelectedData();
        //data.codigo_tipo_cuenta_doc=='SOLVIA'
        console.log("valor de getSelected-->",this.getSelectedData());
        if(this.getSelectedData() && this.getSelectedData().lugar!="" /*&& this.getSelectedData().id_tnorma!=null && this.getSelectedData().id_tobjeto!=null*/) {
            this.TabPanelSouth.getItem(this.idContenedor + '-south-0').setDisabled(false);
            this.TabPanelSouth.getItem(this.idContenedor + '-south-1').setDisabled(false);
            this.TabPanelSouth.getItem(this.idContenedor + '-south-2').setDisabled(false);
            this.TabPanelSouth.getItem(this.idContenedor + '-south-3').setDisabled(false);
        }
    },
    preparaMenu:function(n){
        var data = this.getSelectedData();
        Phx.vista.PlanificarAuditoria.superclass.preparaMenu.call(this);
        this.getBoton('btnPlanificarAuditoria').enable();

        if(data.estado_wf == 'planificacion'){
            this.getBoton('sig_estado').enable();
        }

        if(data.estado_wf == 'prog_aprob'){
            this.getBoton('btnPlanificar').enable();
        }
        //this.getBoton('btnDeshacerPlanificacion').enable();
        this.getBoton('diagrama_gantt').enable();
    },
    liberaMenu:function(n){
        //var data = this.getSelectedData();
        Phx.vista.PlanificarAuditoria.superclass.liberaMenu.call(this);
        this.getBoton('btnPlanificarAudit').hide();
        this.getBoton('btnPlanificarAuditoria').disable();
        this.getBoton('sig_estado').disable();
        //this.getBoton('btnDeshacerPlanificacion').disable();
        this.getBoton('btnPlanificar').disable();
        this.getBoton('diagrama_gantt').disable();
    },
    onBtnPlanificarAuditoria: function () {
        //var d = this.sm.getSelected();
        var data = this.getSelectedData();
        //if(data.es_oportunidad == 0 || data.es_oportunidad == 1){
        if(data.estado_wf == 'prog_aprob' || data.estado_wf == 'planificacion' || data.estado_wf == 'plan_observado'){
            console.log("valor del titulo de auditoria:",data.nombre_aom1);
            this.onButtonEdit();
            this.Cmp.nombre_aom2.setValue(data.nombre_aom1);
            this.Cmp.descrip_aom2.setValue(data.descrip_aom1);
            this.Cmp.fecha_prev_inicio.setValue(data.fecha_prog_inicio);
            this.Cmp.fecha_prev_fin.setValue(data.fecha_prog_fin);
            //this.Cmp.nombre_aom2.disable(true);
            this.formPlanificarAuditoria();
        }
        else{
            alert('La Auditoria ya esta en la etapa de Ejecucion, ya no es posible modificar.!!!');
        }
    },
    formPlanificarAuditoria: function () {
        this.ocultarComponente(this.Cmp.documento);
        this.ocultarComponente(this.Cmp.codigo_aom);

        this.ocultarComponente(this.Cmp.resumen);
        this.ocultarComponente(this.Cmp.recomendacion);
        this.ocultarComponente(this.Cmp.id_tipo_om);
        this.ocultarComponente(this.Cmp.id_gconsultivo);

        this.ocultarComponente(this.Cmp.id_proceso_wf);
        this.ocultarComponente(this.Cmp.id_estado_wf);
        this.ocultarComponente(this.Cmp.nro_tramite_wf);
        this.ocultarComponente(this.Cmp.estado_wf);

        //Muestra los campos de formulario de programacion de Auditoria

        //=======================================================
        this.ocultarComponente(this.Cmp.nombre_aom1);
        this.ocultarComponente(this.Cmp.descrip_aom1);

        this.ocultarComponente(this.Cmp.id_funcionario);
        this.ocultarComponente(this.Cmp.fecha_prog_inicio);
        this.ocultarComponente(this.Cmp.fecha_prog_fin);

        this.ocultarComponente(this.Cmp.nombre_estado);
        this.ocultarComponente(this.Cmp.formulario_ingreso);
        this.ocultarComponente(this.Cmp.estado_form_ingreso);

        //=======================================================

        this.mostrarComponente(this.Cmp.id_tipo_auditoria);
        this.Cmp.id_tipo_auditoria.disable(true);
        this.mostrarComponente(this.Cmp.id_uo);
        this.Cmp.id_uo.disable(true);
        this.mostrarComponente(this.Cmp.nombre_aom2);
        this.Cmp.nombre_aom2.disable(true);

        this.mostrarComponente(this.Cmp.lugar);
        this.mostrarComponente(this.Cmp.descrip_aom2);
        this.mostrarComponente(this.Cmp.id_tnorma);
        this.mostrarComponente(this.Cmp.id_tobjeto);
        this.mostrarComponente(this.Cmp.fecha_prev_inicio);
        this.Cmp.fecha_prev_inicio.disable(true);
        this.mostrarComponente(this.Cmp.fecha_prev_fin);
        this.Cmp.fecha_prev_fin.disable(true);
        this.mostrarComponente(this.Cmp.fecha_eje_inicio);
        this.mostrarComponente(this.Cmp.fecha_eje_fin)

    },

};
</script>
