<?php
/**
*@package pXP
*@file gen-AomRiesgoOportunidad.php
*@author  (max.camacho)
*@date 16-12-2019 20:00:49
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019				 (max.camacho)				CREACION	

*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AomRiesgoOportunidad=Ext.extend(Phx.gridInterfaz,{

    v_probabilidad:'',
    v_impacto:'',
    v_criticidad:'',

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.AomRiesgoOportunidad.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
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
					name: 'id_aom_ro'
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
        /*{
            config: {
                name: 'id_aom',
                fieldLabel: 'id_aom',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_/control/Clase/Metodo',
                    id: 'id_',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_', 'nombre', 'codigo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'movtip.nombre#movtip.codigo'}
                }),
                valueField: 'id_',
                displayField: 'nombre',
                gdisplayField: 'desc_',
                hiddenName: 'id_aom',
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
                    return String.format('{0}', record.data['desc_']);
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
                name: 'id_tipo_ro',
                fieldLabel: 'Tipo RO',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/TipoRo/listarTipoRo',
                    id: 'id_tipo_ro',
                    root: 'datos',
                    sortInfo: {
                        field: 'desc_tipo_ro',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_tipo_ro', 'tipo_ro','desc_tipo_ro'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'tro.desc_tipo_ro'/*,p_tipo_ro:"''RIESGO_PLANIFICACION'',''OPORT_PLANIFICACION''"*/}
                }),
                valueField: 'id_tipo_ro',
                displayField: 'desc_tipo_ro',
                gdisplayField: 'desc_tipo_ro',
                hiddenName: 'id_tipo_ro',
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
                    return String.format('{0}', record.data['desc_tipo_ro']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'tro.desc_tipo_ro',type: 'string'},
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_ro',
                fieldLabel: 'Riesgo Oportunidad',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/RiesgoOportunidad/listarRiesgoOportunidad',
                    id: 'id_ro',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_ro',
                        direction: 'DESC'
                    },
                    totalProperty: 'total',
                    fields: ['id_ro', 'nombre_ro','codigo_ro'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'rop.nombre_ro'}
                }),
                valueField: 'id_ro',
                displayField: 'nombre_ro',
                gdisplayField: 'nombre_ro',
                hiddenName: 'id_ro',
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
                    return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', record.data['nombre_ro']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'rop.nombre_ro',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'otro_nombre_ro',
                fieldLabel: 'Otro Riesgo Oportunidad',
                allowBlank: false,
                anchor: '100%',
                gwidth: 100,
                maxLength:300,
                renderer : function(value, p, record) {
                    return String.format('<div style="font-color:blue" class="gridmultiline">{0}</div>', record.data['otro_nombre_ro']);
                }
            },
            type:'TextField',
            filters:{pfiltro:'auro.otro_nombre_ro',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config: {
                name: 'id_probabilidad',
                fieldLabel: 'Probabilidad',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/Probabilidad/listarProbabilidad',
                    id: 'id_probabilidad',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_prob',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_probabilidad', 'nombre_prob'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'prob.nombre_prob'}
                }),
                valueField: 'id_probabilidad',
                displayField: 'nombre_prob',
                gdisplayField: 'nombre_prob',
                hiddenName: 'id_probabilidad',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '50%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['nombre_prob']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'prob.nombre_prob',type: 'string'},
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_impacto',
                fieldLabel: 'Impacto',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/Impacto/listarImpacto',
                    id: 'id_impacto',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_imp',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_impacto', 'nombre_imp'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'imp.nombre_imp'}
                }),
                valueField: 'id_impacto',
                displayField: 'nombre_imp',
                gdisplayField: 'nombre_imp',
                hiddenName: 'id_impacto',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '50%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['nombre_imp']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'imp.nombre_imp',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'criticidad',
                fieldLabel: 'Criticidad',
                allowBlank: false,
                anchor: '50%',
                gwidth: 100,
                maxLength:20
            },
            type:'TextField',
            filters:{pfiltro:'auro.criticidad',type:'string'},
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
				filters:{pfiltro:'auro.estado_reg',type:'string'},
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
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'auro.usuario_ai',type:'string'},
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
				filters:{pfiltro:'auro.fecha_reg',type:'date'},
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
				filters:{pfiltro:'auro.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'auro.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Auditoria Riesgo Oportunidad',
	ActSave:'../../sis_auditoria/control/AomRiesgoOportunidad/insertarAomRiesgoOportunidad',
	ActDel:'../../sis_auditoria/control/AomRiesgoOportunidad/eliminarAomRiesgoOportunidad',
	ActList:'../../sis_auditoria/control/AomRiesgoOportunidad/listarAomRiesgoOportunidad',
	id_store:'id_aom_ro',
	fields: [
		{name:'id_aom_ro', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_impacto', type: 'numeric'},
		{name:'id_probabilidad', type: 'numeric'},
		{name:'id_tipo_ro', type: 'numeric'},
		{name:'id_ro', type: 'numeric'},
        {name:'otro_nombre_ro', type: 'string'},
		{name:'id_aom', type: 'numeric'},
		{name:'criticidad', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'nombre_ro', type: 'string'},
		{name:'desc_tipo_ro', type: 'string'},
		{name:'nombre_prob', type: 'string'},
		{name:'nombre_imp', type: 'string'},

	],
	sortInfo:{
		field: 'id_aom_ro',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    east:{
        url:'../../../sis_auditoria/vista/accion_ro/AccionRo.php',
        title:'Acciones',
        //height:'50%',
        width: '40%',
        cls:'AccionRo'
    },
    tipoStore: 'GroupingStore',//GroupingStore o JsonStore #
    remoteGroup: true,
    groupField: 'desc_tipo_ro',
    viewGrid: new Ext.grid.GroupingView({
        forceFit: false
    }),
    onReloadPage:function(m){
        this.maestro=m;
        this.store.baseParams = {id_aom: this.maestro.id_aom};
        //Ext.apply(this.Cmp.id_centro_costo.store.baseParams,{id_gestion: this.maestro.id_gestion});
        this.load({params:{start:0, limit:50}});
        this.Cmp.id_aom.disable(true);
    },
    loadValoresIniciales: function () {
        //this.Cmp.id_aom.setValue(this.maestro.id_aom);
        //Phx.vista.AuditoriaNorma.superclass.loadValoresIniciales.call(this);
        Phx.vista.AomRiesgoOportunidad.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);
        console.log("vavvvvvvvvvvvvvvvvv",this.getCriticidad('Menor','Bajo'));
    },
    onButtonNew:function () {
        var data = this.getSelectedData();
        var self = this;
        this.Cmp.id_tipo_ro.enable();
        self.limpiar();
        this.ocultarComponente(this.Cmp.otro_nombre_ro);
        Phx.vista.AomRiesgoOportunidad.superclass.onButtonNew.call(this);
        this.Cmp.id_tipo_ro.store.load({params:{p_tipo_ro:"''RIESGO_PLANIFICACION'',''OPORT_PLANIFICACION''",start:0,limit:this.tam_pag},
            callback : function (r) {
                if (r.length > 0 ) {
                    this.Cmp.id_tipo_ro.setValue(r[0].data.id_tipo_ro);
                    this.Cmp.id_tipo_ro.modificado = true;

                }
            }, scope : this
        });
        this.Cmp.id_tipo_ro.on('expand', function(combo){
            this.Cmp.id_tipo_ro.store.baseParams.p_tipo_ro = "''RIESGO_PLANIFICACION'',''OPORT_PLANIFICACION''";
            //this.Cmp.id_ro.store.baseParams = {par_filtro: 'riop.id_tipo_ro',p_id_tipo_ro: record.data.id_tipo_ro};
            this.Cmp.id_tipo_ro.modificado = true;
        },this);

        //*** Filtro para seleccionar solo los punto de norma de la norma seleccionada***
        this.Cmp.id_tipo_ro.on('select', function(combo, record, index){
            this.Cmp.id_tipo_ro.store.baseParams.p_tipo_ro = "''RIESGO_PLANIFICACION'',''OPORT_PLANIFICACION''";
            this.Cmp.id_ro.store.baseParams = {par_filtro: 'riop.id_tipo_ro',p_id_tipo_ro: record.data.id_tipo_ro};
            this.Cmp.id_ro.modificado = true;

            this.Cmp.id_ro.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                        this.Cmp.id_ro.setValue(r[0].data.id_ro);
                        this.Cmp.id_ro.modificado = true;
                    }
                }, scope : this
            });

            //this.Cmp.id_ro.lastQuery = null;
            console.log('valor id_ro-->',record.data.id_tipo_ro);
        },this);
        this.Cmp.id_ro.on('select', function(combo, record, index){
            console.log('valor id_ro-->',record.data.id_ro+",codigo->"+record.data.codigo_ro);
            if(record.data.codigo_ro == 'OTHER_RPROGRAMM' || record.data.codigo_ro == 'OTHER_OPROGRAMM' || record.data.codigo_ro == 'OTHER_RPLANNIN' || record.data.codigo_ro == 'OTHER_OPLANNIN'){
                this.mostrarComponente(this.Cmp.otro_nombre_ro);
            }
            else{
                this.ocultarComponente(this.Cmp.otro_nombre_ro);
                this.Cmp.otro_nombre_ro.reset();
            }

        },this);
        // valores de Probabilidad e Impacto
        this.Cmp.id_probabilidad.on('select',function (c, r, i) {
            self.v_probabilidad = r.data.nombre_prob;
            console.log("Criticidad -->",self.v_probabilidad);
            console.log("Criticidad -->",self.getCriticidad(self.v_probabilidad,self.v_impacto));

            if(self.getCriticidad(self.v_probabilidad,self.v_impacto)!=''){
                self.Cmp.criticidad.setValue(self.getCriticidad(self.v_probabilidad,self.v_impacto));
            }

        });
        this.Cmp.id_impacto.on('select',function (c, r, i) {
            self.v_impacto = r.data.nombre_imp;
            console.log("Impacto -->",self.v_impacto);
            console.log("Criticidad -->",self.getCriticidad(self.v_probabilidad,self.v_impacto));
            if(self.getCriticidad(self.v_probabilidad,self.v_impacto)!='') {
                self.Cmp.criticidad.setValue(self.getCriticidad(self.v_probabilidad, self.v_impacto));
            }
        });

    },
    onButtonEdit:function () {
        var data = this.getSelectedData();
        var self = this;

        this.Cmp.id_tipo_ro.disable();

        if(data.otro_nombre_ro != ''){
            this.mostrarComponente(this.Cmp.otro_nombre_ro);
        }
        else{
            this.ocultarComponente(this.Cmp.otro_nombre_ro);
        }

        Phx.vista.AomRiesgoOportunidad.superclass.onButtonEdit.call(this);

        //this.Cmp.id_tipo_ro.store.baseParams.p_tipo_ro = "''RIESGO_PLANIFICACION'',''OPORT_PLANIFICACION''";
        //this.Cmp.id_ro.store.baseParams = {par_filtro: 'riop.id_tipo_ro',pe_tipo_ro:"''RIESGO_PLANIFICACION'',''OPORT_PLANIFICACION''"};
        this.Cmp.id_ro.store.baseParams = {par_filtro:'riop.id_tipo_ro',p_id_tipo_ro: data.id_tipo_ro};
        this.Cmp.id_ro.modificado = true;

        this.Cmp.id_ro.on('select', function(combo, record, index){
            console.log('valor id_rossssssssss-->',record.data.id_ro+",codigo->"+record.data.codigo_ro);

            //self.Cmp.id_tipo_ro.store.baseParams.pe_tipo_ro = "''RIESGO_PLANIFICACION'',''OPORT_PLANIFICACION''";
            //self.Cmp.id_tipo_ro.modificado = true;

            //this.Cmp.id_ro.store.baseParams = {par_filtro: 'riop.id_tipo_ro',pe_tipo_ro:"''RIESGO_PLANIFICACION'',''OPORT_PLANIFICACION''"};
            //this.Cmp.id_tipo_ro.modificado = true;

            if(record.data.codigo_ro == 'OTHER_RPROGRAMM' || record.data.codigo_ro == 'OTHER_OPROGRAMM' || record.data.codigo_ro == 'OTHER_RPLANNIN' || record.data.codigo_ro == 'OTHER_OPLANNIN'){
                self.mostrarComponente(self.Cmp.otro_nombre_ro);
            }
            else{
                self.ocultarComponente(self.Cmp.otro_nombre_ro);
                self.Cmp.otro_nombre_ro.reset();
            }

        },this);

        // valores de Probabilidad e Impacto
        this.Cmp.id_probabilidad.on('select',function (c, r, i) {
            self.v_probabilidad = r.data.nombre_prob;
            console.log("Criticidad -->",self.v_probabilidad);
            console.log("Criticidad -->",self.getCriticidad(self.v_probabilidad,self.v_impacto));

            if(self.getCriticidad(self.v_probabilidad,self.v_impacto)!=''){
                self.Cmp.criticidad.setValue(self.getCriticidad(self.v_probabilidad,self.v_impacto));
            }

        });
        this.Cmp.id_impacto.on('select',function (c, r, i) {
            self.v_impacto = r.data.nombre_imp;
            console.log("Impacto -->",self.v_impacto);
            console.log("Criticidad -->",self.getCriticidad(self.v_probabilidad,self.v_impacto));
            if(self.getCriticidad(self.v_probabilidad,self.v_impacto)!='') {
                self.Cmp.criticidad.setValue(self.getCriticidad(self.v_probabilidad, self.v_impacto));
            }
        });

    },
    getCriticidad:function (prob,imp) {

        // CRITICIDAD BAJA

        if(prob != '' && imp !=''){

            if(prob == 'Menor' && imp == 'Bajo' ){
                this.v_criticidad = 'CRITICIDAD BAJA';
            }
            if(prob == 'Menor' && imp == 'Medio' ){
                this.v_criticidad = 'CRITICIDAD BAJA';
            }
            if(prob == 'Media' && imp == 'Bajo' ){
                this.v_criticidad = 'CRITICIDAD BAJA';
            }
            // CRITICIDAD MEDIA
            if(prob == 'Mayor' && imp == 'Bajo' ){
                this.v_criticidad = 'CRITICIDAD MEDIA';
            }
            if(prob == 'Media' && imp == 'Medio' ){
                this.v_criticidad = 'CRITICIDAD MEDIA';
            }
            if(prob == 'Menor' && imp == 'Alto' ){
                this.v_criticidad = 'CRITICIDAD MEDIA';
            }
            // CRITICIDAD ALTA
            if(prob == 'Media' && imp == 'Alto' ){
                this.v_criticidad = 'CRITICIDAD ALTA';
            }
            if(prob == 'Mayor' && imp === 'Medio' ){
                this.v_criticidad = 'CRITICIDAD ALTA';
            }
            if(prob == 'Mayor' && imp == 'Alto' ){
                this.v_criticidad = 'CRITICIDAD ALTA';
            }

        }
        else{
            this.v_criticidad = '';
        }

        return this.v_criticidad;
    },
    limpiar: function () {
        this.v_probabilidad = '';
        this.v_impacto = '';
    }
	}
)
</script>
		
		