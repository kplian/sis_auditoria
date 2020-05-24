<?php
/**
*@package pXP
*@file gen-GrupoConsultivo.php
*@author  (max.camacho)
*@date 22-07-2019 23:01:14
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.GrupoConsultivo=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.GrupoConsultivo.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_gconsultivo'
			},
			type:'Field',
			form:true 
		},
        {
            config: {
                name: 'id_empresa',
                fieldLabel: 'Empresa',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_parametros/control/Empresa/listarEmpresa',
                    id: 'id_empresa',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_empresa', 'nombre'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'nombre'}
                }),
                valueField: 'id_empresa',
                displayField: 'nombre',
                gdisplayField: 'nombre',
                hiddenName: 'id_empresa',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '80%',
                gwidth: 200,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['empresa']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'nombre_gconsultivo',
                fieldLabel: 'Grupo Consultivo',
                allowBlank: false,
                anchor: '80%',
                gwidth: 200
            },
            type:'TextField',
            filters:{pfiltro:'gct.nombre_gconsultivo',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'descrip_gconsultivo',
                fieldLabel: 'Descripcion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 200
            },
            type:'TextArea',
            filters:{pfiltro:'gct.descrip_gconsultivo',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'requiere_programacion',
                fieldLabel: 'Requiere Programacion',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
                maxLength:10,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                store:new Ext.data.ArrayStore({
                    fields: ['ID','valor'],
                    data: [
                        ['0','No'],
                        ['1','Si']
                    ]
                }),
                valueField: 'ID',
                displayField: 'valor',
                width: 300,
                gwidth:130
            },
            type:'ComboBox',
            filters:{pfiltro:'gct.requiere_programacion',type:'string'},
            valorInicial: 0,
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'requiere_formulario',
                fieldLabel: 'Requiere Formulario',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
                maxLength:10,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'local',
                store: new Ext.data.ArrayStore({
                    fields: ['ID','valor'],
                    data: [
                        ['0','No'],
                        ['1','Si']
                    ]
                }),
                valueField: 'ID',
                displayField: 'valor',
                width: 300,
                gwidth: 130
            },
            type:'ComboBox',
            valorInicial: 0,
            filters:{pfiltro:'gct.requiere_formulario',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
		{
			config:{
				name: 'nombre_programacion',
				fieldLabel: 'Nombre Programacion',
				allowBlank: true,
                emptyText: 'Si requiere programacion introduzca el nombre...',
				anchor: '80%',
				gwidth: 100,
				maxLength:80
			},
				type:'TextField',
				filters:{pfiltro:'gct.nombre_programacion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nombre_formulario',
				fieldLabel: 'Nombre Formulario',
				allowBlank: true,
                emptyText: 'Si requiere programacion introduzca el nombre...',
				anchor: '80%',
				gwidth: 100,
				maxLength:80
			},
				type:'TextField',
				filters:{pfiltro:'gct.nombre_formulario',type:'string'},
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
				filters:{pfiltro:'gct.estado_reg',type:'string'},
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
				filters:{pfiltro:'gct.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'gct.fecha_reg',type:'date'},
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
				filters:{pfiltro:'gct.usuario_ai',type:'string'},
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
				filters:{pfiltro:'gct.fecha_mod',type:'date'},
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
	title:'Grupo Consultivo',
	ActSave:'../../sis_auditoria/control/GrupoConsultivo/insertarGrupoConsultivo',
	ActDel:'../../sis_auditoria/control/GrupoConsultivo/eliminarGrupoConsultivo',
	ActList:'../../sis_auditoria/control/GrupoConsultivo/listarGrupoConsultivo',
	id_store:'id_gconsultivo',
	fields: [
		{name:'id_gconsultivo', type: 'numeric'},
		{name:'nombre_programacion', type: 'string'},
		{name:'id_empresa', type: 'numeric'},
		{name:'descrip_gconsultivo', type: 'string'},
		{name:'nombre_gconsultivo', type: 'string'},
		{name:'requiere_programacion', type: 'string'},
		{name:'nombre_formulario', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'requiere_formulario', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'empresa', type: 'string'}

	],
	sortInfo:{
		field: 'id_gconsultivo',
		direction: 'ASC'
	},
	bdel:true,
	bsave:false,
    onButtonNew: function(){
        Phx.vista.GrupoConsultivo.superclass.onButtonNew.call(this);
        this.getFormGC();

    },
    getFormGC: function(){
        this.Cmp.requiere_programacion.on('select',function (combo,record,index) {
            if(record.data.requiere_programacion.originalValue === 0){
                this.formGrupoConsultivo();
            }
            if(record.data.requiere_programacion === 1){
                this.formGCRP();
            }

        },this);
    },
    formGrupoConsultivo: function () {
        this.ocultarComponente(this.Cmp.nombre_programacion);
        this.ocultarComponente(this.Cmp.nombre_formulario);
        this.mostrarComponente(this.Cmp.id_empresa);
        this.mostrarComponente(this.Cmp.nombre_gconsultivo);
        this.mostrarComponente(this.Cmp.descrip_gconsultivo);
        this.mostrarComponente(this.Cmp.requiere_programacion);
        this.mostrarComponente(this.Cmp.requiere_formulario);
    },
    formGCRP: function () {
        this.mostrarComponente(this.Cmp.id_empresa);
        this.mostrarComponente(this.Cmp.nombre_gconsultivo);
        this.mostrarComponente(this.Cmp.descrip_gconsultivo);
        this.mostrarComponente(this.Cmp.requiere_programacion);
        this.mostrarComponente(this.Cmp.requiere_formulario);
        this.mostrarComponente(this.Cmp.nombre_programacion);
        this.mostrarComponente(this.Cmp.nombre_formulario);
    }
	}
)
</script>
		
		