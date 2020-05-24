<?php
/**
*@package pXP
*@file gen-Proceso.php
*@author  (max.camacho)
*@date 15-07-2019 20:16:48
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Proceso=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Proceso.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_proceso'
			},
			type:'Field',
			form:true 
		},
        {
            config:{
                name: 'codigo_proceso',
                fieldLabel: 'Codigo Proceso',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:50
            },
            type:'TextField',
            filters:{pfiltro:'pcs.codigo_proceso',type:'string'},
            id_grupo:1,
            grid:false,
            form:true
        },
		{
			config:{
				name: 'proceso',
				fieldLabel: 'Proceso',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'pcs.proceso',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
        {
            config:{
                name: 'acronimo',
                fieldLabel: 'Acronimo/Sigla',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:30
            },
            type:'TextField',
            filters:{pfiltro:'pcs.acronimo',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
		{
			config:{
				name: 'descrip_proceso',
				fieldLabel: 'Descripcion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				//maxLength:-5
			},
				type:'TextArea',
				filters:{pfiltro:'pcs.descrip_proceso',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
        {
            config:{
                name:'id_responsable',
                hiddenName: 'desc_funcionario1',
                origen:'FUNCIONARIOCAR',
                fieldLabel:'Funcionario',
                allowBlank:false,
                gwidth:200,
                valueField: 'id_funcionario',
                gdisplayField: 'desc_funcionario1',
                baseParams: { es_combo_solicitud : 'si' },
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario1']);}
            },
            type:'ComboRec',
            id_grupo:0,
            filters:{pfiltro:'fun.desc_funcionario1',type:'string'},
            bottom_filter:true,
            grid:true,
            form:true
        },
         {
            config:{
                name:'vigencia',
                fieldLabel:'Vigencia',
                allowBlank:true,
                typeAhead: true,
                triggerAction: 'all',
                //emptyText:'Tipo...',
                lazyRender:true,
                selectOnFocus:true,
                mode:'local',
                store:['Si','No'],
                /*store:new Ext.data.ArrayStore({
                    fields: ['ID', 'valor'],
                    data :	[
                        ['0','No'],
                        ['1','Si']
                    ]
                }),
                valueField:'ID',
                displayField:'valor',*/
                anchor: '40%',
                gwidth:150
            },
            type:'ComboBox',
            id_grupo:0,
            valorInicial: 'Si',
            grid:true,
            //egrid: true,
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
				filters:{pfiltro:'pcs.estado_reg',type:'string'},
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
				filters:{pfiltro:'pcs.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'pcs.usuario_ai',type:'string'},
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
				filters:{pfiltro:'pcs.fecha_reg',type:'date'},
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
				filters:{pfiltro:'pcs.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Proceso Auditoria',
	ActSave:'../../sis_auditoria/control/Proceso/insertarProceso',
	ActDel:'../../sis_auditoria/control/Proceso/eliminarProceso',
	ActList:'../../sis_auditoria/control/Proceso/listarProceso',
	id_store:'id_proceso',
	fields: [
		{name:'id_proceso', type: 'numeric'},
		{name:'proceso', type: 'string'},
		{name:'descrip_proceso', type: 'string'},
		{name:'acronimo', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_responsable', type: 'numeric'},
		{name:'codigo_proceso', type: 'string'},
		{name:'vigencia', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_funcionario1', type: 'string'}

	],
	sortInfo:{
		field: 'id_proceso',
		direction: 'ASC'
	},
	bdel:true,
	bsave:false,
    onButtonNew:function(){
        Phx.vista.Proceso.superclass.onButtonNew.call(this);
        this.ocultarComponente(this.Cmp.codigo_proceso);
        },
    onButtonEdit:function(){
        Phx.vista.Proceso.superclass.onButtonEdit.call(this);
        this.ocultarComponente(this.Cmp.codigo_proceso);
    }
	}
)
</script>
		
		