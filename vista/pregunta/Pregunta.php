<?php
/**
*@package pXP
*@file gen-Pregunta.php
*@author  (szambrana)
*@date 01-07-2019 19:04:06
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Pregunta=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Pregunta.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
	},

	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pregunta'
			},
			type:'Field',
			form:true
		},

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
			config:{
				name: 'nro_pregunta',
				fieldLabel: 'Numero de pregunta',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'prptnor.nro_pregunta',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'descrip_pregunta',
				fieldLabel: 'Descripcion de la Pregunta',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				//maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'prptnor.descrip_pregunta',type:'string'},
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
				filters:{pfiltro:'prptnor.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		//esta linea debo de subir

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
				filters:{pfiltro:'prptnor.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'prptnor.usuario_ai',type:'string'},
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
				filters:{pfiltro:'prptnor.fecha_reg',type:'date'},
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
				filters:{pfiltro:'prptnor.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,
	title:'Preguntas para los Puntos de Norma',
	ActSave:'../../sis_auditoria/control/Pregunta/insertarPregunta',
	ActDel:'../../sis_auditoria/control/Pregunta/eliminarPregunta',
	ActList:'../../sis_auditoria/control/Pregunta/listarPregunta',
	id_store:'id_pregunta',
	fields: [
		{name:'id_pregunta', type: 'numeric'},
		{name:'nro_pregunta', type: 'numeric'},
		{name:'descrip_pregunta', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_pn', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},

	],
	sortInfo:{
		field: 'id_pregunta',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	//****************
	onReloadPage: function(m){
	this.maestro=m;
	this.store.baseParams={id_pn:this.maestro.id_pn};
	this.load({params:{start:0, limit:50}});

	},
	loadValoresIniciales:function()
	{
		Phx.vista.Pregunta.superclass.loadValoresIniciales.call(this);
		this.Cmp.id_pn.setValue(this.maestro.id_pn);

	}
	//*******************
	}
)
</script>
