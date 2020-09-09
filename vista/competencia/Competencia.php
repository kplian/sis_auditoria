<?php
/**
*@package pXP
*@file gen-Competencia.php
*@author  (admin.miguel)
*@date 03-09-2020 16:11:08
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-09-2020				 (admin.miguel)				CREACION	

*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Competencia=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
        this.idContenedor = config.idContenedor;
        this.maestro=config;

		Phx.vista.Competencia.superclass.constructor.call(this,config);
		this.init();
	},
    onReloadPage: function(m){
        this.maestro=m;
        this.store.baseParams={id_equipo_auditores:this.maestro.id_equipo_auditores};
        this.load({params:{start:0, limit:50}});
    },
    loadValoresIniciales: function () {
        Phx.vista.Competencia.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_equipo_auditores.setValue(this.maestro.id_equipo_auditores);
    },
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_competencia'
			},
			type:'Field',
			form:true 
		},
        {
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_equipo_auditores'
			},
			type:'Field',
			form:true
		},
		{
			config: {
				name: 'id_norma',
				fieldLabel: 'Siglas',
				allowBlank: true,
				emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/Norma/listarNorma',
                    id: 'id_norma',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_norma',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_norma', 'id_tipo_norma','nombre_norma','sigla_norma','descrip_norma'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'nor.sigla_norma'}
                }),
				valueField: 'id_norma',
				displayField: 'sigla_norma',
				gdisplayField: 'desc_sigla_norma',
				hiddenName: 'id_norma',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '80%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_sigla_norma']);
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
				name: 'nro_auditorias',
				fieldLabel: 'Nro. Auditorias',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'coa.nro_auditorias',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true,
                egrid:true
		},
		{
			config:{
				name: 'hras_formacion',
				fieldLabel: 'Horas Formacion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'coa.hras_formacion',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true,
                egrid:true

        },
		{
			config:{
				name: 'meses_actualizacion',
				fieldLabel: 'Meses Actualizacion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'coa.meses_actualizacion',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true,
                egrid:true

        },
        {
            config:{
                name:'calificacion',
                fieldLabel:'Calificacion',
                typeAhead: true,
                allowBlank:true,
                triggerAction: 'all',
                emptyText:'Tipo...',
                selectOnFocus:true,
                mode:'local',
                store:new Ext.data.ArrayStore({
                    fields: ['ID', 'valor'],
                    data :	[
                        ['básico','Básico'],
                        ['recomendable','Recomendable'],
                        ['suficiente','Suficiente'],
                        ['recomendable','Recomendable']
                    ]
                }),
                valueField:'ID',
                displayField:'valor',
                gwidth:100
            },
            type:'ComboBox',
            id_grupo:1,
            grid:true,
            form:true,
            egrid:true
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
                name: 'estado_reg',
                fieldLabel: 'Estado Reg.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10
            },
            type:'TextField',
            filters:{pfiltro:'coa.estado_reg',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
        {
            config:{
                name: 'obs_dba',
                fieldLabel: 'obs_dba',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:-5
            },
            type:'TextField',
            filters:{pfiltro:'coa.obs_dba',type:'string'},
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
				filters:{pfiltro:'coa.fecha_reg',type:'date'},
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
				filters:{pfiltro:'coa.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'coa.usuario_ai',type:'string'},
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
				filters:{pfiltro:'coa.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Competencia',
	ActSave:'../../sis_auditoria/control/Competencia/insertarCompetencia',
	ActDel:'../../sis_auditoria/control/Competencia/eliminarCompetencia',
	ActList:'../../sis_auditoria/control/Competencia/listarCompetencia',
	id_store:'id_competencia',
	fields: [
		{name:'id_competencia', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'obs_dba', type: 'string'},
		{name:'id_equipo_auditores', type: 'numeric'},
		{name:'id_norma', type: 'numeric'},
		{name:'nro_auditorias', type: 'numeric'},
		{name:'hras_formacion', type: 'numeric'},
		{name:'meses_actualizacion', type: 'numeric'},
		{name:'calificacion', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'desc_sigla_norma', type: 'string'},
		{name:'nombre_norma', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_competencia',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    bedit:false
    }
)
</script>
		
		