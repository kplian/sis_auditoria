<?php
/**
*@package pXP
*@file gen-SiNoconformidad.php
*@author  (szambrana)
*@date 09-08-2019 15:16:47
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SiNoconformidad=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
        //llama al constructor de la clase padre
		Phx.vista.SiNoconformidad.superclass.constructor.call(this,config);
		this.init();
        //this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_sinc'
			},
			type:'Field',
			form:true 
		},
		//********SSS
		
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_nc'
			},
			type:'Field',
			form:true 
		},

		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'estado_reg'
			},
			type:'Field',
			form:true 
		},

		{
			config: {
				name: 'id_si',
				fieldLabel: 'Sistema Integrado',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_auditoria/control/SistemaIntegrado/listarSistemaIntegrado',
					id: 'id_si',
					root: 'datos',
					sortInfo: {
						field: 'nombre_si',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_si', 'nombre_si'],
					remoteSort: true,
					//baseParams: {par_filtro: 'sint.desc_si#movtip.codigo'}
					baseParams: {par_filtro: 'sinteg.nombre_si'}
				}),
				valueField: 'id_si',
				displayField: 'nombre_si',
				gdisplayField: 'desc_si',
				hiddenName: 'id_si',
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
					return String.format('{0}', record.data['desc_si']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			//filters: {pfiltro: 'movtip.nombre',type: 'string'},
			//filters: {pfiltro: 'sinteg.desc_si',type: 'string'},
			grid: true,
			form: true
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
				filters:{pfiltro:'sinoconf.usuario_ai',type:'string'},
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
				filters:{pfiltro:'sinoconf.fecha_reg',type:'date'},
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
				filters:{pfiltro:'sinoconf.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'sinoconf.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Sist. Integrados para no conformidades',
	ActSave:'../../sis_auditoria/control/SiNoconformidad/insertarSiNoconformidad',
	ActDel:'../../sis_auditoria/control/SiNoconformidad/eliminarSiNoconformidad',
	ActList:'../../sis_auditoria/control/SiNoconformidad/listarSiNoconformidad',
	id_store:'id_sinc',
	fields: [
		{name:'id_sinc', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_nc', type: 'numeric'},
		{name:'id_si', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_si', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_sinc',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,

	onReloadPage: function(m)
	{
		this.maestro=m;
        this.store.baseParams={id_nc:this.maestro.id_nc};
        this.load({params:{start:0, limit:50}})
	},
	loadValoresIniciales:function()
	{
		Phx.vista.SiNoconformidad.superclass.loadValoresIniciales.call(this);
		this.Cmp.id_nc.setValue(this.maestro.id_nc);
	}
	}
)
</script>
		
		