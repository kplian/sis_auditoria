<?php
/**
*@package pXP
*@file gen-SistemaIntegrado.php
*@author  (szambrana)
*@date 24-07-2019 21:09:26
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

//prueba de en tiempo real

*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SistemaIntegrado=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.SistemaIntegrado.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_si'
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
		/*
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
				filters:{pfiltro:'sisint.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		*/
		{
			config:{
				name: 'nombre_si',
				fieldLabel: 'nombre_si',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:250
			},
				type:'TextField',
				filters:{pfiltro:'sisint.nombre_si',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'descrip_si',
				fieldLabel: 'Sistema integrado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				//maxLength:500
			},
				type:'TextField',
				filters:{pfiltro:'sisint.descrip_si',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
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
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'sisint.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'sisint.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'sisint.usuario_ai',type:'string'},
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
				filters:{pfiltro:'sisint.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Sistemas Integrados',
	ActSave:'../../sis_auditoria/control/SistemaIntegrado/insertarSistemaIntegrado',
	ActDel:'../../sis_auditoria/control/SistemaIntegrado/eliminarSistemaIntegrado',
	ActList:'../../sis_auditoria/control/SistemaIntegrado/listarSistemaIntegrado',
	id_store:'id_si',
	fields: [
		{name:'id_si', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'nombre_si', type: 'string'},
		{name:'descrip_si', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_si',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	tabeast:[
		{
			url:'../../../sis_auditoria/vista/resp_sist_integrados/RespSistIntegrados.php',
			title:'Responsables Sistemas Integrados',
			width: '60%',
			cls: 'RespSistIntegrados' 
		}
	]
	}
)
</script>
		
		