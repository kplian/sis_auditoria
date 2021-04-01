<?php
/**
*@package pXP
*@file gen-PuntoNorma.php
*@author  (szambrana)
*@date 01-07-2019 18:45:10
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PuntoNorma=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.PuntoNorma.superclass.constructor.call(this,config);
		this.init();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pn'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_norma'
			},
			type:'Field',
			form:true 
		},		
		
		{
			config:{
				name: 'nombre_pn',
				fieldLabel: 'Nombre de punto de Norma',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:500
			},
				type:'TextField',
				filters:{pfiltro:'ptonor.nombre_pn',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'codigo_pn',
				fieldLabel: 'Codigo del Punto de Norma',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:250
			},
				type:'TextField',
				filters:{pfiltro:'ptonor.codigo_pn',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'descrip_pn',
				fieldLabel: 'Descripcion del Punto de Norma',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				//maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'ptonor.descrip_pn',type:'string'},
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
				filters:{pfiltro:'ptonor.estado_reg',type:'string'},
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
				filters:{pfiltro:'ptonor.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'ptonor.usuario_ai',type:'string'},
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
				filters:{pfiltro:'ptonor.fecha_reg',type:'date'},
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
				filters:{pfiltro:'ptonor.fecha_mod',type:'date'},
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
	title:'Puntos de Norma',
	ActSave:'../../sis_auditoria/control/PuntoNorma/insertarPuntoNorma',
	ActDel:'../../sis_auditoria/control/PuntoNorma/eliminarPuntoNorma',
	ActList:'../../sis_auditoria/control/PuntoNorma/listarPuntoNorma',
	id_store:'id_pn',
	fields: [
		{name:'id_pn', type: 'numeric'},
		{name:'id_norma', type: 'numeric'},
		{name:'nombre_pn', type: 'string'},
		{name:'codigo_pn', type: 'string'},
		{name:'descrip_pn', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'codigo_pn',
		direction: 'ASC'
	},
	bdel:true,
	bsave:false,
	onReloadPage: function(m){
		this.maestro=m;
		this.store.baseParams={id_norma:this.maestro.id_norma};
		this.load({params:{start:0, limit:50}})
	},
	loadValoresIniciales:function()
	{
		Phx.vista.PuntoNorma.superclass.loadValoresIniciales.call(this);
		this.Cmp.id_norma.setValue(this.maestro.id_norma);
		
	},
	tabeast:[
		{
			url:'../../../sis_auditoria/vista/pregunta/Pregunta.php',
			title: 'Preguntas de Puntos de Norma',
            width: '50%',
            cls: 'Pregunta'
		}
	]
	}
)
</script>
		
		