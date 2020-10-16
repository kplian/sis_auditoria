<?php
/**
*@package pXP
*@file gen-AccionPropuesta.php
*@author  (szambrana)
*@date 04-07-2019 22:32:50
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AccionPropuesta=Ext.extend(Phx.gridInterfaz,{
    nombreVista :'AccionPropuesta',
    constructor:function(config){
		this.maestro = config.maestro; //comentado ahorita

		Phx.vista.AccionPropuesta.superclass.constructor.call(this,config);
        this.init();
        this.grid.addListener('cellclick', this.oncellclick,this);


		
		//insertamos y habilitamos el boton siguiente
		this.addButton('siguiente',{text:'Aprobar',
			iconCls: 'bok',
			disabled:true,
			handler:this.onButtonSiguiente,   //creamos esta funcion para disparar el evento al presionar siguiente
			tooltip: '<b>Siguiente</b><p>Pasar al siguiente estado</p>'});

        this.addButton('atras',{argument: { estado: 'anterior'},
            text:'Anterior',
            iconCls: 'bdel',
            disabled:true,
            handler:this.onButtonAtras,
            tooltip: '<b>Pasar al anterior Estado</b>'});
        //insertamos y habilitamos el boton Gantt
		this.addBotonesGantt();
		
		//insertamos y habilitamos el boton de documentos			
		this.addButton('btnChequeoDocumentosWf',
			{	text: 'Documentos',
				iconCls: 'bchecklist',
				disabled: true,
				handler: this.loadCheckDocumentosPlanWf,
				tooltip: '<b>Documentos de la No conformidad</b><br/>Subir los documentos de evidencia.'
			}
		);
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_ap'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'nro_tramite_padre'
			},
			type:'Field',
			form:true 
		},		
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					//name: 'id_ap'
					name: 'id_nc'
			},
			type:'Field',
			form:true 
		},
        {
            //configuracion del componente -->id_estado_wf
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_estado_wf'
            },
            type:'Field',
            form:true
        },
        {
            //configuracion del componente -->id_proceso_wf
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_proceso_wf'
            },
            type:'Field',
            form:true
        },
        {
            config:{
                name: 'revisar',
                fieldLabel: 'Revisar',
                allowBlank: true,
                anchor: '40%',
                gwidth: 60,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                store:['si','no'],
                renderer:function (value,p,record){
                    let checked = '';
                    if(value === 'si'){
                        checked = 'checked';
                    }
                    return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:20px;width:20px;" type="checkbox"{0}></div>',checked);
                }
            },
            type:'ComboBox',
            id_grupo:3,
            valorInicial: 'no',
            grid: true,
            form: false
        },
        {
            config:{
                name: 'rechazar',
                fieldLabel: 'Rechazar',
                allowBlank: true,
                anchor: '40%',
                gwidth: 60,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                store:['si','no'],
                renderer:function (value,p,record){
                    let checked = '';
                    if(value === 'si'){
                        checked = 'checked';
                    }
                    return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:20px;width:20px;" type="checkbox"{0}></div>',checked);
                }
            },
            type:'ComboBox',
            id_grupo:3,
            valorInicial: 'no',
            grid: true,
            form: false
        },
        {
            config:{
                name: 'implementar',
                fieldLabel: 'Implementar',
                allowBlank: true,
                anchor: '40%',
                gwidth: 80,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                store:['si','no'],
                renderer:function (value,p,record){
                    let checked = '';
                    if(value === 'si'){
                        checked = 'checked';
                    }
                    return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:20px;width:20px;" type="checkbox"{0}></div>',checked);
                }
            },
            type:'ComboBox',
            id_grupo:3,
            valorInicial: 'no',
            grid: true,
            form: false
        },
        {
            //configuracion del componente -->nro_tramite
            config:{
                name: 'nro_tramite',
                fieldLabel: 'Nro Tramite',
                allowBlank: true,
                anchor: '80%',
                gwidth: 150,
                maxLength:100
            },
            type:'TextField',
            filters:{pfiltro:'smt.nro_tramite',type:'string'},
            id_grupo:1,
            grid:false,
            form:false
        },
		{
			config:{
				name: 'codigo_ap',
				fieldLabel: 'Codigo',
				allowBlank: true,
				anchor: '75%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'accpro.codigo_ap',type:'string'},
				id_grupo:1,
				grid:false,
				form:false
		},
        {
            config:{
                name: 'estado_wf',
                fieldLabel: 'Estado',
                allowBlank: true,
                anchor: '80%',
                gwidth: 180,
                renderer: function(value,p,record){
                    let color = '#1419CC';

                    if (record.data['estado_wf'] === 'accion_aprobada_responsable'){
                        color = '#0a7f15';
                    }
                    if (record.data['estado_wf'] === 'accion_rechazada_responsable'){
                        color = '#a20007';
                    }

                    return '<font color="'+color+'">'+record.data['estado_wf']+'</font>';
                }
            },
            type:'TextField',
            filters:{pfiltro:'smt.estado',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },

		{
			config:{
				name: 'descrip_causa_nc',
				fieldLabel: 'Descripcion causa No conformidad',
				allowBlank: true,
				anchor: '80%',
				gwidth: 200,
				//maxLength:-5
			},
				type:'TextArea',
				filters:{pfiltro:'accpro.descrip_causa_nc',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},		
		{
			config:{
				name: 'descripcion_ap',
				fieldLabel: 'Descripcion accion propuesta',
				allowBlank: true,
				anchor: '80%',
				gwidth: 200,
				//maxLength:-5
			},
				type:'TextArea',
				filters:{pfiltro:'accpro.descripcion_ap',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		//configuracion del componente -->id_parametro
		{
			config: {
				name: 'id_parametro',
				fieldLabel: 'Tipo de Accion',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_auditoria/control/Parametro/listarParametro',
					id: 'id_parametro',
					root: 'datos',
					sortInfo: {
						field: 'valor_parametro',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_parametro', 'valor_parametro', 'id_tipo_parametro'],
					remoteSort: true,
					baseParams: {par_filtro: 'prm.id_parametro#prm.valor_parametro',id_tipo_parametro:1}
				}),
				valueField: 'id_parametro',
				displayField: 'valor_parametro',
				gdisplayField: 'valor_parametro',
				hiddenName: 'id_parametro',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '40%',
				gwidth: 100,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['valor_parametro']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'prm.valor_parametro',type: 'string'},
			grid: true,
			form: true
		},
		{
			config: {
				name: 'id_funcionario',
				//fieldLabel: 'id_funcionario_aprob',
				fieldLabel: 'Responsable de Aprobar la Accion Propuesta',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_auditoria/control/NoConformidad/listarSomUsuario',
					id: 'id_funcionario',
					root: 'datos',
					sortInfo: {
						field: 'id_funcionario',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_funcionario', 'desc_funcionario1'],
					remoteSort: true,
					baseParams: {par_filtro: 'ofunc.id_funcionario#ofunc.desc_funcionario1'}
				}),
				valueField: 'id_funcionario',
				displayField: 'desc_funcionario1',
				gdisplayField: 'desc_funcionario1',
				hiddenName: 'id_funcionario',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '40%',
				gwidth: 100,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['funcionario_name']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'ofunc.id_funcionario',type: 'string'},
			grid: true,
			form: true
		},

		{
			config:{
				name: 'efectividad_cumpl_ap',
				fieldLabel: 'efectividad/ cumplimiento de la accion propuesta',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				//maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'accpro.efectividad_cumpl_ap',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_inicio_ap',
				fieldLabel: 'Inicio aplicacion accion propuesta',
				allowBlank: true,
				anchor: '50%',
				gwidth: 80,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'accpro.fecha_inicio_ap',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},		
		{
			config:{
				name: 'fecha_fin_ap',
				fieldLabel: 'Fin aplicacion accion propuesta',
				allowBlank: true,
				anchor: '50%',
				gwidth: 80,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'accpro.fecha_fin_ap',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'obs_resp_area',
				fieldLabel: 'Observaciones Responsable de Area',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
				//maxLength:-5
			},
				type:'TextArea',
				filters:{pfiltro:'accpro.obs_resp_area',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'obs_auditor_consultor',
				fieldLabel: 'Observaciones Auditor Consultor',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
				//maxLength:-5
			},
				type:'TextArea',
				filters:{pfiltro:'accpro.obs_auditor_consultor',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},

		{
			config:{
				name: 'nro_tramite_no',
				fieldLabel: 'No Conformidad',
				allowBlank: true,
				anchor: '80%',
				gwidth: 75,
				maxLength:10
			},
				type:'TextField',
				id_grupo:1,
				grid:true,
				form:false
		},
        {
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 75,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'accpro.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 75,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'accpro.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'accpro.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
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
				filters:{pfiltro:'accpro.fecha_reg',type:'date'},
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
				filters:{pfiltro:'accpro.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Acciones Propuestas',
	ActSave:'../../sis_auditoria/control/AccionPropuesta/insertarAccionPropuesta',
	ActDel:'../../sis_auditoria/control/AccionPropuesta/eliminarAccionPropuesta',
	ActList:'../../sis_auditoria/control/AccionPropuesta/listarAccionPropuesta',
	id_store:'id_ap',
	fields: [
		{name:'id_ap', type: 'numeric'},
		{name:'obs_resp_area', type: 'string'},
		{name:'descripcion_ap', type: 'string'},
		{name:'id_parametro', type: 'numeric'},
		{name:'id_funcionario_aprob', type: 'numeric'},
		{name:'descrip_causa_nc', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'efectividad_cumpl_ap', type: 'string'},
		{name:'fecha_fin_ap', type: 'date',dateFormat:'Y-m-d'},
		{name:'obs_auditor_consultor', type: 'string'},
		{name:'id_nc', type: 'numeric'},
		{name:'fecha_inicio_ap', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		//**********
		{name:'valor_parametro', type: 'string'},
		{name:'funcionario_name', type: 'string'},
		//****wf
        {name:'nro_tramite', type: 'string'},	
        {name:'id_proceso_wf', type: 'numeric'},
		{name:'id_estado_wf', type: 'numeric'},
        {name:'estado_wf', type: 'string'},		
		
		{name:'codigo_ap', type: 'string'},
		{name:'contador_estados', type: 'numeric'},		
		{name:'nro_tramite_padre', type: 'numeric'},
        {name:'revisar', type: 'string'},
        {name:'rechazar', type: 'string'},
        {name:'implementar', type: 'string'},

        {name:'nro_tramite_no', type: 'string'},
		{name:'descrip_nc', type: 'string'},
		
		{name:'area_noc', type: 'string'},
		{name:'funcionario_noc', type: 'string'},
		{name:'id_aom', type: 'numeric'},
        {name:'auditoria', type: 'string'},
	],
	sortInfo:{
		field: 'id_ap',
		direction: 'ASC'
	},
	bdel:true,
	bsave:false,
    fwidth: '60%',
    fheight: '80%',
	/*onReloadPage:function(m){
		
		this.maestro = m;
		console.log('padre',this.maestro);
		this.store.baseParams={id_nc:this.maestro.id_nc,interfaz : this.nombreVista};
		this.load({params:{start:0, limit:50}})
		
	},
    loadValoresIniciales:function () {
        Phx.vista.AccionPropuesta.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_nc.setValue(this.maestro.id_nc);
		this.Cmp.nro_tramite_padre.setValue(this.maestro.nro_tramite);
    },*/
	preparaMenu:function(n){
		Phx.vista.AccionPropuesta.superclass.preparaMenu.call(this, n);
            this.getBoton('siguiente').enable();
            this.getBoton('atras').enable(); 	//se habilita para el boton para atras
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
	},

	// al seleccionar un resgistro el boton se ativa o desativa
	liberaMenu:function() {
		var tb = Phx.vista.AccionPropuesta.superclass.liberaMenu.call(this);
		if (tb) {
			 	this.getBoton('siguiente').disable();
				this.getBoton('atras').disable();	//se habilita para el boton para atras
				this.getBoton('diagrama_gantt').disable();
				this.getBoton('btnChequeoDocumentosWf').disable();

		}
	},	
	//Boton Siguiente
	onButtonSiguiente : function() {
		var rec = this.sm.getSelected();  // aqui se almacena los datos del registro selecionado
		console.log(rec);
		this.objWizard = Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/FormEstadoWf.php', // llama al formulario de wf
			'Estado de Wf',
			{
				modal: true,
				width: 700,
				height: 450
			},
			{
				data: {
					id_estado_wf: rec.data.id_estado_wf, 	// parametros para obtener los estados de tu macro proceso y tipo proceso
					id_proceso_wf: rec.data.id_proceso_wf	// parametros para obtener los estados de tu macro proceso y tipo proceso
				}
			}, this.idContenedor, 'FormEstadoWf',
			{
				config: [{
					event: 'beforesave',
					delegate: this.onSaveWizard
				}],
				scope: this
			}
		);
	},	

	onSaveWizard:function(wizard,resp){
		var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText)); // Respuesta del procedimiento
		Phx.CP.loadingShow(); // inica el reolad
		Ext.Ajax.request({
			url:'../../sis_auditoria/control/AccionPropuesta/siguienteEstado', // llamada al controlador del metodo para cambiar el estado
			params:{
				id_proceso_wf_act:  resp.id_proceso_wf_act,
				id_estado_wf_act:   resp.id_estado_wf_act,
				id_tipo_estado:     resp.id_tipo_estado,
				id_funcionario_wf:  resp.id_funcionario_wf,
				id_depto_wf:        resp.id_depto_wf,
				obs:                resp.obs,
				json_procesos:      Ext.util.JSON.encode(resp.procesos),
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
	//Boton Atras
	onButtonAtras : function(res){
		//console.log("entra atras");
		var rec=this.sm.getSelected();
		Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/AntFormEstadoWf.php',
			'Estado de Wf',
			{
				modal:true,
				width:450,
				height:250
			}, { data:rec.data, estado_destino: res.argument.estado}, this.idContenedor,'AntFormEstadoWf',
			{
				config:[{
					event:'beforesave',
					delegate: this.onAntEstado
				}
				],
				scope:this
			});			
	},
	onAntEstado: function(wizard,resp){
		Phx.CP.loadingShow();
		Ext.Ajax.request({
			url:'../../sis_auditoria/control/AccionPropuesta/anteriorEstado',
			params:{
				id_proceso_wf: resp.id_proceso_wf,
				id_estado_wf:  resp.id_estado_wf,
				obs: resp.obs,
				estado_destino: resp.estado_destino
			},
			argument:{wizard:wizard},
			success:this.successEstadoSinc,
			failure: this.conexionFailure,
			timeout:this.timeout,
			scope:this
		});
	},
	successEstadoSinc:function(resp){
		Phx.CP.loadingHide();
		resp.argument.wizard.panel.destroy();
		this.reload();
	},

	diagramGanttDinamico : function(){
        var data=this.sm.getSelected().data.id_proceso_wf;
        window.open('../../../sis_workflow/reportes/gantt/gantt_dinamico.html?id_proceso_wf='+data)
	},	
	
	addBotonesGantt: function() {
		this.menuAdqGantt = new Ext.Toolbar.SplitButton({
			id: 'b-diagrama_gantt-' + this.idContenedor,
			text: 'Gantt',
			disabled: true,
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

	onButtonNew:function(){
        Phx.vista.AccionPropuesta.superclass.onButtonNew.call(this);
        this.Cmp.id_funcionario.setValue(this.maestro.id_funcionario);
        this.Cmp.id_funcionario.setRawValue(this.maestro.funcionario_uo);
	},
    oncellclick : function(grid, rowIndex, columnIndex, e) {
        const record = this.store.getAt(rowIndex),
            fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name
        if (fieldName === 'revisar' || fieldName === 'rechazar'|| fieldName === 'implementar')
            this.cambiarAsignacion(record,fieldName);
    },
    cambiarAsignacion: function(record,name){
        Phx.CP.loadingShow();
        var d = record.data;
        console.log(d)
        Ext.Ajax.request({
            url:'../../sis_auditoria/control/AccionPropuesta/aceptarAccion',
            params:{ id_ap: d.id_ap, fieldName: name  },
            success: this.successRevision,
            failure: this.conexionFailure,
            timeout: this.timeout,
            scope: this
        });
        this.reload();
    },
        successRevision: function(resp){
            Phx.CP.loadingHide();
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
        },

}
)
</script>
		
		