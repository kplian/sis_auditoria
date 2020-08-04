<?php
/**
*@package pXP
*@file gen-AuditoriaNpn.php
*@author  MMV
*@date 25-07-2019 21:19:37
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AuditoriaNpn=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.AuditoriaNpn.superclass.constructor.call(this,config);
		this.init();
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        }
        else {
            this.bloquearMenus();
        }
	},

	Atributos:[
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
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_aom'
            },
            type:'Field',
            form:true
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'codigo_parametro'
            },
            type:'Field',
            form:true
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'obs_apn'
            },
            type:'Field',
            form:true
        },
        {
            config: {
                name: 'id_norma',
                fieldLabel: 'Norma',
                allowBlank: false,
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
                gdisplayField: 'sigla_norma',
                tpl:'<tpl for="."><div class="x-combo-list-item"><p style="color:#01010a">{sigla_norma} - {nombre_norma}</p></div></tpl>',
                hiddenName: 'id_norma',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '90%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['sigla_norma']);
                },
                listeners: {
                    'afterrender': function(combo){
                    },
                    'expand':function (combo) {
                        this.store.reload();
                    }
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'nor.sigla_norma',type: 'string'},
            grid: false,
            form: true
        },
        {
            config: {
                name: 'id_pn',
                fieldLabel: 'Punto de Norma',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/PuntoNorma/listarPuntoNormaMulti',
                    id: 'id_pn',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_pn',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_pn', 'nombre_pn', 'codigo_pn'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'ptonor.codigo_pn#ptonor.nombre_pn'}
                }),
                valueField: 'id_pn',
                displayField: 'nombre_pn',
                gdisplayField: 'desc_pn',
                tpl:'<tpl for="."><div class="x-combo-list-item"><div class="awesomecombo-item {checked}"><p>{codigo_pn} - {nombre_pn}</p></div></div></tpl>',
                hiddenName: 'id_pn',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '90%',
                gwidth: 500,
                minChars: 2,
                enableMultiSelect: true,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['nombre_pn']);
                }
            },
            type: 'AwesomeCombo',
            id_grupo: 0,
            filters: {pfiltro: 'pnorm.nombre_pn',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'sigla_norma',
                fieldLabel: 'Norma',
                allowBlank: false,
                anchor: '10%',
                gwidth: 150
            },
            type:'TextField',
            // filters:{pfiltro:'aro.accion_ro',type:'string'},
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
				filters:{pfiltro:'anpn.estado_reg',type:'string'},
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
				filters:{pfiltro:'anpn.fecha_reg',type:'date'},
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
				filters:{pfiltro:'anpn.usuario_ai',type:'string'},
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
				filters:{pfiltro:'anpn.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'anpn.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,
	title:'Auditoria Norma Punto de Norma',
	ActSave:'../../sis_auditoria/control/AuditoriaNpn/insertarAuditoriaNpn',
	ActDel:'../../sis_auditoria/control/AuditoriaNpn/eliminarAuditoriaNpn',
	ActList:'../../sis_auditoria/control/AuditoriaNpn/listarAuditoriaNpn',
	id_store:'id_anpn',
	fields: [
		{name:'id_anpn', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
        {name:'id_aom', type: 'numeric'}, //
		{name:'id_pn', type: 'string'},
		{name:'id_norma', type: 'numeric'},
        {name:'obs_apn', type: 'string'},//
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'sigla_norma', type: 'string'},
        {name:'nombre_norma', type: 'string'},
		{name:'nombre_pn', type: 'string'},

	],
	sortInfo:{
		field: 'sigla_norma',
		direction: 'ASC'
	},
    tipoStore: 'GroupingStore',//GroupingStore o JsonStore #
    remoteGroup: true,
    groupField: 'sigla_norma',
    viewGrid: new Ext.grid.GroupingView({
        forceFit: false
    }),
	bdel:true,
	bsave:false,
    fwidth: '40%',
    fheight: '30%',
    onReloadPage:function(m){
        this.maestro = m;
        this.store.baseParams = {id_aom: this.maestro.id_aom};
        this.load({params:{start:0, limit:50}});
    },
    loadValoresIniciales: function () {
        Phx.vista.AuditoriaNpn.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);
    },
    preparaMenu:function(n){
        var tb =this.tbar;
        Phx.vista.AuditoriaNpn.superclass.preparaMenu.call(this,n);
        return tb
    },
    liberaMenu:function(){
        var tb = Phx.vista.AuditoriaNpn.superclass.liberaMenu.call(this);
        if(tb){
            console.log(tb)
        }
        return tb
    },
    onButtonNew :function () {
        Phx.vista.AuditoriaNpn.superclass.onButtonNew.call(this);
        this.Cmp.id_pn.enableMultiSelect=true;
        this.eventoFrom();
    },
    onButtonEdit:function () {
        Phx.vista.AuditoriaNpn.superclass.onButtonEdit.call(this);
        this.Cmp.id_pn.enableMultiSelect=false;
        this.Cmp.id_pn.type='ComboBox';
        this.eventoFrom();
    },
    eventoFrom:function(){
        this.Cmp.id_norma.on('select', function(combo, record, index){
            this.Cmp.id_pn.store.baseParams ={par_filtro: 'ptonor.codigo_pn#ptonor.nombre_pn',id_norma: record.data.id_norma};
            this.Cmp.id_pn.modificado = true;
            this.Cmp.id_pn.reset();
        },this);
    },
    east:{
        url:'../../../sis_auditoria/vista/auditoria_npnpg/AuditoriaNpnpg.php',
        title:'Pregunta(s)',
        width:'30%',
        cls:'AuditoriaNpnpg'
    }
	}
)
</script>
