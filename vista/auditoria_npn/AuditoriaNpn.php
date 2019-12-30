<?php
/**
*@package pXP
*@file gen-AuditoriaNpn.php
*@author  (max.camacho)
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
		//this.load({params:{start:0, limit:this.tam_pag}})
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        //console.log("data oadre",dataPadre);
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        }
        else {
            this.bloquearMenus();
        }
        //this.nodoVista();
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
                tpl:'<tpl for=".">'+
                    '<div class="x-combo-list-item" >'+
                        '<div class=""><p> Sigla: <b>{sigla_norma}</b></p></div>'+
                        '<div><p style="padding-left: 0px;">Nombre: <b>{nombre_norma}</b></p></div>'+
                    '</div></tpl>',
                valueField: 'id_norma',
                displayField: 'sigla_norma',
                gdisplayField: 'sigla_norma',
                hiddenName: 'id_norma',
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
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_pn',
                fieldLabel: 'Punto de Norma',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/PuntoNorma/listarPuntoNorma',
                    id: 'id_pn',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_pn',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_pn', 'codigo_pn', 'nro_pn', 'nombre_pn', 'descrip_pn'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'pnor.nombre_pn'}
                }),
                tpl:'<tpl for=".">'+
                    '<div class="x-combo-list-item" >'+
                        '<div class=""><p> Punto: <b>{nro_pn}</b></p></div>'+
                        '<div><p>Nombre: <b>{nombre_pn}</b></p></div>'+
                        '<div><p>Descripcion: <b>{descrip_pn}</b></p></div>'+
                    '</div></tpl>',
                valueField: 'id_pn',
                displayField: 'nombre_pn',
                gdisplayField: 'nombre_pn',
                hiddenName: 'id_pn',
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
                    return String.format('{0}', record.data['desc_punto_norma']);
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
                name: 'obs_apn',
                fieldLabel: 'Observacion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:1000
            },
            type:'TextArea',
            filters:{pfiltro:'anpn.obs_apn',type:'string'},
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
		{name:'id_pn', type: 'numeric'},
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
		{name:'desc_punto_norma', type: 'string'},

	],
	sortInfo:{
		field: 'id_anpn',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    east:{
        url:'../../../sis_auditoria/vista/auditoria_npnpg/AuditoriaNpnpg.php',
        title:'Pregunta(s)',
        height:'40%',
        width: '50%',
        cls:'AuditoriaNpnpg'
    },
    onReloadPage:function(m){
        /*this.maestro=m;
        this.store.baseParams = {id_anorma: this.maestro.id_anorma};
        console.log('maestro',this.maestro);
        //Ext.apply(this.Cmp.id_centro_costo.store.baseParams,{id_gestion: this.maestro.id_gestion});
        this.load({params:{start:0, limit:50}});
        // Envio de parametro para hacer consulta en Punto de Norma
        this.Cmp.id_anorma.disable(true);
        this.Cmp.id_pn.store.baseParams.id_norma = this.maestro.id_norma;*/

        this.maestro=m;
        this.store.baseParams = {id_aom: this.maestro.id_aom};
        //Ext.apply(this.Cmp.id_centro_costo.store.baseParams,{id_gestion: this.maestro.id_gestion});
        this.load({params:{start:0, limit:50}});
        this.Cmp.id_aom.disable(true);
        //console.log("masesto---->",this.maestro);
        this.Cmp.id_norma.store.baseParams.p_id_parametro = this.maestro.id_tnorma;
        //this.Cmp.codigo_parametro.store.baseParams.codigo_parametro = this.maestro.codigo_parametro;

        /*bloquearMenus:function(){
            this.grid.getBottomToolbar().disable();
            this.tbar.disable();
            //this.bloquearOrdenamientoGrid();

        },*/
    },
    loadValoresIniciales: function () {
        //this.Cmp.id_anorma.setValue(this.maestro.id_anorma);

        Phx.vista.AuditoriaNpn.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);

        //this.Cmp.codigo_parametro.setValue(this.maestro.codigo_parametro);
        console.log("codigo parametro:",this.maestro.codigo_parametro);
    },
    /*success: function(resp){
        Phx.CP.loadingHide();
        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
    },*/
    tipoStore: 'GroupingStore',//GroupingStore o JsonStore #
    remoteGroup: true,
    groupField: 'sigla_norma',
    viewGrid: new Ext.grid.GroupingView({
        forceFit: false
    }),
    onButtonNew :function () {
        var data = this.getSelectedData();
        Phx.vista.AuditoriaNpn.superclass.onButtonNew.call(this);

        //this.Cmp.id_norma.store.baseParams.query = this.maestro.desc_prioridad;
        this.Cmp.id_norma.store.load({params:{p_codigo_parametro:this.maestro.codigo_parametro,start:0,limit:this.tam_pag},
            callback : function (r) {
                if (r.length > 0 ) {
                    this.Cmp.id_norma.setValue(r[0].data.id_norma);
                    this.Cmp.id_norma.modificado = true;
                }
            }, scope : this
        });

        //*** Filtro para seleccionar solo los punto de norma de la norma seleccionada***
        this.Cmp.id_norma.on('select', function(combo, record, index){
            this.Cmp.id_norma.store.baseParams.p_codigo_parametro = this.maestro.codigo_parametro;
            this.Cmp.id_pn.store.baseParams ={par_filtro: 'nor.sigla_norma#nor.nombre_norma',id_norma: record.data.id_norma};
            console.log('this.maestro.id_tnorma',record.data.id_norma);
        },this);
    },
    /*nodoVista:function () {

        var tb = Phx.vista.AuditoriaNpn.superclass.preparaMenu.call(this);
        var data = this.getSelectedData();

        if(this.maestro.estado_wf == 'vob_planificacion'){
            tb.items.get('b-new-' + this.idContenedor).disable();
            tb.items.get('b-edit-' + this.idContenedor).disable();
            tb.items.get('b-del-' + this.idContenedor).disable();
            tb.items.get('b-save-' + this.idContenedor).disable();
        }
    },*/
    preparaMenu: function(n){

        var tb = Phx.vista.AuditoriaNpn.superclass.preparaMenu.call(this);
        var data = this.getSelectedData();

        if(this.maestro.estado_wf == 'plani_aprob' || this.maestro.estado_wf == 'vob_planificacion'){
            tb.items.get('b-new-' + this.idContenedor).disable();
            //tb.items.get('b-new-' + this.idContenedor).hide();
            tb.items.get('b-edit-' + this.idContenedor).disable();
            tb.items.get('b-del-' + this.idContenedor).disable();
            tb.items.get('b-save-' + this.idContenedor).disable();
        }
        else{
            tb.items.get('b-edit-' + this.idContenedor).enable();
            tb.items.get('b-del-' + this.idContenedor).enable();
        }
        return tb;
    },
    liberaMenu: function(n){

        var tb = Phx.vista.AuditoriaNpn.superclass.preparaMenu.call(this);
        var data = this.getSelectedData();

        if(this.maestro.estado_wf == 'plani_aprob' || this.maestro.estado_wf == 'vob_planificacion'){
            tb.items.get('b-new-' + this.idContenedor).disable();
            tb.items.get('b-edit-' + this.idContenedor).disable();
            tb.items.get('b-del-' + this.idContenedor).disable();
            tb.items.get('b-save-' + this.idContenedor).disable();
        }
        else{
            tb.items.get('b-edit-' + this.idContenedor).disable();
            tb.items.get('b-del-' + this.idContenedor).disable();
        }
        return tb;
    },
    /*onButtonNew :function () {
        Phx.vista.AuditoriaNpn.superclass.onButtonNew.call(this);
        this.Cmp.id_norma.setValue(this.maestro.id_n);
        /// filtros combo
        this.Cmp.id_norma.on('select', function(combo, record, index){
            this.Cmp.id_pn.store.baseParams ={par_filtro: 'pnorm.nombre_pn#pnorm.codigo_pn',id_norma : record.data.id_norma};
            this.Cmp.id_pn.reset();
            this.store.removeAll();
            this.Cmp.id_pn.modificado = true;
        },this);
        this.Cmp.id_pn.on('select', function(combo, record, index){
            this.Cmp.nombre_pn.reset();
            this.Cmp.nombre_pn.setValue(record.data.nombre_pn);
        },this);
    },*/
	}
)
</script>
		
		