<?php
/**
*@package pXP
*@file Norma.php
*@author  (szambrana)
*@date 02-07-2019 19:11:48
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Norma=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Norma.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}});
        console.log('hola');
	},

	Atributos:[
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
        //configuracion del componente -->id_parametro
		{
			config: {
				name: 'id_parametro',
				fieldLabel: 'Tipo de Norma (Parametro)',
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
					baseParams: {par_filtro: 'prm.id_parametro#prm.valor_parametro',id_tipo_parametro:3}
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
					//return String.format('{0}', record.data['valor_parametro']);
					return String.format('{0}', record.data['desc_tn']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'prm.valor_parametro',type: 'string'},
			grid: true,
			form: true
		},		


        {
            config:{
                name: 'sigla_norma',
                fieldLabel: 'Sigla de la Norma',
                allowBlank: false,
                anchor: '100%',
                gwidth: 150,
                maxLength:250
            },
            type:'TextField',
            filters:{pfiltro:'nor.sigla_norma',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
		{
			config:{
				name: 'nombre_norma',
				fieldLabel: 'Nombre de la Norma',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:500
			},
				type:'TextField',
				filters:{pfiltro:'nor.nombre_norma',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'descrip_norma',
				fieldLabel: 'Descripcion de la Norma',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100
				//maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'nor.descrip_norma',type:'string'},
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
            filters:{pfiltro:'nor.estado_reg',type:'string'},
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
				filters:{pfiltro:'nor.fecha_reg',type:'date'},
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
				filters:{pfiltro:'nor.usuario_ai',type:'string'},
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
				filters:{pfiltro:'nor.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'nor.fecha_mod',type:'date'},
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
	title:'Gestión de Normas',
	ActSave:'../../sis_auditoria/control/Norma/insertarNorma',
	ActDel:'../../sis_auditoria/control/Norma/eliminarNorma',
	ActList:'../../sis_auditoria/control/Norma/listarNorma',
	id_store:'id_norma',
	fields: [
		{name:'id_norma', type: 'numeric'},
		{name:'id_parametro', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'nombre_norma', type: 'string'},
		{name:'sigla_norma', type: 'string'},
		{name:'descrip_norma', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		//****************************
		{name:'desc_tn', type: 'string'},

	],
	sortInfo:{
		field: 'id_norma',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,

    tabsouth:[
			{
				url:'../../../sis_auditoria/vista/punto_norma/PuntoNorma.php',
				title: 'Puntos de Norma',
                height: '50%',
				cls: 'PuntoNorma'
			}
	]
	//**********Hasta aqui
	}
)
</script>
		
		