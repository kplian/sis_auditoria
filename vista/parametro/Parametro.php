<?php
/**
*@package pXP
*@file gen-Parametro.php
*@author  (max.camacho)
*@date 03-07-2019 16:18:31
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Parametro=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Parametro.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_parametro'
			},
			type:'Field',
			form:true 
		},
		{
			config: {
				name: 'id_tipo_parametro',
				fieldLabel: 'Tipo Parametro',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_auditoria/control/TipoParametro/listarTipoParametro',
					id: 'id_tipo_parametro',
					root: 'datos',
					sortInfo: {
						field: 'descrip_parametro',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_tipo_parametro', 'tipo_parametro','descrip_parametro'],
					remoteSort: true,
					baseParams: {par_filtro: 'tpr.id_tipo_parametro'}
				}),
				valueField: 'id_tipo_parametro',
				displayField: 'descrip_parametro',
				gdisplayField: 'descrip_parametro',
				hiddenName: 'id_tipo_parametro',
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
					return String.format('{0}', record.data['descrip_parametro']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'tpr.tipo_parametro',type: 'string'},
			grid: true,
			form: true
		},
        {
            config:{
                name: 'valor_parametro',
                fieldLabel: 'Parametro',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
                maxLength:50
            },
            type:'TextField',
            filters:{pfiltro:'prm.valor_parametro',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'codigo_parametro',
                fieldLabel: 'Codigo Parametro',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
                maxLength:50
            },
            type:'TextField',
            filters:{pfiltro:'prm.codigo_parametro',type:'string'},
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
				filters:{pfiltro:'prm.estado_reg',type:'string'},
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
				filters:{pfiltro:'prm.fecha_reg',type:'date'},
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
				filters:{pfiltro:'prm.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'prm.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'prm.fecha_mod',type:'date'},
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
	title:'Parametro',
	ActSave:'../../sis_auditoria/control/Parametro/insertarParametro',
	ActDel:'../../sis_auditoria/control/Parametro/eliminarParametro',
	ActList:'../../sis_auditoria/control/Parametro/listarParametro',
	id_store:'id_parametro',
	fields: [
		{name:'id_parametro', type: 'numeric'},
		{name:'id_tipo_parametro', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'valor_parametro', type: 'string'},
		{name:'codigo_parametro', type: 'string'},
		//{name:'tipo_parametro', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'tipo_parametro', type: 'string'},
		{name:'descrip_parametro', type: 'string'},

	],
	sortInfo:{
		field: 'id_parametro',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    onButtonNew:function () {
        Phx.vista.Parametro.superclass.onButtonNew.call(this);
        this.mostrarComponente(this.Cmp.codigo_parametro);
        this.Cmp.codigo_parametro.enable();
    },
    onButtonEdit:function () {
        Phx.vista.Parametro.superclass.onButtonEdit.call(this);
        this.Cmp.codigo_parametro.disable(true);
    }
	}
)
</script>
		
		