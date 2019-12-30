<?php
/**
*@package pXP
*@file gen-NoConformidad.php
*@author  (szambrana)
*@date 04-07-2019 19:53:16
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.NoConformidad=Ext.extend(Phx.gridInterfaz,{
	nombreVista: 'base',
	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		///***************HABER SI FUNCIONA********SSS
		Phx.vista.NoConformidad.superclass.constructor.call(this,config);
		this.store.baseParams = {tipo_interfaz: this.nombreVista};
		this.init();
		// console.log(this.sm.getSelected());

		//this.load({params:{start:0, limit:50}});
        //this.load({params:{start:0, limit:this.tam_pag}});
		//aqui habia 2 botones
    },

	Atributos:[
		{
			//configuracion del componente --> id_nc

			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_nc'
			},
			type:'Field',
			form:true
		},
        {
			//configuracion del componente --> id_nc

			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_uo'
			},
			type:'Field',
			form:true
		},
        {
			//configuracion del componente --> id_aom
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_aom'
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
            //configuracion del componente -->id_proceso_wf
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'nro_tramite_padre'
            },
            type:'Field',
            form:true
        },
		{
            //configuracion del componente -->id_proceso_wf
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_funcionario_nc'
            },
            type:'Field',
            form:true
        },

		//imagen
        {
            config:{
                name: 'dibu_icono',
                fieldLabel: 'N. C.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 60,
                maxLength:150,
                renderer: function (value, p, record) {
                    var result;
                    console.log(record.data)
                    result = String.format('{0}', "<div style='text-align:center'><img src = '../../../lib/imagenes/icono_dibu/dibu_engine_remove.png' align='center' width='35' height='35' title=''/></div>");
                    return result;
                }
            },
            type:'TextField',
            filters:{pfiltro:'noconf.id_nc',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },		

        {
            //configuracion del componente -->nro_tramite
            config:{
                name: 'nro_tramite',
                fieldLabel: 'Nro Tramite',
                allowBlank: true,
                anchor: '75%',
                gwidth: 120,
                maxLength:100
            },
            type:'TextField',
            filters:{pfiltro:'smt.nro_tramite',type:'string'},
            id_grupo:1,
            grid:true,
            bottom_filter:true,
            form:false
        },
		//
		{
			config:{
				name: 'codigo_nc',
				fieldLabel: 'Codigo',
				allowBlank: true,
				anchor: '75%',
				gwidth: 130,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'noconf.codigo_nc',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},		
		
        //configuracion del componente -->estado_wf
        {
            config:{
                name: 'estado_wf',
                fieldLabel: 'Estado',
                allowBlank: true,
                anchor: '80%',
                gwidth: 160,
                maxLength:100, // ,
				renderer: function(value, p, record){
                    var aux1;
                    if(record.data.estado_wf=='propuesta'){
                        aux1='<div title="Número de revisiones: {1}"><b><font size=2 color="brown">{0} - ({1})</font></b></div>';
                    }else if (record.data.estado_wf=='correccion'){
                        aux1='<div title="Número de revisiones: {1}"><b><font size=2 color="green">{0} - ({1})</font></b></div>';
                    }else if (record.data.estado_wf=='vbnoconformidad'){
						aux1='<div title="Número de revisiones: {1}"><b><font size=2 color="red">{0} - ({1})</font></b></div>';
					}else if (record.data.estado_wf=='finalizado'){
						aux1='<div title="Número de revisiones: {1}"><b><font size=2 color="blue">{0} - ({1})</font></b></div>';
					}
                    //aux1 = aux1 +value+'</font></b>';
					console.log(record.data)
					//return String.format('<div title="Número de revisiones: {1}"><b><font color="red">{0} - ({1})</font></b></div>', value, record.data.contador_estados);
					return String.format(aux1, value, record.data.contador_estados);
                    //return String.format('{0}', aux1);
                }
            },
            type:'TextField',
            filters:{pfiltro:'smt.estado',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
        //configuracion del componente -->id_parametro
		{
			config: {
				name: 'id_parametro',
				fieldLabel: 'Tipo de No Conformidad (Parametro)',
				allowBlank: false,
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
					baseParams: {par_filtro: 'prm.id_parametro#prm.valor_parametro',id_tipo_parametro:5}
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
				anchor: '50%',
				gwidth: 90,
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

		//cambiamos el combo por textfield para la UO
		
		{
			config:{
				name: 'mostrar',
				fieldLabel: 'Area/UO',
				allowBlank: true,
				anchor: '75%',
				gwidth: 150,
				maxLength:500,
				//disabled : true,
				useClearIcon : false,
				readOnly: true,
				renderer : function(value, p, record) {
					//return String.format('{0}', record.data['gerencia_uo1']);
					return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', record.data['gerencia_uo1']);

				}
            },
				type:'TextField',
				filters:{pfiltro:'noconf.id_uo',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},

		//adicionamos el checkbox para habilitar la uo adicional
		{
            config:{
                name: 'bandera',
                fieldLabel: 'Habilitar Area/UO adicional',
                allowBlank: true,
                anchor: '80%',
                gwidth: 65
            },
            type:'Checkbox',
            id_grupo:1,
            grid:false,
            form:true
        },
		
		//adicionamos el combo para la uo adicional 
        {
            config: {
                name: 'id_uo_adicional',
                fieldLabel: 'Area/UO adicional',
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
                valueField: 'id_uo', //modificado
                displayField: 'nombre_unidad',
                gdisplayField: 'gerencia_uo',
                hiddenName: 'id_uo_adicional',
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
					console.log('asd',record);
					//return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', value);
					return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>',  record.data['gerencia_uo2']);
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
				name: 'id_funcionario',
				fieldLabel: 'Responsable de Area de No Conformidad',
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
				anchor: '75%',
				gwidth: 150,
				minChars: 2,
				//editable : false,
				disabled : false,
				//readOnly : true,
				renderer : function(value, p, record) {
					console.log('asd',record);
                    //return String.format('{0}', record.data['funcionario_uo']);
					return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>',  record.data['funcionario_uo']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'ofunc.id_funcionario',type: 'string'},
			grid: true,
			form: true
		},		
		
		
		//*****
		{
			config:{
				name: 'descrip_nc',
				fieldLabel: 'Descripcion de la No Conformidad',
				allowBlank: true,
				anchor: '75%',
				gwidth: 280,
				maxLength : 500,
                /*renderer: function(value, p, record){
                    var aux;
                    if(record.data.tipo=='salida'){
                        aux='<b><font color="brown">';
                    }
                    else {
                        aux='<b><font color="green">';
                    }
                    aux = aux +value+'</font></b>';
                    return String.format('{0}', aux);
                }*/
				renderer: function(value, metaData, record, rowIndex, colIndex, store) {
					metaData.css = 'multilineColumn'; 
					//return String.format('<div style="background-color:lightgreen" class="gridmultiline">{0}</div>', value);
					return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', value);
                }
				
				
			},
				type:'TextArea',
				filters:{pfiltro:'noconf.descrip_nc',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'evidencia',
				fieldLabel: 'Evidencia',
				allowBlank: true,
				anchor: '75%',
				gwidth: 150,
				maxLength:500,
				renderer: function(value, metaData, record, rowIndex, colIndex, store) {
					metaData.css = 'multilineColumn'; 
					return String.format('<div class="gridmultiline">{0}</div>', value);
                }
			},
				type:'TextField',
				filters:{pfiltro:'noconf.evidencia',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'obs_resp_area',
				fieldLabel: 'Observacion responsable de Area',
				allowBlank: true,
				anchor: '75%',
				gwidth: 150,
				//maxLength:-5
				renderer: function(value, metaData, record, rowIndex, colIndex, store) {
					metaData.css = 'multilineColumn'; 
					return String.format('<div class="gridmultiline">{0}</div>', value);
                }
			},
				type:'TextArea',
				filters:{pfiltro:'noconf.obs_resp_area',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'obs_consultor',
				fieldLabel: 'Observacion Consultor',
				allowBlank: true,
				anchor: '75%',
				gwidth: 150,
				//maxLength:-5
				renderer: function(value, metaData, record, rowIndex, colIndex, store) {
					metaData.css = 'multilineColumn'; 
					return String.format('<div class="gridmultiline">{0}</div>', value);
                }				
			},
				type:'TextArea',
				filters:{pfiltro:'noconf.obs_consultor',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},

		//funcionario responsable de la no conformidad 666
        {
            config:{
                name: 'funcionario_resp',
                fieldLabel: 'Resp. No Conformidad',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10
            },
            type:'TextField',
            filters:{pfiltro:'rfun.funcionario_resp',type:'string'},
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
                gwidth: 100,
                maxLength:10
            },
            type:'TextField',
            filters:{pfiltro:'noconf.estado_reg',type:'string'},
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
				filters:{pfiltro:'noconf.fecha_reg',type:'date'},
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
				filters:{pfiltro:'noconf.usuario_ai',type:'string'},
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
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'noconf.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'noconf.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,
	title:'No Conformidades',
	ActSave:'../../sis_auditoria/control/NoConformidad/insertarNoConformidad',
	ActDel:'../../sis_auditoria/control/NoConformidad/eliminarNoConformidad',
	ActList:'../../sis_auditoria/control/NoConformidad/listarNoConformidad',
	id_store:'id_nc',
	fields: [
		{name:'id_nc', type: 'numeric'},
		{name:'obs_consultor', type: 'string'},		
		{name:'estado_reg', type: 'string'},
		{name:'evidencia', type: 'string'},
		{name:'id_funcionario', type: 'int4'}, //aumentado
        {name:'id_uo', type: 'numeric'},		
		{name:'descrip_nc', type: 'string'},
        {name:'id_parametro', type: 'numeric'},
		{name:'obs_resp_area', type: 'string'},
        {name:'id_aom', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_uo_adicional', type: 'numeric'},

        {name:'id_proceso_wf', type: 'numeric'},
		{name:'id_estado_wf', type: 'numeric'},
        {name:'nro_tramite', type: 'string'},		
        {name:'estado_wf', type: 'string'},

		{name:'codigo_nc', type: 'string'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
		
		{name:'nombreaom', type: 'string'}, //aumentado
		{name:'valor_parametro', type: 'string'},
        {name:'gerencia_uo1', type: 'string'},
		{name:'gerencia_uo2', type: 'string'},
		{name:'funcionario_uo', type: 'string'},
		{name:'contador_estados', type: 'numeric'},
		{name:'funcionario_resp', type: 'numeric'}
	],
	sortInfo:{
		field: 'id_nc',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true

	}
)
</script>
