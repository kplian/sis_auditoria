<?php
/**
*@package pXP
*@file gen-RiesgoOportunidad.php
*@author  (max.camacho)
*@date 16-12-2019 17:57:34
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019				 (max.camacho)				CREACION	

*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.RiesgoOportunidad=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.RiesgoOportunidad.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_ro'
			},
			type:'Field',
			form:true 
		},
		{
			config: {
				name: 'id_tipo_ro',
				fieldLabel: 'Tipo RO',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_auditoria/control/TipoRo/ListarTipoRo',
					id: 'id_tipo_ro',
					root: 'datos',
					sortInfo: {
						field: 'desc_tipo_ro',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_tipo_ro', 'tipo_ro','desc_tipo_ro'],
					remoteSort: true,
					baseParams: {par_filtro: 'tro.id_tipo_ro'}
				}),
				valueField: 'id_tipo_ro',
				displayField: 'desc_tipo_ro',
				gdisplayField: 'desc_tipo_ro',
				hiddenName: 'id_tipo_ro',
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
					return String.format('{0}', record.data['desc_tipo_ro']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'tro.tipo_ro',type: 'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'nombre_ro',
				fieldLabel: 'Nombre RO',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:150
			},
				type:'TextField',
				filters:{pfiltro:'riop.nombre_ro',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
        {
            config:{
                name: 'codigo_ro',
                fieldLabel: 'Codigo RO',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
                maxLength:150
            },
            type:'TextField',
            filters:{pfiltro:'riop.codigo_ro',type:'string'},
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
				filters:{pfiltro:'riop.estado_reg',type:'string'},
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
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'riop.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'riop.usuario_ai',type:'string'},
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
				filters:{pfiltro:'riop.fecha_reg',type:'date'},
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
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'riop.fecha_mod',type:'date'},
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
		}
	],
	tam_pag:50,	
	title:'Riesgo Oportunidad',
	ActSave:'../../sis_auditoria/control/RiesgoOportunidad/insertarRiesgoOportunidad',
	ActDel:'../../sis_auditoria/control/RiesgoOportunidad/eliminarRiesgoOportunidad',
	ActList:'../../sis_auditoria/control/RiesgoOportunidad/listarRiesgoOportunidad',
	id_store:'id_ro',
	fields: [
		{name:'id_ro', type: 'numeric'},
		{name:'id_tipo_ro', type: 'numeric'},
		{name:'nombre_ro', type: 'string'},
		{name:'codigo_ro', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'tipo_ro', type: 'string'},
		{name:'desc_tipo_ro', type: 'string'},

	],
	sortInfo:{
		field: 'id_ro',
		direction: 'DESC'
	},
	bdel:true,
	bsave:false
	}
)
</script>
		
		