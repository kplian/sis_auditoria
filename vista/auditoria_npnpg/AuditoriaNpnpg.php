<?php
/**
*@package pXP
*@file gen-AuditoriaNpnpg.php
*@author  (max.camacho)
*@date 25-07-2019 21:34:47
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AuditoriaNpnpg=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.AuditoriaNpnpg.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
        //this.bloquearMenu();
        /*var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        }
        else {
            this.bloquearMenus();
        }*/
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_anpnpg'
			},
			type:'Field',
			form:true 
		},
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_anpn'
            },
            type:'Field',
            form:true
        },
        /*{
            config: {
                name: 'id_anpn',
                fieldLabel: '#Punto Norma',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/PuntoNorma/listarPuntoNorma',
                    id: 'id_anpn',
                    root: 'datos',
                    sortInfo: {
                        field: 'id_pn',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_anpn', 'nombre_pn'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'movtip.nombre#movtip.codigo'}
                }),
                valueField: 'id_pn',
                displayField: 'id_pn',
                gdisplayField: 'id_pn',
                hiddenName: 'id_anpn',
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
                    return String.format('# {0}', record.data['id_pn']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },*/
        {
            config: {
                name: 'id_pregunta',
                fieldLabel: 'Pregunta',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/Pregunta/listarPregunta',
                    id: 'id_pregunta',
                    root: 'datos',
                    sortInfo: {
                        field: 'descrip_pregunta',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_pregunta', 'descrip_pregunta'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'prptnor.descrip_pregunta'}
                }),
                valueField: 'id_pregunta',
                displayField: 'descrip_pregunta',
                gdisplayField: 'descrip_pregunta',
                hiddenName: 'id_pregunta',
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
                    return String.format('{0}', record.data['descrip_pregunta']);
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
				name: 'pg_valoracion',
				fieldLabel: 'Valoracion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
				type:'TextField',
				filters:{pfiltro:'apnp.pg_valoracion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'obs_pg',
				fieldLabel: 'obs_pg',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:-5
			},
				type:'TextArea',
				filters:{pfiltro:'apnp.obs_pg',type:'string'},
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
				filters:{pfiltro:'apnp.estado_reg',type:'string'},
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
				filters:{pfiltro:'apnp.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'apnp.fecha_reg',type:'date'},
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
				filters:{pfiltro:'apnp.usuario_ai',type:'string'},
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
				filters:{pfiltro:'apnp.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Auditoria Puntos Norma Pregunta',
	ActSave:'../../sis_auditoria/control/AuditoriaNpnpg/insertarAuditoriaNpnpg',
	ActDel:'../../sis_auditoria/control/AuditoriaNpnpg/eliminarAuditoriaNpnpg',
	ActList:'../../sis_auditoria/control/AuditoriaNpnpg/listarAuditoriaNpnpg',
	id_store:'id_anpnpg',
	fields: [
		{name:'id_anpnpg', type: 'numeric'},
		{name:'pg_valoracion', type: 'string'},
		{name:'obs_pg', type: 'string'},
		{name:'id_pregunta', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_anpn', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'nombre_pn', type: 'string'},
		{name:'id_pn', type: 'numeric'},
		{name:'descrip_pregunta', type: 'string'},

	],
	sortInfo:{
		field: 'id_anpnpg',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    onReloadPage:function (m) {
        this.maestro=m;
        console.log('Maestrito:',this.maestro);
        this.store.baseParams={id_anpn:this.maestro.id_anpn};
        this.load({params:{start:0, limit:50}});
        this.Cmp.id_anpn.disable(true);
        this.Cmp.id_pregunta.store.baseParams.id_pn = this.maestro.id_pn;
    },
    loadValoresIniciales: function () {
        this.Cmp.id_anpn.setValue(this.maestro.id_anpn);
        Phx.vista.AuditoriaNpnpg.superclass.loadValoresIniciales.call(this);
    },
    /*onButtonNew :function () {
        Phx.vista.AuditoriaNpnpg.superclass.onButtonNew.call(this);
        this.Cmp.id_anpn.setValue(this.maestro.id_anpn);
        /// filtros combo
        this.Cmp.id_pn.on('select', function(combo, record, index){
            this.Cmp.id_anpn.store.baseParams ={par_filtro: 'pnorm.nombre_pn#pnorm.codigo_pn',id_pn : record.data.id_pn};
            this.Cmp.id_anpn.reset();
            this.store.removeAll();
            this.Cmp.id_anpn.modificado = true;
        },this);
        this.Cmp.id_anpn.on('select', function(combo, record, index){
            this.Cmp.nombre_pn.reset();
            this.Cmp.nombre_pn.setValue(record.data.nombre_pn);
        },this);
    },*/

	}
)
</script>
		
		