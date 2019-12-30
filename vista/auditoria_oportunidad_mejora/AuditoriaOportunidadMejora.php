<?php
/**
*@package pXP
*@file gen-AuditoriaOportunidadMejora.php
*@author  (max.camacho)
*@date 17-07-2019 17:41:55
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AuditoriaOportunidadMejora=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.AuditoriaOportunidadMejora.superclass.constructor.call(this,config);
        this.init();
		this.load({params:{start:0, limit:this.tam_pag}});
        //this.iniciarEventos();
        //console.log("Verificador de generador de serie wwwww:",this.generarSerieAOM("R100000"));

        //this.store.baseParams.oportunidad = {oportunidad1: this.oportunidad};
        this.addButton('btnPlanificarAudit', {
            text : 'Planificar Auditoria',
            iconCls : 'bballot',
            disabled : false,
            handler : this.onBtnPlanificarAudit,
            tooltip : '<b>Perfil de Planificacion de Auditorias</b>'
        });
        this.addButton('btnInformeOM', {
            text : 'Informe de OM',
            iconCls : 'bballot',
            disabled : false,
            handler : this.onBtnInformeOM,
            tooltip : '<b>Perfil de Informe de Oportunidades de Mejora</b>'
        });
        this.addButton('btnHelpAOM', {
            text : 'Help',
            iconCls : 'bballot',
            disabled : false,
            handler : this.onBtnHelpAOM,
            tooltip : '<b>Perfil de Ayuda de Proceso de Registro, Planificacion de AOM</b>'
        });

	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_aom'
			},
			type:'Field',
			form:true 
		},
        {
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'estado_wf'
			},
			type:'Field',
			form:true
		},
        {
            config:{
                name: 'documento',
                fieldLabel: 'Documento',
                allowBlank: true,
                anchor: '80%',
                gwidth: 60,
                maxLength:150,
                renderer: function (value, p, record) {
                    var result;
                    console.log('Tipo Auditoria:',record.data['id_tipo_auditoria'])
                    if (record.data['id_tipo_auditoria'] == 1 || record.data['id_tipo_auditoria']== 2 ) {
                        result = String.format('{0}', "<div style='text-align:center'><img src = '../../../lib/imagenes/icono_dibu/dibu_checklist.png' align='center' width='35' height='35' title=''/></div>");
                    }
                    return result;
                }
            },
            type:'TextField',
            filters:{pfiltro:'aom.documento',type:'string'},
            //id_grupo:1,
            id_grupo:0,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'codigo_aom',
                fieldLabel: 'Codigo AOM',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:50
            },
            type:'TextField',
            filters:{pfiltro:'aom.codigo_aom',type:'string'},
            //id_grupo:1,
            id_grupo:0,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'nro_tramite_wf',
                fieldLabel: 'Nro. Tramite',
                allowBlank: true,
                anchor: '60%',
                gwidth: 150,
                maxLength:100
            },
            type:'TextField',
            filters:{pfiltro:'aom.nro_tramite_wf',type:'string'},
            id_grupo:0,
            grid:true,
            form:true
        },
        /*{
            config:{
                name: 'estado_wf',
                fieldLabel: 'Estado',
                allowBlank: true,
                anchor: '80%',
                gwidth: 130,
                maxLength:100,
                renderer: function (value, p, record) {
                    var result = '';
                    if(record.data.estado_wf=='programado'){
                        //result='<b><font color="burlywood">';
                        result='<b><font color="darkgray">';
                    }
                    else if (record.data.estado_wf=='vob_programado'){
                        //result='<b><font color="brown">';
                        //result='<b><font color="burlywood">';
                        result='<b><font color="red">';
                    }
                    else if (record.data.estado_wf=='planificacion'){
                        result='<b><font color="green">';
                    }
                    else if (record.data.estado_wf=='vob_planificacion'){
                        result='<b><font color="red">';
                    }
                    else if (record.data.estado_wf=='informe'){
                        result='<b><font color="green">';
                    }
                    else if (record.data.estado_wf=='vob_informe'){
                        result='<b><font color="red">';
                    }
                    result = result + value+'</font></b>';
                    return String.format('{0}', result);

                }
            },
            type:'TextField',
            filters:{pfiltro:'aom.estado_wf',type:'string'},
            id_grupo:1,
            grid:true,
            form:true

        },*/
        {
            config:{
                name: 'nombre_estado',
                fieldLabel: 'Estado',
                allowBlank: true,
                anchor: '80%',
                gwidth: 130,
                maxLength:100,
                renderer: function (value, p, record) {
                    console.log("lista de record->",record);
                    var result = '';
                    if(record.data.estado_wf=='programado'){
                        var result_aux_prog = '';
                        if(record.data.contador_estados >= 1){
                            //var result_aux='<b><font color="burlywood">';
                            result_aux_prog = '<b><font color="red">';
                        }
                        else{
                            result_aux_prog = '<b><font color="#D8D8D8">';
                        }
                        //result='<b><font color="#D8D8D8">';
                        result=result_aux_prog;
                    }
                    else if (record.data.estado_wf=='vob_programado'){
                        //result='<b><font color="brown">';
                        result='<b><font color="red">';
                    }
                    else if (record.data.estado_wf =='prog_aprob'){
                        //result='<b><font color="brown">';
                        result='<b><font color="green">';
                    }
                    else if (record.data.estado_wf =='observado'){
                        //result='<b><font color="brown">';
                        result='<b><font color="black">';
                    }
                    else if (record.data.estado_wf=='planificacion'){
                        var result_aux_plan = '';
                        if(record.data.contador_estados > 1){
                            result_aux_plan = '<b><font color="red">';
                        }
                        else{
                            result_aux_plan = '<b><font color="#006400">';
                        }
                        //result='<b><font color="#006400">';
                        result = result_aux_plan;
                    }
                    else if (record.data.estado_wf=='vob_planificacion'){
                        result='<b><font color="red">';
                    }
                    else if (record.data.estado_wf=='plani_aprob'){
                        result='<b><font color="green">';
                    }
                    else if (record.data.estado_wf=='plan_observado'){
                        result='<b><font color="black">';
                    }
                    else if (record.data.estado_wf=='ejecutada'){
                        result='<b><font color="#006400">';
                    }
                    else if (record.data.estado_wf=='informe'){
                        var result_aux_inf = '';
                        if(record.data.contador_estados > 1){
                            result_aux_inf = '<b><font color="red">';
                        }
                        else{
                            result_aux_inf = '<b><font color="#006400">';
                        }
                        //result='<b><font color="#006400">';
                        result = result_aux_inf;
                    }
                    else if (record.data.estado_wf=='vob_informe'){
                        result='<b><font color="red">';
                    }
                    else if (record.data.estado_wf=='acept_resp_area'){
                        result='<b><font color="green">';
                    }
                    else if (record.data.estado_wf=='informe_observado'){
                        result='<b><font color="black">';
                    }
                    console.log(record.data.contador_estados);
                    result = result + value+' - ('+record.data.contador_estados+')'+'</font></b>';
                    //console.log("wwww->",value);

                    //renderer : function(value, p, record) {
                        return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', result);
                    //}

                    //return String.format('{0}', result);
                    //return String.format('<div title="Número de revisiones: {1}"><b><font color="red">{0}-({1})</font></b></div>', value, record.data.contador_estados);
                }
            },
            type:'TextField',
            filters:{pfiltro:'aom.nombre_estado',type:'string'},
            id_grupo:0,
            grid:true,
            form:true

        },
        {
            config: {
                name: 'id_tipo_auditoria',
                fieldLabel: 'Tipo Auditoria',
                allowBlank: false,
                resizable:true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/TipoAuditoria/listarTipoAuditoria',
                    id: 'id_tipo_auditoria',
                    root: 'datos',
                    sortInfo: {
                        field: 'tipo_auditoria',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_tipo_auditoria', 'tipo_auditoria','codigo_tpo_aom'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'tau.tipo_auditoria'}
                }),
                valueField: 'id_tipo_auditoria',
                displayField: 'tipo_auditoria',
                gdisplayField: 'tipo_auditoria',
                hiddenName: 'id_tipo_auditoria',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '50%',
                gwidth: 100,
                minChars: 2,
                /*listeners: {
                    'afterrender': function(id_param_config_aom){
                    },
                    'expand':function (id_param_config_aom) {
                        this.store.reload();
                    }
                },*/
                renderer : function(value, p, record) {
                    var tipo = record.data['codigo_tpo_aom'];
                    return String.format('{0}',"<div style='text-align:center;'>"+tipo+"</div>");
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            //valorInicial: 'AUDITORIA INTERNA',
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_tipo_om',
                fieldLabel: 'Tipo OM',
                //title: 't_id_tipo_om',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/Parametro/listarParametro',
                    id: 'id_parametro',
                    root: 'datos',
                    sortInfo: {
                        field: 'valor_parametro',
                        direction: 'DESC'
                    },
                    totalProperty: 'total',
                    fields: ['id_parametro', 'tipo_parametro', 'valor_parametro'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'prm.id_tipo_parametro',tipo_parametro:'TIPO_OPORTUNIDAD_MEJORA'}
                }),
                valueField: 'id_parametro',
                displayField: 'valor_parametro',
                gdisplayField: 'desc_tipo_om',
                hiddenName: 'id_tipo_om',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '60%',
                gwidth: 120,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', record.data['desc_tipo_om']);
                    //return String.format('{0}', record.data['desc_tipo_om']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_uo',
                fieldLabel: 'Area/UO',
                allowBlank: false,
                resizable:true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListUO',
                    id: 'id_uo',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_unidad',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_uo', 'nombre_unidad','codigo','nivel_organizacional'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'nombre_unidad'}
                }),
                valueField: 'id_uo',
                displayField: 'nombre_unidad',
                gdisplayField: 'nombre_unidad',
                hiddenName: 'id_uo',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '75%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    var v_uo = record.data['nombre_unidad'];
                    //return String.format('{0}', "<div style='font-size:12px;'>"+v_uo+"</div>");
                    return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', record.data['nombre_unidad']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            //valorInicial: 0,
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_gconsultivo',
                fieldLabel: 'Grupo Consultivo',
                allowBlank: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/GrupoConsultivo/listarGrupoConsultivo',
                    id: 'id_gconsultivo',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_gconsultivo',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_gconsultivo', 'nombre_gconsultivo','requiere_programacion','requiere_formulario','nombre_programacion','nombre_formulario'],//208
                    remoteSort: true,
                    baseParams: {par_filtro: 'gct.nombre_gconsultivo'}
                }),
                valueField: 'id_gconsultivo',
                displayField: 'nombre_gconsultivo',
                gdisplayField: 'nombre_gconsultivo',
                hiddenName: 'id_gconsultivo',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '60%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['nombre_gconsultivo']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'requiere_programacion'
            },
            type:'Field',
            form:true
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'requiere_formulario'
            },
            type:'Field',
            form:true
        },
        {
            config:{
                name: 'nombre_aom1',
                fieldLabel: 'Titulo',
                allowBlank: false,
                anchor: '80%',
                emptyText: 'Intruzca titulo...',
                gwidth: 200,
                maxLength:300,
                /*renderer: function(value, p, record){
                    var aux='<b><font color="green">';
                    aux = aux +value+'</font></b>';
                    return String.format('{0}', aux);
                }*/
                renderer : function(value, p, record) {
                    return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', record.data['nombre_aom1']);
                }

            },
            type:'TextField',
            filters:{pfiltro:'aom.nombre_aom1',type:'string'},
            //id_grupo:1,
            id_grupo:0,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'descrip_aom1',
                fieldLabel: 'Descripcion',
                allowBlank: true,
                resizable:true,
                anchor: '80%',
                gwidth: 200,
                //maxLength:-5
                renderer : function(value, p, record) {
                    return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', record.data['descrip_aom1']);
                }
            },
            type:'TextArea',
            filters:{pfiltro:'aom.descrip_aom1',type:'string'},
            //id_grupo:1,
            id_grupo:0,
            grid:true,
            form:true
        },
        {
            config: {
                //name: 'id_responsable',
                name: 'id_funcionario',
                fieldLabel: 'Responsable',
                allowBlank: false,
                resizable: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListFuncionario',
                    id: 'id_funcionario',
                    root: 'datos',
                    sortInfo: {
                        field: 'desc_funcionario1',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    //fields: ['id_no_funcionario','id_responsable', 'id_uo','desc_funcionario1'],
                    fields: ['id_funcionario','desc_funcionario1','desc_funcionario2'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'vfc.desc_funcionario1'}
                }),
                valueField: 'id_funcionario',
                displayField: 'desc_funcionario2',
                gdisplayField: 'desc_funcionario1',
                hiddenName: 'id_funcionario',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '50%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    var _desc_funcionario = '';
                    if(record.data.id_funcionario == null){
                        _desc_funcionario = '(No aplica)';
                    }
                    else{
                        _desc_funcionario = record.data['desc_funcionario2'];
                        console.log("hhhhhhhhhhhhhhhhhhhhhhh",_desc_funcionario);
                        console.log("hhhhhhhhhhhhhhhhhhhhhhh",record.data['desc_funcionario2'])
                    }
                    //return String.format('{0}', _desc_funcionario);
                    return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', _desc_funcionario);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'vfc.desc_funcionario1',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'fecha_prog_inicio',
                fieldLabel: 'Fecha Inicio',
                allowBlank: false,
                //minValue : (new Date()).clearTime(),
                emptyText: 'Fecha Inicio...',
                anchor: '40%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'aom.fecha_prog_inicio',type:'date'},
            //id_grupo:1,
            id_grupo:0,
            valorInicial: (new Date().getDate()),
            grid:true,
            form:true
        },
        {
            config:{
                name: 'fecha_prog_fin',
                fieldLabel: 'Fecha Fin',
                allowBlank: false,
                //minValue : (new Date()).clearTime(),
                emptyText: 'Fecha Fin...',
                anchor: '40%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'aom.fecha_prog_fin',type:'date'},
            //id_grupo:1,
            id_grupo:0,
            valorInicial: (new Date().getDate()),
            grid:true,
            form:true
        },
        {
            config:{
                name: 'nombre_aom2',
                fieldLabel: 'Titulo',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
                maxLength:300
            },
            type:'TextField',
            filters:{pfiltro:'aom.nombre_aom2',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'lugar',
                fieldLabel: 'Lugar',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
                maxLength:300
            },
            type:'TextField',
            filters:{pfiltro:'aom.lugar',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'descrip_aom2',
                fieldLabel: 'Descripcion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                //maxLength:-5
            },
            type:'TextArea',
            filters:{pfiltro:'aom.descrip_aom2',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config: {
                name: 'id_tnorma',
                fieldLabel: 'Tipo Norma',
                allowBlank: false,
                resizable:true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    //url: '../../sis_auditoria/control/Parametro/getListParametro',
                    url: '../../sis_auditoria/control/Parametro/listarParametro',
                    id: 'id_parametro',
                    root: 'datos',
                    sortInfo: {
                        field: 'valor_parametro',
                        direction: 'DESC'
                    },
                    totalProperty: 'total',
                    fields: ['id_parametro', 'tipo_parametro', 'valor_parametro'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'prm.id_parametro',tipo_parametro:'TIPO_NORMA'}
                }),
                valueField: 'id_parametro',
                displayField: 'valor_parametro',
                gdisplayField: 'desc_tipo_norma',
                hiddenName: 'id_parametro',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '60%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                   return String.format('{0}', record.data['desc_tipo_norma']);
                }
            },
            type: 'ComboBox',
            id_grupo: 1,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_tobjeto',
                fieldLabel: 'Objeto Auditoria',
                allowBlank: false,
                resizable:true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    //url: '../../sis_auditoria/control/Parametro/getListParametro2',
                    url: '../../sis_auditoria/control/Parametro/listarParametro',
                    id: 'id_parametro',
                    root: 'datos',
                    sortInfo: {
                        field: 'valor_parametro',
                        direction: 'DESC'
                    },
                    totalProperty: 'total',
                    fields: ['id_parametro', 'tipo_parametro', 'valor_parametro'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'prm.id_parametro',tipo_parametro:'OBJETO_AUDITORIA'}
                }),
                valueField: 'id_parametro',
                displayField: 'valor_parametro',
                gdisplayField: 'desc_tipo_objeto',
                hiddenName: 'id_tobjeto',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '60%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_tipo_objeto']);
                }
            },
            type: 'ComboBox',
            id_grupo: 1,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'resumen',
                fieldLabel: 'Resumen',
                allowBlank: false,
                resizable: true,
                anchor: '80%',
                height: 200,
                gwidth: 100,
                //maxLength:-5
            },
            //type:'HtmlEditor',
            type:'HtmlEditor',
            filters:{pfiltro:'aom.resumen',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'recomendacion',
                fieldLabel: 'Recomendacion',
                allowBlank: true,
                anchor: '80%',
                height: 200,
                gwidth: 100,
                //maxLength:-5
            },
            type:'HtmlEditor',
            //type:'HtmlEditor',
            filters:{pfiltro:'aom.recomendacion',type:'string'},
            rows:50,
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'fecha_prev_inicio',
                fieldLabel: 'Fecha PV-Inicio',
                allowBlank: false,
                anchor: '40%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'aom.fecha_prev_inicio',type:'date'},
            id_grupo:1,
            valorInicial: (new Date().getDate()),
            grid:true,
            form:true
        },
        {
            config:{
                name: 'fecha_prev_fin',
                fieldLabel: 'Fecha PV-Fin',
                allowBlank: false,
                anchor: '40%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'aom.fecha_prev_fin',type:'date'},
            id_grupo:1,
            valorInicial: (new Date().getDate()),
            grid:true,
            form:true
        },
        {
            config:{
                name: 'fecha_eje_inicio',
                fieldLabel: 'Fecha Ej. Inicio',
                allowBlank: true,
                anchor: '50%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'aom.fecha_eje_inicio',type:'date'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'fecha_eje_fin',
                fieldLabel: 'Fecha Ej. Fin',
                allowBlank: true,
                anchor: '50%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'aom.fecha_eje_fin',type:'date'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'formulario_ingreso',
                fieldLabel: 'Formulario',
                allowBlank: true,
                anchor: '80%',
                height: 200,
                gwidth: 100,
                //maxLength:-5
            },
            type:'TextArea',
            filters:{pfiltro:'aom.formulario_ingreso',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'estado_form_ingreso',
                fieldLabel: 'Estado Formulario',
                inputType:'hidden',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:4
                //store:[{1:'si'},{2:'no'}]
            },
            type:'NumberField',
            filters:{pfiltro:'aom.estado_form_ingreso',type:'numeric'},
            valorInicial:0,
            id_grupo:1,
            grid:true,
            form:true
        },
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'aom.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
        {
            config: {
                name: 'id_proceso_wf',
                fieldLabel: 'id_proceso_wf',
                allowBlank: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_/control/Clase/Metodo',
                    id: 'id_',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_', 'nombre', 'codigo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'movtip.nombre#movtip.codigo'}
                }),
                valueField: 'id_',
                displayField: 'nombre',
                gdisplayField: 'desc_',
                hiddenName: 'id_proceso_wf',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '100%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_estado_wf',
                fieldLabel: 'id_estado_wf',
                allowBlank: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_/control/Clase/Metodo',
                    id: 'id_',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_', 'nombre', 'codigo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'movtip.nombre#movtip.codigo'}
                }),
                valueField: 'id_',
                displayField: 'nombre',
                gdisplayField: 'desc_',
                hiddenName: 'id_estado_wf',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '100%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'aom.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'aom.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'aom.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'aom.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
    /*Grupos : [{
        layout : 'column',
        items : [{
            xtype : 'fieldset',
            //layout : 'form',
            border : true,
            title : 'Datos de Programacion',
            bodyStyle : 'padding:0 10px 0;',
            columnWidth : '500px',
            items : [],
            id_grupo : 0,
            collapsible : true
        },]
    },*/
    /*{
        layout : 'column',
        items : [{
            xtype : 'fieldset',
            layout : 'form',
            border : true,
            title : 'Datos de Planificacion',
            bodyStyle : 'padding:0 10px 0;',
            columnWidth : '1000px',
            items : [],
            id_grupo : 1,
            collapsible : true
        },]
    }

    ],*/
	tam_pag:50,	
	title:'Auditoria - Oportunidad Mejora',
    id:'AOM',
	ActSave:'../../sis_auditoria/control/AuditoriaOportunidadMejora/insertarAuditoriaOportunidadMejora',
	ActDel:'../../sis_auditoria/control/AuditoriaOportunidadMejora/eliminarAuditoriaOportunidadMejora',
	ActList:'../../sis_auditoria/control/AuditoriaOportunidadMejora/listarAuditoriaOportunidadMejora',
	id_store:'id_aom',
	fields: [
		{name:'id_aom', type: 'numeric'},
		{name:'id_proceso_wf', type: 'numeric'},
		{name:'nro_tramite_wf', type: 'string'},
		{name:'resumen', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'fecha_prog_inicio', type: 'date',dateFormat:'Y-m-d'},
		{name:'recomendacion', type: 'string'},
		{name:'id_uo', type: 'numeric'},
		{name:'id_gconsultivo', type: 'numeric'},
		{name:'fecha_prev_inicio', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_prev_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_prog_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'descrip_aom2', type: 'string'},
		{name:'nombre_aom1', type: 'string'},
		{name:'documento', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'estado_wf', type: 'string'},
		{name:'id_tobjeto', type: 'string'},
		{name:'id_estado_wf', type: 'numeric'},
		{name:'id_tnorma', type: 'string'},
		{name:'fecha_eje_inicio', type: 'date',dateFormat:'Y-m-d'},
		{name:'codigo_aom', type: 'string'},
		{name:'id_tipo_auditoria', type: 'numeric'},
		{name:'descrip_aom1', type: 'string'},
		{name:'lugar', type: 'string'},
		{name:'id_tipo_om', type: 'numeric'},

        {name:'formulario_ingreso', type: 'string'},
        {name:'estado_form_ingreso', type: 'numeric'},

		{name:'fecha_eje_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'nombre_aom2', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'tipo_auditoria', type: 'string'},
		{name:'nombre_unidad', type: 'string'},
		{name:'nombre_gconsultivo', type: 'string'},
		{name:'desc_funcionario1', type: 'text'},
		{name:'desc_funcionario2', type: 'text'},
        {name:'desc_tipo_objeto', type: 'string'},
		{name:'desc_tipo_norma', type: 'string'},
		{name:'codigo_parametro', type: 'string'},
		{name:'desc_tipo_om', type: 'string'},
		{name:'nombre_estado', type: 'string'},
		{name:'codigo_tpo_aom', type: 'string'},
		{name:'requiere_programacion', type: 'string'},
		{name:'requiere_formulario', type: 'string'},
		{name:'contador_estados', type: 'numeric'},

	],
	sortInfo:{
		field: 'id_aom',
		direction: 'DESC'
	},
	bdel:true,
	bsave:true,
    onBtnInformeOM: function () {
        //this.ocultarComponente(this.Cmp.formulario_impuesto);
        var rec = '';
        Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/InformeOM.php', 'Perfil de Informe de Oportunidades de Mejora', {
            modal : true,
            width : '99%',
            height : '98%',
        }, rec, this.idContenedor, 'InformeOM');
    },

    // ================ Agrega botones =================
    onBtnPlanificarAudit: function () {
        var rec = '';
        //var rec = this.sm.getSelected();
        console.log('valor del rec->:',this.sm.getSelected())
        Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/PlanificacionAOM.php', 'Perfil de Planificacion de Auditoria', {
            modal : true,
            width : '99%',
            height : '98%',
        }, rec, this.idContenedor, 'PlanificacionAOM');

    },
    onBtnInformeRegistroNC: function () {
        var rec = '';
        //var rec = this.sm.getSelected();
        console.log('valor del rec->:',this.sm.getSelected())
        Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/InformeAuditoria.php', 'Perfil de Informe y Resitro de No Conformidad', {
            modal : true,
            width : '99%',
            height : '98%',
        }, rec, this.idContenedor, 'InformeAuditoria');
    },
    onBtnHelpAOM: function () {
            var rec = '';
            //var rec = this.sm.getSelected();
            console.log('valor del rec->:',this.sm.getSelected())
            Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/InformeAuditoria.php', 'Perfil de Informe y Resitro de No Conformidad', {
                modal : true,
                width : '99%',
                height : '98%',
            }, rec, this.idContenedor, 'InformeAuditoria');
    },
    preparaMenu:function(n){
        //console.log('valor n de preparaMenu:',n);
        var data = this.getSelectedData();
        Phx.vista.AuditoriaOportunidadMejora.superclass.preparaMenu.call(this);
        this.getBoton('btnPlanificarAudit').enable();
        this.getBoton('btnInformeOM').enable();
    },
    liberaMenu:function(n){
        //var data = this.getSelectedData();
        //console.log('valor n de liberaMenu:',n);
        Phx.vista.AuditoriaOportunidadMejora.superclass.liberaMenu.call(this);
        this.getBoton('btnPlanificarAudit').enable();
        this.getBoton('btnInformeOM').disable();
    },

}
)
</script>