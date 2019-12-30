<?php
/**
*@package pXP
*@file gen-Destinatario.php
*@author  (max.camacho)
*@date 10-09-2019 23:09:14
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Destinatario=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
        this.maestro=config.maestro;
        //this.
    	//llama al constructor de la clase padre
		Phx.vista.Destinatario.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        }
        else {
            this.bloquearMenus();
        }
        this.validarFuncionarioResponsable();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_destinatario_aom'
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
                fieldLabel: 'Auditoria',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarAuditoriaOportunidadMejora',
                    id: 'id_aom',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_aom1',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_aom', 'nombre_aom1'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'movtip.nombre#movtip.codigo'}
                }),
                valueField: 'id_aom',
                displayField: 'nombre_aom1',
                gdisplayField: 'nombre_aom1',
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
                    return String.format('{0}', record.data['nombre_aom1']);
                }
            },
            type: 'ComboBox',
            id_grupo: 2,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },*/
        {
            config: {
                name: 'id_parametro',
                fieldLabel: 'Tipo Destinatario',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    //url: '../../sis_auditoria/control/Parametro/listarParametro',
                    url: '../../sis_auditoria/control/Parametro/listarParametro',
                    id: 'id_parametro',
                    root: 'datos',
                    sortInfo: {
                        field: 'valor_parametro',
                        direction: 'DESC'
                    },
                    totalProperty: 'total',
                    fields: ['id_parametro', 'tipo_parametro', 'valor_parametro','codigo_parametro'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'prm.id_parametro'}
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
                anchor: '100%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['valor_parametro']);
                }
            },
            type: 'ComboBox',
            id_grupo: 2,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
		{
			config: {
				name: 'id_funcionario',
				fieldLabel: 'Funcionario',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListAuditores',
					id: 'id_funcionario',
					root: 'datos',
					sortInfo: {
						field: 'desc_funcionario1',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_funcionario', 'desc_funcionario1'],
					remoteSort: true,
					baseParams: {par_filtro: 'vfc.desc_funcionario1'}
				}),
				valueField: 'id_funcionario',
				displayField: 'desc_funcionario1',
				gdisplayField: 'desc_funcionario1',
				hiddenName: 'id_funcionario',
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
					return String.format('{0}', record.data['desc_funcionario1']);
				}
			},
			type: 'ComboBox',
			//type: 'AwesomeCombo',
			id_grupo: 1,
			filters: {pfiltro: 'movtip.nombre',type: 'string'},
			grid: true,
			form: true
		},
        {
            config:{
                name: 'exp_tec_externo',
                fieldLabel: 'Exp. Tec. Externo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:150
            },
            type:'TextField',
            filters:{pfiltro:'dest.obs_destinatario',type:'string'},
            id_grupo:3,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'obs_destinatario',
                fieldLabel: 'Observacion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:30
            },
            type:'TextField',
            filters:{pfiltro:'dest.obs_destinatario',type:'string'},
            id_grupo:3,
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
				filters:{pfiltro:'dest.estado_reg',type:'string'},
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
				filters:{pfiltro:'dest.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'dest.fecha_reg',type:'date'},
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
				filters:{pfiltro:'dest.usuario_ai',type:'string'},
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
				filters:{pfiltro:'dest.fecha_mod',type:'date'},
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
	title:'Destinatario',
	ActSave:'../../sis_auditoria/control/Destinatario/insertarDestinatario',
	ActDel:'../../sis_auditoria/control/Destinatario/eliminarDestinatario',
	ActList:'../../sis_auditoria/control/Destinatario/listarDestinatario',
	id_store:'id_destinatario_aom',
	fields: [
		{name:'id_destinatario_aom', type: 'numeric'},
		{name:'id_parametro', type: 'numeric'},
		{name:'id_aom', type: 'numeric'},
        {name:'id_funcionario', type: 'numeric'},
        {name:'exp_tec_externo', type: 'string'},
        {name:'obs_destinatario', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'valor_parametro', type: 'string'},
		{name:'codigo_parametro', type: 'string'},
		{name:'desc_funcionario1', type: 'string'},

	],
	sortInfo:{
		field: 'id_destinatario_aom',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    onReloadPage:function(m){
        this.maestro=m;
        this.store.baseParams = {id_aom: this.maestro.id_aom};
        //Ext.apply(this.Cmp.id_centro_costo.store.baseParams,{id_gestion: this.maestro.id_gestion});
        this.load({params:{start:0, limit:50}});
        this.Cmp.id_aom.disable(true);
    },
    loadValoresIniciales: function () {
        Phx.vista.Destinatario.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);

    },
    onButtonNew:function(){
        this.formTeamResponsableFI();

        //this.ocultarComponente(this.Cmp.v_participacion);
        Phx.vista.Destinatario.superclass.onButtonNew.call(this);

        var data = this.getSelectedData();
        /*console.log('data',data);
        console.log('maestritoooooooooo',this.maestro);*/

        if(this.maestro.codigo_tpo_aom == 'AI'){
            this.Cmp.id_parametro.store.baseParams ={par_filtro:'vfc.desc_funcionario1',tipo_parametro_ed:'TIPO_PARTICIPACION',p_codigo_tipo_aom_ed: this.maestro.codigo_tpo_aom,p_codigo_parametro_ed:"''MEQ'',''ETE'',''OTHERS'',''INV''"};
            this.Cmp.id_parametro.lastQuery = null;
            //this.Cmp.id_equipo_responsable.lastQuery = null;
        }
        if(this.maestro.codigo_tpo_aom == 'OM'){
            this.Cmp.id_parametro.store.baseParams ={par_filtro:'vfc.desc_funcionario1',tipo_parametro_ed:'TIPO_PARTICIPACION',p_codigo_tipo_aom_ed: this.maestro.codigo_tpo_aom,p_codigo_parametro_ed:"''MEQ'',''OTHERS'',''INV''"};
            this.Cmp.id_parametro.lastQuery = null;
            //this.Cmp.id_equipo_responsable.lastQuery = null;
        }

        this.Cmp.id_parametro.on('select', function(combo, record, index){
            console.log("Combo->",combo+"record->"+record+"index->"+index);
            console.log("this maestro->",this.maestro.id_uo);

            if(this.maestro.codigo_tpo_aom == 'AI'){
                this.Cmp.id_funcionario.store.baseParams.p_codigo_parametro = record.data.codigo_parametro;
                this.Cmp.id_funcionario.store.baseParams.p_id_uo_i = this.maestro.id_uo;

                this.Cmp.id_funcionario.store.load({params:{start:0,limit:this.tam_pag},
                    callback : function (r) {
                        if (r.length > 0 ) {
                            this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                            this.Cmp.id_funcionario.modificado = true;
                        }
                    }, scope : this
                });

                console.log('codigo parametro',record.data.codigo_parametro);
            }
            if(this.maestro.codigo_tpo_aom == 'OM'){

                if(record.data.codigo_parametro == 'ETI' || record.data.codigo_parametro == 'RESP'){
                    this.formTeamResponsableFI();
                    this.Cmp.id_funcionario.store.baseParams.p_codigo_parametro = record.data.codigo_parametro;
                    this.Cmp.id_funcionario.store.baseParams.p_id_uo_i = this.maestro.id_uo;

                    this.Cmp.id_funcionario.store.load({params:{start:0,limit:this.tam_pag},
                        callback : function (r) {
                            if (r.length > 0 ) {
                                this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                                this.Cmp.id_funcionario.modificado = true;
                            }
                        }, scope : this
                    });
                }
                if(record.data.codigo_parametro == 'ETE'){
                    this.formTeamResponsableFE();
                    //this.Cmp.id_funcionario.store.baseParams.p_codigo_parametro = record.data.codigo_parametro;
                    //this.Cmp.id_funcionario.store.baseParams.p_id_uo_i = this.maestro.id_uo;

                    /*this.Cmp.id_funcionario.store.load({params:{start:0,limit:this.tam_pag},
                        callback : function (r) {
                            if (r.length > 0 ) {
                                this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                                this.Cmp.id_funcionario.modificado = true;
                            }
                        }, scope : this
                    });*/
                }
            }




        },this);


    },
    onButtonEdit:function(){
        var data = this.getSelectedData();
        Phx.vista.Destinatario.superclass.onButtonEdit.call(this);

        console.log("entro a  Edit-->", data);


        this.Cmp.id_parametro.store.baseParams ={par_filtro:'vfc.desc_funcionario1',tipo_parametro_ed:'TIPO_PARTICIPACION',p_codigo_tpo_aom_ed: this.maestro.codigo_tpo_aom,p_codigo_parametro_ed:'ETE'};
        //this.Cmp.id_equipo_responsable.lastQuery = null;
        if(this.maestro.codigo_tpo_aom == 'OM'){
            if(data.codigo_parametro == 'ETI' || data.codigo_parametro == 'RESP'){
                this.formTeamResponsableFI();
            }
            if(data.codigo_parametro == 'ETE'){
                this.formTeamResponsableFE();
                this.Cmp.id_parametro.disable();
            }
        }

    },
    preparaMenu: function(n){
        var tb = Phx.vista.Destinatario.superclass.preparaMenu.call(this);
        var data = this.getSelectedData();

        if(this.maestro.estado_wf == 'vob_informe'){
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
        var tb = Phx.vista.Destinatario.superclass.preparaMenu.call(this);
        var data = this.getSelectedData();

        if(this.maestro.estado_wf == 'vob_informe'){
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
    getFormTeamAudit: function () {
        var data = this.getSelectedData();
        this.Cmp.id_parametro.on('select',function(combo, record, index){
            //console.log("valor del record:",record.data);
            /*var tpo = this.Cmp.id_parametro.store.baseParams.id_parametro = record.data.id_parametro;
            var id_parametro = this.Cmp.id_parametro.store.baseParams.v_id_parametro = record.data.valor_parametro;*/

            this.Cmp.id_funcionario.reset();
            var codigo_parametro = this.Cmp.id_parametro.store.baseParams.v_codigo_parametro = record.data.codigo_parametro;
            //console.log("Tipo Participacion:",tpo,id_parametro,codigo_parametro);
            if(codigo_parametro=='ETE'){
                this.formTeamResponsableFE();
            }
            else{
                this.formTeamResponsableFI();
            }
        },this);
    },
    formTeamResponsableFI: function () {
        this.mostrarComponente(this.Cmp.id_parametro);
        this.mostrarComponente(this.Cmp.id_funcionario);
        this.mostrarComponente(this.Cmp.obs_destinatario);

        this.ocultarComponente(this.Cmp.exp_tec_externo);
    },
    formTeamResponsableFE: function () {
        this.mostrarComponente(this.Cmp.id_parametro);
        this.mostrarComponente(this.Cmp.exp_tec_externo);
        this.mostrarComponente(this.Cmp.obs_destinatario);

        this.ocultarComponente(this.Cmp.id_funcionario);
    },
    validarFuncionarioResponsable: function () {
        var data = this.getSelectedData();
        this.Cmp.id_parametro.on('select',function (combo,record,index) {
            //alert("Estas en parametros....");
            console.log('combo',combo, 'record',record, 'index',index);
            console.log('valor parametro',record.data.valor_parametro,record.data.codigo_parametro,);
            console.log('valor *******',this.maestro.id_aom);
            var codigo_parametro = '';
            if(record.data.codigo_parametro == "RESP"){
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/Destinatario/listarDestinatario',
                    params:{start:0, limit:50, v_id_aom: this.maestro.id_aom, v_codigo_parametro: record.data.codigo_parametro},
                    dataType:"JSON",
                    success:function (resp) {
                        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                        console.log("valor de respuesta:",reg);
                        if(reg.datos.length>0){
                            //alert("Ya existe un Responsable, no es permitido tener mas...!!!");
                            Ext.Msg.alert("status","Ya existe un Responsable, no es permitido tener mas...!!!");

                            this.Cmp.id_funcionario.disable(true);
                            this.Cmp.obs_destinatario.disable(true);
                            this.Cmp.id_parametro.setValue(null);
                        }
                    },
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
            }
            else{
                this.Cmp.id_funcionario.enable(true);
                this.Cmp.obs_destinatario.enable(true);
            }

        },this);
    },

	}
)
</script>
		
		