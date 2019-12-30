<?php
/**
 *@package pXP
 *@file ProgramarAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 13-08-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.ProgramarAuditoria = {

        pId_param_config:'',
        pGestion: '',
        pFecha_a: '',
        pFecha_b: '',
        pPrefijo: '',
        pSerie: '',

        bedit:true,
        bnew:true,
        bsave:false,
        bdel:true,
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:' :: Formulario Registro de Auditoria - Oportunidad Mejora',
        nombreVista: 'ProgramarAuditoria',

        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            this.initButtons=[this.cmbTipoAuditoria];
            Phx.vista.ProgramarAuditoria.superclass.constructor.call(this,config);
            this.init();
            this.load({params:{start:0, limit:this.tam_pag,v_tpo_audit:'Todos', v_estado_wfp: 'programado', v_estado_wfp1:'vob_programado', v_estado_wfp2:'observado',v_estado_wfp3:'prog_aprob' /*, v_tipo_auditoria:'AI'*/}});
            this.getBoton('btnPlanificarAudit').hide();
            this.getBoton('btnInformeOM').hide();
            this.getBoton('btnHelpAOM').hide();

            /*this.addButton('ant_estado', {
                argument: {estado: 'anterior'},
                text:'Anterior',
                grupo:[0,2],
                iconCls: 'batras',
                disabled:true,
                handler:this.antEstado,
                tooltip: '<b>Pasar al Anterior Estado</b>'
            });*/
            /*this.addButton('btnObs',{//#11
                text :'Obs Wf',
                grupo:[0,1,2],
                iconCls : 'bchecklist',
                disabled: true,
                handler : this.onOpenObs,
                tooltip : '<b>Observaciones</b><br/><b>Observaciones del WF</b>'
            });*/
            this.addButton('sig_estado',{
                text:'Siguiente',
                grupo:[0,2],
                iconCls: 'badelante',
                disabled: true,
                handler: this.sigEstado,
                tooltip: '<b>Pasar al Siguiente Estado</b>'
            });
            this.cmbTipoAuditoria.on('select', function(){
                if(this.validarFiltros()){
                    this.capturaFiltros();
                }

            },this);
            this.addBotonesGantt();

        },
        tam_pag:50,
        cmbTipoAuditoria:new Ext.form.ComboBox({
            fieldLabel: 'id_tipo_auditoria',
            allowBlank: true,
            emptyText:'Tipo Auditoria...',
            store:new Ext.data.JsonStore( {
                    url: '../../sis_auditoria/control/TipoAuditoria/filtroTipoAuditoria',
                    id: 'id_tipo_auditoria',
                    root: 'datos',
                    sortInfo:{
                        field: 'tipo_auditoria',
                        direction: 'DESC'
                    },
                    totalProperty: 'total',
                    fields: ['id_tipo_auditoria','tipo_auditoria','codigo_tpo_aom'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'tipo_auditoria', estado:'activo', _adicionar : 'si'}
                }),
            valueField: 'codigo_tpo_aom',
            triggerAction: 'all',
            displayField: 'tipo_auditoria',
            hiddenName: 'id_tipo_auditoria',
            mode:'remote',
            pageSize:50,
            queryDelay:500,
            listWidth:'250',
            width:250
        }),
        capturaFiltros:function(combo, record, index){
            this.desbloquearOrdenamientoGrid();
            //console.log("kjkkkk",this.cmbTipoAuditoria.getValue());
            this.store.baseParams.v_tpo_audit = this.cmbTipoAuditoria.getValue();

            this.store.baseParams.v_estado_wfp = 'programado';
            this.store.baseParams.v_estado_wfp1 = 'vob_programado';
            this.store.baseParams.v_estado_wfp2 = 'observado';
            this.store.baseParams.v_estado_wfp3 = 'prog_aprob';

            //this.load({params:{start:0, limit:this.tam_pag,v_tpo_audit:'AI', v_estado_wfp: 'programado', v_estado_wfp1:'vob_programado', v_estado_wfp2:'observado',v_estado_wfp3:'prog_aprob' /*, v_tipo_auditoria:'AI'*/}});
            this.load();
        },
        validarFiltros:function(){
            if(this.cmbTipoAuditoria.isValid()){
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
                this.store.baseParams.v_tpo_audit = this.cmbTipoAuditoria.getValue();
                this.store.baseParams.v_estado_wfp = 'programado';
                this.store.baseParams.v_estado_wfp1 = 'vob_programado';
                this.store.baseParams.v_estado_wfp2 = 'observado';
                this.store.baseParams.v_estado_wfp3 = 'prog_aprob';

                Phx.vista.ProgramarAuditoria.superclass.onButtonAct.call(this);
            }
        },
        arrayDefaultColumHidden:[/*'documento',*/'codigo_aom','id_gconsultivo','nombre_aom2','lugar','descrip_aom2','fecha_prev_inicio','fecha_prev_fin',
            'id_tnorma','id_tobjeto','resumen','recomendacion','fecha_eje_inicio','fecha_eje_fin',
            'formulario_ingreso','id_proceso_wf','id_estado_wf','estado_form_ingreso','usuario_ai'],
        /*********************************###################*********************************/
        onButtonNew: function () {
            Phx.vista.ProgramarAuditoria.superclass.onButtonNew.call(this);
            this.eventFormAOM();

            //this.Ext.getCmp('Auditoria - Oportunidad Mejora').Atributos.columns[2].setVisible(false);

            var fecha = new Date();
            var gestion = fecha.getFullYear();
            var separator = "-";
            var codigoAOM = "";

            var codigoAom = "";
            var lastCodigoAuditRecord = "";

            var tipoAuditoria = "";
            //this.Cmp.id_tipo_auditoria.on('select',function(combo, record, index){
            //this.Cmp.id_uo.store.baseParams.id_fun = record.data.id_funcionario;
            //this.Cmp.id_uo.store.baseParams.fecha_doc = this.getComponente('fecha_documento').value;
            //console.log("Valor de resp de ajax========>>>>>>");
            //Phx.CP.loadingShow();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/getLastAuditRecord',
                params:{start:0, limit:1},
                dataType:"JSON",
                success:function (resp) {
                    var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    console.log("reg->",reg.datos);
                    console.log("tamaño de reg->",reg.datos.length);
                    //codigoAom = "";
                    if(reg.datos.length==1){
                        codigoAom = reg.datos[0].codigo_aom;
                        console.log("valor de codigoAom--->",codigoAom);
                        lastCodigoAuditRecord = codigoAom.split("-");
                        //var tpo = this.Cmp.id_tipo_auditoria.store.baseParams.id_tipo = record.data.tipo_auditoria;
                        //tipoAuditoria = tpo.toUpperCase();
                        console.log("Entra al if del boton New==>",codigoAom);
                        codigoAOM = lastCodigoAuditRecord[0] + separator + lastCodigoAuditRecord[1] + separator + "R" + this.generarSerieAOM(codigoAom);
                        console.log(" Nuevo Codigo Auditoria Interna =>",codigoAOM);
                        this.Cmp.codigo_aom.setValue(codigoAOM);
                    }
                    else{
                        console.log("=======================================================");
                        console.log("   En caso que no exista ningun registro de AOM        ");
                        console.log("=======================================================");
                        Ext.Ajax.request({
                            url:'../../sis_auditoria/control/ParametroConfigAuditoria/listarParametroConfigAuditoria',
                            params:{start:0, limit:this.tam_pag},
                            dataType:"JSON",
                            success:function (resp) {
                                var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));

                                if(reg.datos.length == 1){
                                    //console.log('WWWWWWWW->',this.Cmp.id_tipo_auditoria.store.baseParams.id_fun = record.data.id_tipo_auditoria);
                                    //console.log('WWWWWWWW->',this.Cmp.id_tipo_auditoria.store.baseParams.id_tipo = record.data.tipo_auditoria);
                                    //var tpo = this.Cmp.id_tipo_auditoria.store.baseParams.id_tipo = record.data.tipo_auditoria;

                                    this.pGestion = reg.datos[0].param_gestion;
                                    this.pPrefijo = reg.datos[0].param_prefijo;
                                    this.pSerie = reg.datos[0].param_serie;
                                    console.log("valor de: Gestion, Prefijo y Serie=<>",this.pGestion,this.pPrefijo,this.pSerie);
                                    codigoAom = this.pPrefijo + separator + "T"+ this.pGestion + separator + "R" + this.pSerie;
                                    codigoAOM = this.pPrefijo + separator + "T"+ this.pGestion + separator + "R" + this.generarSerieAOM(codigoAom);
                                    console.log(" Nuevo Codigo Auditoria Interna=>",codigoAOM);
                                    this.Cmp.codigo_aom.setValue(codigoAOM);

                                }
                                else{
                                    alert("No hay Parametros de Condiguracion inicial o estan vencidos o hay mas registros de configuracion validos, por favor verifique.");
                                }
                                console.log("Formato JSON-->",reg);

                            },
                            failure: this.conexionFailure,
                            timeout:this.timeout,
                            scope:this
                        });
                    }

                },
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
            //console.log("Aquel", aquel);
            //console.log("pId_param_config=",this.pId_param_config,";pGestion =",this.pGestion,";pFecha_a=",this.pFecha_a,";pFecha_b=",this.pFecha_b, ";pSerie=",this.pSerie);

            //},this);
            this.Cmp.id_funcionario.on('select',function (combo, record, index) {
                console.log("jjjjjjjjjjjjjjj",record.data)
            });
        },
        eventFormAOM: function () {
            //this.formAuditoria();
            this.formProgramarAuditoria();
            //this.formOportunidadMejora();
            this.Cmp.id_tipo_auditoria.on('select',function (combo,record,index) {
                console.log('combo',combo, 'record',record, 'index',index);
                if(record.data.tipo_auditoria === 'AUDITORIA INTERNA'){
                    this.Cmp.id_tipo_om.setValue("");
                    this.Cmp.id_gconsultivo.setValue("");
                    //this.formAuditoria();
                    this.formProgramarAuditoria();
                }
                if(record.data.tipo_auditoria === 'OPORTUNIDAD MEJORA'){
                    //this.formOportunidadMejora();
                    this.formProgramarOportunidadMejora();
                }
                /*if(record.data.tipo_auditoria === 'EJECUCION'){
                    this.eventoResult();
                }*/
            },this);
        },
        /***********************************################*******************************/
        onButtonEdit:function(){
            var data = this.getSelectedData();
            //console.log("qqqqqq  valor de data:<>",data.estado_wf);
            if(data.estado_wf == 'programado' || data.estado_wf == 'observado'){
                console.log("hOLA ENTRA ");
                if(data.tipo_auditoria == "AUDITORIA INTERNA"){
                    Phx.vista.ProgramarAuditoria.superclass.onButtonEdit.call(this);
                    this.formProgramarAuditoria();
                    this.Cmp.id_tipo_auditoria.disable();
                }
                else{
                    if(data.tipo_auditoria == "OPORTUNIDAD MEJORA"){
                        Phx.vista.ProgramarAuditoria.superclass.onButtonEdit.call(this);
                        this.formProgramarOportunidadMejora();
                        this.Cmp.id_tipo_auditoria.disable();
                    }
                }
            }
            else{
                if(data.tipo_auditoria == "AUDITORIA INTERNA"){
                    //alert('La Auditoria ya esta en etapa de Planificación, ya no es posible modificar.!!!');
                    Ext.Msg.alert("status","La Auditoria ya esta en etapa de Planificación, ya no es posible modificar.!!!");
                }
                else{
                    //alert('La Auditoria ya ha sido esta en etapa de Informe, ya no es posible modificar.!!!');
                    Ext.Msg.alert("status","La Auditoria ya esta en etapa de Informe, ya no es posible modificar.!!!");
                }
            }

        },
        /**
         * ======================================================================
         * =====================< worflow Process start >========================
         * ======================================================================
         * */
        sigEstado:function(){
            var seleccionados = this.sm.getSelections(); /// multi selecion en la grilla
            console.log(seleccionados);

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
        /*==================================< End worflow method >=====================================*/
        preparaMenu:function(n){
            var data = this.getSelectedData();
            Phx.vista.ProgramarAuditoria.superclass.preparaMenu.call(this);
            //this.getBoton('btnPlanificarAudit').enable();

            //this.getBoton('ant_estado').enable();
            if(data.estado_wf=='vob_programado' || data.estado_wf=='prog_aprob'){
                this.getBoton('sig_estado').disable();
            }
            else{
                this.getBoton('sig_estado').enable();
            }
            this.getBoton('diagrama_gantt').enable();
            //this.getBoton('btnObs').enable();

        },
        liberaMenu:function(n){
            //var data = this.getSelectedData();
            Phx.vista.ProgramarAuditoria.superclass.liberaMenu.call(this);

            this.getBoton('sig_estado').disable();
            this.getBoton('diagrama_gantt').disable();
            //this.getBoton('btnObs').disable();

        },
        formProgramarAuditoria: function () {
            //Muestra formulario de Auditoria

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


            this.ocultarComponente(this.Cmp.nombre_estado);
            this.ocultarComponente(this.Cmp.formulario_ingreso);
            this.ocultarComponente(this.Cmp.estado_form_ingreso);

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
            //Muestra Formulario de Registro de Auditoria

            this.ocultarComponente(this.Cmp.documento);
            this.ocultarComponente(this.Cmp.codigo_aom);

            //this.ocultarComponente(this.Cmp.id_gconsultivo);

            this.ocultarComponente(this.Cmp.nombre_aom2);
            this.ocultarComponente(this.Cmp.lugar);
            this.ocultarComponente(this.Cmp.descrip_aom2);
            this.ocultarComponente(this.Cmp.fecha_prev_inicio);
            //this.Cmp.fecha_prev_inicio.setValue(this.fecha_prog_inicio);
            this.ocultarComponente(this.Cmp.fecha_prev_fin);
            //this.Cmp.fecha_prev_fin.setValue(this.fecha_prog_fin);
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


            this.ocultarComponente(this.Cmp.nombre_estado);
            this.ocultarComponente(this.Cmp.formulario_ingreso);
            this.ocultarComponente(this.Cmp.estado_form_ingreso);


            //Muestra los campos de formulario de programacion de Auditoria

            this.mostrarComponente(this.Cmp.id_tipo_auditoria);
            this.Cmp.codigo_aom.disable(true);
            this.mostrarComponente(this.Cmp.id_tipo_om);
            this.mostrarComponente(this.Cmp.id_uo);
            this.mostrarComponente(this.Cmp.nombre_aom1);
            this.mostrarComponente(this.Cmp.descrip_aom1);

            this.mostrarComponente(this.Cmp.fecha_prog_inicio);
            this.mostrarComponente(this.Cmp.fecha_prog_fin);

        },
        generarSerieAOM: function(cod_aom){
            var _cod_aom = cod_aom.toUpperCase();
            var palabras = _cod_aom.split("-");
            //var serie_defecto = '0000';
            //console.log('askaskdfasfd',palabras);
            console.log("palabras lenght:",palabras.length);
            var _serie = palabras[palabras.length-1];
            console.log("valor de la serie:",_serie);
            var array_serie = _serie.split("");

            console.log('serie->',array_serie);
            var ceros  = Array();
            var dif_ceros = Array();
            var count_ceros = 0;
            var count_dif_ceros = 0;
            var flag_ceros = false;
            var new_serie = 0;
            for(var i = 0; i < array_serie.length; i++){

                if(array_serie[i+1] == 0 && flag_ceros == false){
                    ceros[count_ceros] = array_serie[i+1];
                    console.log('Array Ceros','[',count_ceros,']','->',ceros[count_ceros], 'length Ceros',ceros.length);
                    count_ceros = count_ceros + 1;
                }
                else{
                    if((array_serie[i+1] !="" || flag_ceros == true) && ((ceros.length + dif_ceros.length) < array_serie.length-1) ){
                        dif_ceros[count_dif_ceros] = array_serie[i+1];
                        console.log('Array Dif-ceros->','[',count_dif_ceros,']','->',dif_ceros[count_dif_ceros],'length Dif_ceros',dif_ceros.length);
                        count_dif_ceros = count_dif_ceros + 1;
                        flag_ceros = true;
                    }
                }
            }
            if(dif_ceros.length > 0){
                for(var j = 0; j < dif_ceros.length; j++){
                    new_serie = parseInt((new_serie *10))+ parseInt(dif_ceros[j]);
                    console.log('serie actual if->',new_serie);
                }
            }
            else{
                //new_serie = parseInt(serie_defecto);
                console.log(" entra al else->",new_serie);
            }

            var nserie = ''+ (new_serie + 1);
            var base = ceros.length + dif_ceros.length;
            console.log("Lenght base:",base);
            console.log("Lenght ceros:",ceros.length);
            console.log("Lenght Dif ceros:",dif_ceros.length);
            return this.getCeros(base,nserie)+nserie;
        },
        getCeros: function (base, nvalor) {
            var cant_ceros = '';
            var b = base;
            //var caracter = '' + parseInt(nvalor);
            //console.log('caracter', caracter);
            var nv = nvalor.split("");
            console.log("base->",b, "valor lengthwww->",nv.length, "array->",nv);
            if(nv.length > 0){
                for(var j = 0; j < (b-nv.length); j++ ){
                    cant_ceros = cant_ceros + "0";
                }
            }

            return cant_ceros;
        },
        getArrayWords: function (words='hola que tal el') {
            var _words = words.toUpperCase();
            console.log('mayus->',_words);
            var count = 0;
            var word_aux = new Array();
            var p = '';
            var palabras = _words.split(" ");
            for(var i=0; i < palabras.length; i++){

                if(palabras[i]!= " "){
                    //word_aux = new Array();
                    console.log('palabra_igggg->',palabras[i]);
                    var x = this.esArticulo(palabras[i]);
                    console.log('valor de bandera->',x);
                    if(this.esArticulo(palabras[i])== false){
                        word_aux[count] = palabras[i];
                        count = count + 1;
                    }
                }
                console.log('aux size->',word_aux.length);
            }

            console.log('palabra size->',word_aux.length);
            console.log('Array words->',word_aux);
            return word_aux;
        },
        esArticulo: function (palabra) {
            var articulo = ["EL","LA","LAS","LOS","DE"];
            var flag = false;
            for(var i=0; i<articulo.length; i++){
                if(articulo[i] == palabra){
                    flag = true;
                }
            }
            return flag;
        },
        iniciarEventos: function () {
            //var data = this.getSelectedData();   var rec = this.sm.getSelected();
            /* A TOMAR EN CUENTA LOS SIGUIENTES TIPOS Y SUB-TIPOS PARA GENERACION DE CODIGOS
                TIPO AUDITORIA:
                    AUDITORIA INTERNA:
                        AUDITORIA INTERNA: COD-> AI-Y2019-S0001
                    OPORTUNIDAD MEJORA:
                        AUDITORIA EXTERNA: COD-> AE-Y2019-S0001
                        GRUPO DE ANALISIS DE FALLAS: COD-> GAF-Y2019-S0001
                        INSPECCION: COD-> INS-Y2019-S0001
                        OPORTUNIDAD DE MEJORA: COD-> OM-Y2019-S0001
                        REVISION: COD -> REV-Y2019-S0001
            */

            //var cod_pruebas = 'INS-Y2019-S0045';

            var fecha = new Date();
            var gestion = fecha.getFullYear();
            var separator = "-";
            var codigoAOM = "";

            var codigoAom = "";
            var lastCodigoAuditRecord = "";

            var tipoAuditoria = "";

            this.Cmp.id_tipo_auditoria.on('select',function(combo, record, index){
                //Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/getLastAuditRecord',
                    params:{start:0, limit:1},
                    dataType:"JSON",
                    success:function (resp) {
                        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                        console.log("reg->",reg.datos);
                        console.log("tamaño de reg->",reg.datos.length);
                        //codigoAom = "";
                        if(reg.datos.length>0){
                            codigoAom = reg.datos[0].codigo_aom;
                            console.log("valor de codigoAom--->",codigoAom);
                            lastCodigoAuditRecord = codigoAom.split("-");
                            var tpo = this.Cmp.id_tipo_auditoria.store.baseParams.id_tipo = record.data.tipo_auditoria;
                            tipoAuditoria = tpo.toUpperCase();

                            if(tipoAuditoria == "AUDITORIA INTERNA"){

                                codigoAOM = this.getPrefijo(tipoAuditoria) + separator + lastCodigoAuditRecord[1] + separator + "S" + this.generarSerieAOM(codigoAom);
                                console.log(" Nuevo Codigo Auditoria Interna =>",codigoAOM);
                                this.Cmp.codigo_aom.setValue(codigoAOM);

                            }
                            else{
                                if(tipoAuditoria == "OPORTUNIDAD MEJORA"){
                                    codigoAOM = "";
                                    this.Cmp.codigo_aom.reset();
                                    //console.log("Nuevo Codigo Generado else=>",codigoAOM);
                                    this.Cmp.id_tipo_om.on('select',function(combo, record, index){
                                        var taom = this.Cmp.id_tipo_om.store.baseParams.tipo_om = record.data.id_parametro;
                                        var valor_tipo = this.Cmp.id_tipo_om.store.baseParams.tipo_om = record.data.valor_parametro;
                                        var valor_tipo_om = valor_tipo.toUpperCase();

                                        //console.log("limpiar codigo generado-->",this.Cmp.codigo_aom.setValue(""),"id_param_config_aom=>",this.Cmp.id_param_config_aom.store.baseParams.id_param_config_aom = record.data.id_param_config_aom);
                                        codigoAOM = this.getPrefijo(valor_tipo_om) + separator + lastCodigoAuditRecord[1] + separator + "S" + this.generarSerieAOM(codigoAom);
                                        console.log("limpiar codigo OM-->Tipo OM-->",codigoAOM);
                                        this.Cmp.codigo_aom.setValue(codigoAOM);
                                    },this);
                                }
                            }

                        }
                        else{
                            console.log("========================================================================");
                            console.log("          En caso que no exista ningun registro de AOM                  ");
                            console.log("========================================================================");
                            Ext.Ajax.request({
                                url:'../../sis_auditoria/control/ParametroConfigAuditoria/listarParametroConfigAuditoria',
                                params:{start:0, limit:this.tam_pag},
                                dataType:"JSON",
                                success:function (resp) {

                                    var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                                    if(reg.datos.length>0){
                                        //console.log('WWWWWWWW->',this.Cmp.id_tipo_auditoria.store.baseParams.id_fun = record.data.id_tipo_auditoria);
                                        console.log('WWWWWWWW->',this.Cmp.id_tipo_auditoria.store.baseParams.id_tipo = record.data.tipo_auditoria);
                                        var tpo = this.Cmp.id_tipo_auditoria.store.baseParams.id_tipo = record.data.tipo_auditoria;
                                        //cod_pruebas = "Y"+eg.datos[0].param_gestion + separator + "S" + reg.datos[0].param_serie, this.pId_param_config = reg.datos[0].id_param_config_aom;
                                        this.pGestion =reg.datos[0].param_gestion;
                                        /*this.pFecha_a = reg.datos[0].param_fecha_a; this.pFecha_b = reg.datos[0].param_fecha_b;*/
                                        this.pSerie = reg.datos[0].param_serie;
                                        tipoAuditoria = tpo.toUpperCase();

                                        if(tipoAuditoria == "AUDITORIA INTERNA"){
                                            codigoAOM = this.getPrefijo(tipoAuditoria) + separator + "Y"+ this.pGestion + separator + "S" + this.generarSerieAOM(this.pSerie);
                                            console.log(" Nuevo Codigo Auditoria Interna=>",codigoAOM);
                                            this.Cmp.codigo_aom.setValue(codigoAOM);
                                        }
                                        else{

                                            if(tipoAuditoria == "OPORTUNIDAD MEJORA"){
                                                codigoAOM = "";
                                                this.Cmp.codigo_aom.reset();
                                                console.log("Nuevo Codigo Generado else=>",codigoAOM);
                                                this.Cmp.id_tipo_om.on('select',function(combo, record, index){
                                                    var taom = this.Cmp.id_tipo_om.store.baseParams.tipo_om = record.data.id_parametro;
                                                    var valor_tipo = this.Cmp.id_tipo_om.store.baseParams.tipo_om = record.data.valor_parametro;
                                                    var valor_tipo_om = valor_tipo.toUpperCase();

                                                    /*this.pGestion =reg.datos[0].param_gestion;
                                                    this.pSerie = reg.datos[0].param_serie;*/

                                                    //console.log("limpiar codigo-->",this.Cmp.codigo_aom.setValue(""),"id_param_config_aom=>",this.Cmp.id_param_config_aom.store.baseParams.id_param_config_aom = record.data.id_param_config_aom);
                                                    codigoAOM = this.getPrefijo(valor_tipo_om) + separator + "Y"+ this.pGestion + separator + "S" + this.generarSerieAOM(this.pSerie);
                                                    console.log("codigo OM -> tipo OM-->:", codigoAOM);
                                                    this.Cmp.codigo_aom.setValue(codigoAOM);

                                                },this);
                                            }
                                        }
                                    }
                                    else{
                                        alert("No hay Parametros de Condiguracion iniciales o estan vencidos, por favor verifique.");
                                    }
                                    console.log("Formato JSON-->",reg);

                                },
                                failure: this.conexionFailure,
                                timeout:this.timeout,
                                scope:this
                            });
                        }

                    },
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
                //console.log("Aquel", aquel);
                //console.log("pId_param_config=",this.pId_param_config,";pGestion =",this.pGestion,";pFecha_a=",this.pFecha_a,";pFecha_b=",this.pFecha_b, ";pSerie=",this.pSerie);

            },this);

        },
        getPrefijo: function (words) {

            var array_tipo_auditoria = "";
            var prefijo = "";

            array_tipo_auditoria = this.getArrayWords(words);

            if(array_tipo_auditoria.length > 1){
                for (var i = 0; i < array_tipo_auditoria.length; i++){
                    console.log("palabra i sss->",array_tipo_auditoria[i]);
                    var palabra = "" + array_tipo_auditoria[i];
                    var pfj = palabra.charAt(0);
                    prefijo = prefijo + pfj;
                }
            }
            else{
                for (var i = 0; i < array_tipo_auditoria.length; i++){
                    var palabra = "" + array_tipo_auditoria[i];
                    var pfj = palabra.substring(0,3);
                    prefijo = prefijo + pfj;
                }
            }
            return prefijo;
        },
       
};
</script>
