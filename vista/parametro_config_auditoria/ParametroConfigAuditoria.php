<?php
/**
*@package pXP
*@file gen-ParametroConfigAuditoria.php
*@author  (max.camacho)
*@date 20-08-2019 16:16:47
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ParametroConfigAuditoria=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.ParametroConfigAuditoria.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_param_config_aom'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'param_gestion',
				fieldLabel: 'Gestion',
				allowBlank: false,
                minValue : (new Date().getFullYear()),
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'pcaom.param_gestion',type:'numeric'},
				id_grupo:1,
                valorInicial: (new Date().getFullYear()),
				grid:true,
				form:true
		},
		{
			config:{
				name: 'param_fecha_a',
				fieldLabel: 'Fecha Inicio',
				allowBlank: false,
                //minValue : (new Date()).clearTime(),
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y',
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'pcaom.param_fecha_a',type:'date'},
				id_grupo:1,
                valorInicial: (new Date().getDate()),
				grid:true,
				form:true
		},
		{
			config:{
				name: 'param_fecha_b',
				fieldLabel: 'Fecha Fin',
				allowBlank: false,
                minValue : (new Date()).clearTime(),
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'pcaom.param_fecha_b',type:'date'},
				id_grupo:1,
                valorInicial: (new Date().getDate()),
				grid:true,
				form:true
		},
        {
            config:{
                name: 'param_prefijo',
                fieldLabel: 'Prefijo',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
                minLength:2,
                maxLength:12
            },
            type:'TextField',
            filters:{pfiltro:'pcaom.param_prefijo',type:'string'},
            id_grupo:1,
            valorInicial: 'EAOM',
            grid:true,
            form:true
        },
		{
			config:{
				name: 'param_serie',
				fieldLabel: 'Serie',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
                minLength:5,
				maxLength:12
			},
				type:'TextField',
				filters:{pfiltro:'pcaom.param_serie',type:'string'},
				id_grupo:1,
                valorInicial: '00000',
				grid:true,
				form:true
		},
		/*{
			config:{
				name: 'param_estado_config',
				fieldLabel: 'Estado Configuracion',
				allowBlank: false,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                selectOnFocus:true,
                mode:'local',
                store:new Ext.data.ArrayStore({
                    fields: ['ID', 'valor'],
                    data :	[
                        ['Activo','Activo'],
                        ['Inactivo','Inactivo']
                    ]
                }),
                valueField:'ID',
                displayField:'valor',
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
				type:'ComboBox',
				filters:{pfiltro:'pcaom.param_estado_config',type:'string'},
				id_grupo:1,
                valorInicial: 'Activo',
				grid:true,
				form:true
		},*/
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
            filters:{pfiltro:'pcaom.estado_reg',type:'string'},
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
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'pcaom.fecha_reg',type:'date'},
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
				filters:{pfiltro:'pcaom.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'pcaom.usuario_ai',type:'string'},
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
				filters:{pfiltro:'pcaom.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Parametro Configuracion Auditoria',
	ActSave:'../../sis_auditoria/control/ParametroConfigAuditoria/insertarParametroConfigAuditoria',
	ActDel:'../../sis_auditoria/control/ParametroConfigAuditoria/eliminarParametroConfigAuditoria',
	ActList:'../../sis_auditoria/control/ParametroConfigAuditoria/listarParametroConfigAuditoria',
	id_store:'id_param_config_aom',
	fields: [
		{name:'id_param_config_aom', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'param_gestion', type: 'numeric'},
		{name:'param_fecha_a', type: 'date',dateFormat:'Y-m-d'},
		{name:'param_fecha_b', type: 'date',dateFormat:'Y-m-d'},
		{name:'param_prefijo', type: 'string'},
		{name:'param_serie', type: 'string'},
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
		field: 'id_param_config_aom',
		direction: 'ASC'
	},
	bdel:true,
	bsave:false
	}
)
</script>
		
		