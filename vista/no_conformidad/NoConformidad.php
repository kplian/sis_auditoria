<?php
/**
*@package pXP
*@file gen-NoConformidad.php
*@author  (szambrana)
*@date 04-07-2019 19:53:16
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.NoConformidad=Ext.extend(Phx.gridInterfaz,{
	nombreVista: 'base',
    dblclickEdit: true,

    constructor:function(config){
		this.maestro=config.maestro;
    	Phx.vista.NoConformidad.superclass.constructor.call(this,config);
		this.store.baseParams = {tipo_interfaz: this.nombreVista};
		this.init();

        this.addButton('btnChequeoDocumentosWf', {
            text: 'Documentos',
            iconCls: 'bchecklist',
            disabled: false,
            handler: this.loadCheckDocumentosPlanWf,
            tooltip: '<b>Documentos de la No conformidad</b><br/>Subir los documentos de evidencia.',
            scope:this
        });

        
        this.addButton('btnNoram', {
                text: 'Puntos Norma',
                iconCls: 'bdocuments',
                disabled: false,
                handler: this.onButtonPuntoNorma,
                tooltip: '<b>Asigna puntos de norma a la No conformidades...</b>',
                scope:this
        });
    },

	Atributos:[
                {
                    //configuracion del componente --> id_nc

                    config:{
                            labelSeparator:'',
                            inputType:'hidden',
                            name: 'id_nc'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                            labelSeparator:'',
                            inputType:'hidden',
                            name: 'id_uo'
                    },
                    type:'Field',
                    form:true
                },
                {
                    //configuracion del componente --> id_aom
                    config:{
                            labelSeparator:'',
                            inputType:'hidden',
                            name: 'id_aom'
                    },
                    type:'Field',
                    form:true
                },
                {
                    //configuracion del componente -->id_estado_wf
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_estado_wf'
                    },
                    type:'Field',
                    form:true
                },
                {
                    //configuracion del componente -->id_proceso_wf
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_proceso_wf'
                    },
                    type:'Field',
                    form:true
                },
                {
                    //configuracion del componente -->id_proceso_wf
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'nro_tramite_padre'
                    },
                    type:'Field',
                    form:true
                },
                {
                    //configuracion del componente -->id_proceso_wf
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'nombre_aom1'
                    },
                    type:'Field',
                    form:true
                },
                {
                    //configuracion del componente -->id_proceso_wf
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'nombre_unidad'
                    },
                    type:'Field',
                    form:true
                },
                {
                    //configuracion del componente -->id_proceso_wf
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'desc_funcionario_resp'
                    },
                    type:'Field',
                    form:true
                },
                {
                    //configuracion del componente -->id_proceso_wf
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'extra',
                        value: 'no'
                    },
                    type:'Field',
                    form:true
                },
                {
                    //configuracion del componente -->id_proceso_wf
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'estado_wf',
                    },
                    type:'Field',
                    form:true
                },
                {
		 	     config:{
		 	         name: 'revisar',
		 	         fieldLabel: 'Revisar',
		 	         allowBlank: true,
		 	         anchor: '40%',
		 	         gwidth: 60,
		 	         typeAhead: true,
		 	         triggerAction: 'all',
		 	         lazyRender:true,
		 	         mode: 'local',
		 	         store:['si','no'],
		 	         renderer:function (value,p,record){
		 	             let checked = '';
		 	             if(value === 'si'){
		 	                 checked = 'checked';
		 	             }
		 	             return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:20px;width:20px;" type="checkbox"{0}></div>',checked);
		 	         }
		 	     },
		 	     type:'ComboBox',
		 	     id_grupo:3,
		 	     valorInicial: 'no',
		 	     filters: { pfiltro: 'rho.martes', type: 'string' },
		 	     grid: true,
		 	     form: false
		 	 },
			 {
				 config:{
						 name: 'rechazar',
						 fieldLabel: 'Rechazar',
						 allowBlank: true,
						 anchor: '40%',
						 gwidth: 60,
						 typeAhead: true,
						 triggerAction: 'all',
						 lazyRender:true,
						 mode: 'local',
						 store:['si','no'],
						 renderer:function (value,p,record){
								 let checked = '';
								 if(value === 'si'){
										 checked = 'checked';
								 }
								 return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:20px;width:20px;" type="checkbox"{0}></div>',checked);
						 }
				 },
				 type:'ComboBox',
				 id_grupo:3,
				 valorInicial: 'no',
				 filters: { pfiltro: 'rho.martes', type: 'string' },
				 grid: true,
				 form: false
		 },
        {
            config:{
                name: 'nro_tramite',
                fieldLabel: 'Nro Tramite',
                allowBlank: true,
                anchor: '75%',
                gwidth: 100,

            },
            type:'TextField',
            filters:{pfiltro:'smt.nro_tramite',type:'string'},
            id_grupo:1,
            grid:false,
            form:false
        },
		{
			config:{
				name: 'codigo_nc',
				fieldLabel: 'Codigo',
				allowBlank: true,
				anchor: '75%',
				gwidth: 150,
                renderer : function(value, p, record) {
                    return String.format('<a>{0}</a>', value);
                }
			},
				type:'Field',
				filters:{pfiltro:'noconf.codigo_nc',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config: {
				name: 'id_parametro',
				fieldLabel: 'Tipo',
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
					baseParams: {par_filtro: 'prm.id_parametro#prm.valor_parametro',tipo_no:'TIPO_NO_CONFORMIDAD'}
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
                width:100,
				gwidth: 90,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('<a>{0}</a>', record.data['valor_parametro']);
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
                name: 'descrip_nc',
                fieldLabel: 'Descripcion',
                allowBlank: true,
                width:200,
                gwidth: 400,
                renderer : function(value, p, record) {
                    return String.format('<a>{0}</a>', value);
                }
            },
            type:'TextArea',
            filters:{pfiltro:'noconf.descrip_nc',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'nombre_estado',
                fieldLabel: 'Estado',
                allowBlank: true,
                gwidth: 200,
               /* renderer: function(value,p,record){
                    let color = '#1419CC';

                    if (record.data['estado_wf'] === 'aceptada_responsable_area'){
                        color = '#0a7f15';
                    }
                    if (record.data['estado_wf'] === 'rechazada_responsable_area'){
                        color = '#a20007';
                    }

                    return '<font color="'+color+'">'+record.data['estado_wf']+'</font>';
                }*/
            },
            type:'TextField',
            filters:{pfiltro:'smt.estado',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
        {
            config:{
                name: 'funcionario_resp_nc',
                fieldLabel: 'Resp. No Conformidad',
                allowBlank: true,
                anchor: '80%',
                gwidth: 200,
                renderer : function(value, p, record) {
                    if(record.data['funcionario_resp_nc']){
                        return String.format('<b>{0}</b>', record.data['funcionario_resp_nc']);
                    }

                }
            },
            type:'TextField',
            filters:{pfiltro:'rfun.funcionario_resp_nc',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
        {
            config : {
                name : 'id_uo',
                baseParams : {
                    gerencia : 'si'
                },
                origen : 'UO',
                allowBlank: true,
                fieldLabel : 'Area',
                gdisplayField : 'gerencia_uo1', //mapea al store del grid
                anchor: '75%',
                gwidth: 250,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['gerencia_uo1']);
                }
            },
            type : 'ComboRec',
            id_grupo : 1,
            filters : {
                pfiltro : 'desc_uo',
                type : 'string'
            },
            grid : true,
            form : true
        },
        {
            config : {
                name : 'id_funcionario',
                origen : 'FUNCIONARIOCAR',
                fieldLabel : 'Responsable Area',
                gdisplayField : 'funcionario_uo', //mapea al store del grid
                valueField : 'id_funcionario',
                anchor: '75%',
                gwidth: 250,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['funcionario_uo']);
                }
            },
            type : 'ComboRec',
            id_grupo : 2,
            grid : true,
            form : true
        },
		{
			config:{
				name: 'evidencia',
				fieldLabel: 'Evidencia',
				allowBlank: true,
				anchor: '75%',
				gwidth: 150,
				maxLength:500,
				renderer: function(value, p, record) {
                    return String.format('{0}', value);
                }
			},
				type:'TextField',
				filters:{pfiltro:'noconf.evidencia',type:'string'},
				id_grupo:1,
				grid:false,
				form:true
		},
		{
			config:{
				name: 'obs_resp_area',
				fieldLabel: 'Observacion responsable de Area',
				allowBlank: true,
				anchor: '75%',
				gwidth: 200,
                renderer: function(value, p, record) {
                    return String.format('{0}', value);

                }
			},
				type:'TextArea',
				filters:{pfiltro:'noconf.obs_resp_area',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'obs_consultor',
				fieldLabel: 'Observacion Consultor',
				allowBlank: true,
				anchor: '75%',
				gwidth: 200,
				//maxLength:-5
				renderer: function(value, p, record) {
                    return String.format('{0}', value);

                }
			},
				type:'TextArea',
				filters:{pfiltro:'noconf.obs_consultor',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
        {
            config:{
                name: 'calidad',
                fieldLabel: 'Calidad',
                allowBlank: true,
                anchor: '100%',
                gwidth: 100,
                renderer : function(value, p, record) {
                    let cap =  (value === 't');
                    if(cap){
                        return 'si';
                    }
                    return 'no';
                },
            },
            type:'Checkbox',
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'medio_ambiente',
                fieldLabel: 'Medio Ambiente',
                allowBlank: true,
                anchor: '100%',
                gwidth: 100,
                renderer : function(value, p, record) {
                    let cap =  (value === 't');
                    if(cap){
                        return 'si';
                    }
                    return 'no';
                },
            },
            type:'Checkbox',
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'seguridad',
                fieldLabel: 'Seguridad',
                allowBlank: true,
                anchor: '100%',
                gwidth: 100,
                renderer : function(value, p, record) {
                     let cap =  (value === 't');
                     if(cap){
                        return 'si';
                     }
                     return 'no';
                },
            },
            type:'Checkbox',
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'responsabilidad_social',
                fieldLabel: 'Responsabilidad Social',
                allowBlank: true,
                anchor: '100%',
                gwidth: 100,
                renderer : function(value, p, record) {
                    let cap =  (value === 't');
                    if(cap){
                        return 'si';
                    }
                    return 'no';
                },
            },
            type:'Checkbox',
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'sistemas_integrados',
                fieldLabel: 'Sistemas Integrados',
                allowBlank: true,
                anchor: '100%',
                gwidth: 100,
                renderer : function(value, p, record) {
                    let cap =  (value === 't');
                    if(cap){
                        return 'si';
                    }
                    return 'no';
                },
            },
            type:'Checkbox',
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
            filters:{pfiltro:'noconf.estado_reg',type:'string'},
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
				filters:{pfiltro:'noconf.fecha_reg',type:'date'},
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
				filters:{pfiltro:'noconf.usuario_ai',type:'string'},
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
				filters:{pfiltro:'noconf.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'noconf.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,
	title:'No Conformidades',
	ActSave:'../../sis_auditoria/control/NoConformidad/insertarNoConformidad',
	ActDel:'../../sis_auditoria/control/NoConformidad/eliminarNoConformidad',
	ActList:'../../sis_auditoria/control/NoConformidad/listarNoConformidad',
	id_store:'id_nc',
	fields: [
		{name:'id_nc', type: 'numeric'},
		{name:'obs_consultor', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'evidencia', type: 'string'},
		{name:'id_funcionario', type: 'int4'}, //aumentado
        {name:'id_uo', type: 'numeric'},
		{name:'descrip_nc', type: 'string'},
        {name:'id_parametro', type: 'numeric'},
		{name:'obs_resp_area', type: 'string'},
        {name:'id_aom', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_uo_adicional', type: 'numeric'},
        {name:'id_proceso_wf', type: 'numeric'},
		{name:'id_estado_wf', type: 'numeric'},
        {name:'nro_tramite', type: 'string'},
        {name:'estado_wf', type: 'string'},
		{name:'codigo_nc', type: 'string'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'nombreaom', type: 'string'}, //aumentado
		{name:'valor_parametro', type: 'string'},
        {name:'gerencia_uo1', type: 'string'},
		{name:'gerencia_uo2', type: 'string'},
		{name:'funcionario_uo', type: 'string'},
		{name:'contador_estados', type: 'numeric'},
		{name:'funcionario_resp_nc', type: 'numeric'},

        {name:'calidad', type: 'string'},
        {name:'medio_ambiente', type: 'string'},
        {name:'seguridad', type: 'string'},
        {name:'responsabilidad_social', type: 'string'},
        {name:'sistemas_integrados', type: 'string'},

        {name:'revisar', type: 'string'},
        {name:'rechazar', type: 'string'},

        {name:'nombre_aom1', type: 'string'},
        {name:'nombre_unidad', type: 'string'},
        {name:'desc_funcionario_resp', type: 'string'},
        {name:'extra', type: 'string'},

        {name:'auditoria', type: 'string'},
        {name:'uo_aom', type: 'string'},
        {name:'aom_funcionario_resp', type: 'string'},
        {name:'funcionario_resp_nc', type: 'string'},
        {name:'nombre_estado', type: 'string'},
	],
	sortInfo:{
		field: 'id_nc',
		direction: 'ASC'
	},
	bdel:true,
	bsave:false,
    onButtonPuntoNorma:function () {
        var rec = this.sm.getSelected();
        Phx.CP.loadWindows('../../../sis_auditoria/vista/pnorma_noconformidad/PnormaNoconformidad.php', 'Puntos de Norma',{
            //modal : true,
            width:'70%',
            height:'70%'
        }, rec.data,
            this.idContenedor, 'PnormaNoconformidad');
    },
    onButtonEdit:function(){
        Phx.vista.NoConformidad.superclass.onButtonEdit.call(this);
        const rec = this.sm.getSelected().data;
        this.Cmp.calidad.setValue(this.onBool(rec.calidad));
        this.Cmp.medio_ambiente.setValue(this.onBool(rec.medio_ambiente));
        this.Cmp.seguridad.setValue(this.onBool(rec.seguridad));
        this.Cmp.responsabilidad_social.setValue(this.onBool(rec.responsabilidad_social));
        this.Cmp.sistemas_integrados.setValue(this.onBool(rec.sistemas_integrados));
    },
    onBool:function(valor){
        return  (valor === 't');
    },
	}
)
</script>
