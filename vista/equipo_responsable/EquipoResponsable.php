<?php
/**
*@package pXP
*@file gen-EquipoResponsable.php
*@author  (max.camacho)
*@date 02-08-2019 14:03:25
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.EquipoResponsable=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.EquipoResponsable.superclass.constructor.call(this,config);
		this.init();
        //this.load({params:{start:0, limit:this.tam_pag}})
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        }
        else {
            this.bloquearMenus();
        }
		//this.load({params:{start:0, limit:this.tam_pag}})
        
        this.validarFuncionarioResponsable();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_equipo_responsable'
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
                name: 'field_codigo_parametro'
            },
            type:'Field',
            form:true
        },
        /*{
            config: {
                name: 'id_aom',
                fieldLabel: '#Auditoria',
                allowBlank: false,
                inputType:'hidden',
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
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },*/
        {
            config: {
                name: 'id_parametro',
                fieldLabel: 'Tipo Auditor',
                allowBlank: false,
                resizable:true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    //url: '../../sis_auditoria/control/Parametro/getListParametro2',
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
                    baseParams: {par_filtro: 'prm.id_parametro',tipo_parametro:'TIPO_PARTICIPACION',codigo_parametro:"''ETE'',''RESP'',''OTHERS'',''INV''"}
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
                anchor: '60%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['valor_parametro']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
		{
			config: {
				//name: 'id_responsable',
				name: 'id_funcionario',
				fieldLabel: 'Funcionario',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListAuditores',
					//id: 'id_responsable',
					id: 'id_funcionario',
					root: 'datos',
					sortInfo: {
						field: 'desc_funcionario1',
						direction: 'DESC'
					},
					totalProperty: 'total',
					//fields: ['id_responsable', 'desc_funcionario1'],
					fields: ['id_funcionario', 'desc_funcionario1','id_uo','nombre_unidad'],
					remoteSort: true,
					baseParams: {par_filtro: 'movtip.nombre#movtip.codigo'}
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
				anchor: '80%',
				gwidth: 150,
				minChars: 2,
                tpl:'<tpl for=".">\
		                       <div class="x-combo-list-item"><p><b>UO: </b>{nombre_unidad}</p>\
		                      <p><b>FUN: </b>{desc_funcionario1}</p>\
		                     </div></tpl>',

				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_funcionario1']);
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
                name: 'exp_tec_externo',
                fieldLabel: 'Exp. Tecnico Externo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:50
            },
            type:'TextField',
            //filters:{pfiltro:'eqre.exp_tec_externo',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
		{
			config:{
				name: 'obs_participante',
				fieldLabel: 'Observacion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'eqre.obs_participante',type:'string'},
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
				filters:{pfiltro:'eqre.estado_reg',type:'string'},
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
				filters:{pfiltro:'eqre.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'eqre.usuario_ai',type:'string'},
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
				filters:{pfiltro:'eqre.fecha_reg',type:'date'},
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
				filters:{pfiltro:'eqre.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Equipo Responsable',
	ActSave:'../../sis_auditoria/control/EquipoResponsable/insertarEquipoResponsable',
	ActDel:'../../sis_auditoria/control/EquipoResponsable/eliminarEquipoResponsable',
	ActList:'../../sis_auditoria/control/EquipoResponsable/listarEquipoResponsable',
	id_store:'id_equipo_responsable',
	fields: [
		{name:'id_equipo_responsable', type: 'numeric'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'exp_tec_externo', type: 'string'},
		{name:'id_parametro', type: 'numeric'},
		{name:'obs_participante', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_aom', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'nombre_aom1', type: 'string'},
		{name:'desc_funcionario1', type: 'string'},
		{name:'valor_parametro', type: 'string'},
		{name:'codigo_parametro', type: 'string'},

	],
	sortInfo:{
		field: 'id_equipo_responsable',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    onReloadPage:function(m){
        this.maestro=m;
        this.store.baseParams = {id_aom: this.maestro.id_aom};
        //Ext.apply(this.Cmp.id_centro_costo.store.baseParams,{id_gestion: this.maestro.id_gestion});
        this.load({params:{start:0, limit:50}})
        // Para Ocultar un campo del formulario
        //this.ocultarComponente(this.Cmp.id_aom);
        // Para poner un campo no editable
        this.Cmp.id_aom.disable(true);
    },
    loadValoresIniciales: function () {
        Phx.vista.EquipoResponsable.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);
    },
    preparaMenu: function(n){

        var tb = Phx.vista.EquipoResponsable.superclass.preparaMenu.call(this);
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

        var tb = Phx.vista.EquipoResponsable.superclass.preparaMenu.call(this);
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
    onButtonNew: function () {
        this.formTeamResponsableFI();
        //this.Cmp.id_parametro.store.baseParams ={par_filtro:'vfc.desc_funcionario1',p_codigo_tipo_aom: this.maestro.codigo_tpo_aom};
        //this.Cmp.id_equipo_responsable.lastQuery = null;
        //this.iniciarEventos();

        Phx.vista.EquipoResponsable.superclass.onButtonNew.call(this);

        //*** Filtro para seleccionar solo los punto de norma de la norma seleccionada***
        this.Cmp.id_parametro.on('select', function(combo, record, index){
            console.log("Combo->",combo);
            console.log("record->",record);
            console.log("index->",index);
            console.log("this maestro->",this.maestro.id_uo);


            this.Cmp.id_funcionario.store.baseParams.p_codigo_parametro = record.data.codigo_parametro;
            this.Cmp.id_funcionario.store.baseParams.p_id_uo_i = this.maestro.id_uo;

            this.Cmp.id_funcionario.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                        this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                        //this.Cmp.id_funcionario.modificado = true;
                    }
                }, scope : this
            });

            console.log('this.maestro.id_tnorma',record.data.codigo_parametro);
        },this);

        console.log('dgfdsfgsdfgsdfgttttttttttttttttttttttt',this.Cmp.field_codigo_parametro.getValue());
        console.log('dgfdsfgsdfgsuuuuuuuuuuuuuuuuuuu',this.maestro);
        this.getFormTeamAudit();
    },
    onButtonEdit: function () {
        var data = this.getSelectedData();
        //Phx.vista.EquipoResponsable.superclass.onButtonEdit.call(this);
        console.log("valor data:",data);
        console.log("valor edit:",data.valor_parametro);
        if(data.codigo_parametro == 'RESP'){
            Phx.vista.EquipoResponsable.superclass.onButtonEdit.call(this);
            this.formTeamResponsableFI();
            this.Cmp.id_funcionario.disable(true);
            this.Cmp.obs_participante.disable(true);
            this.Cmp.id_parametro.disable(true);
            Ext.Msg.alert("status","No es posible modificar el resposable...!!!");
        }
        else{
            if(data.exp_tec_externo == "" || data.exp_tec_externo == "null"){
                Phx.vista.EquipoResponsable.superclass.onButtonEdit.call(this);
                this.formTeamResponsableFI();
            }
            else{
                Phx.vista.EquipoResponsable.superclass.onButtonEdit.call(this);
                this.formTeamResponsableFE();
            }
        }

    },
    onButtonDel:function(){
        var data = this.getSelectedData();
        //console.log("valor data:",data);
        //console.log("valor edit:",data.valor_parametro);
        if(data.codigo_parametro != 'RESP'){
            Phx.vista.EquipoResponsable.superclass.onButtonDel.call(this);
        }
        else{
            Ext.Msg.alert("status","No es posible Eliminar el Responsable...!!!");
        }
    },
    getFormTeamAudit: function () {
        //var data = this.getSelectedData();
        this.Cmp.id_parametro.on('select',function(combo, record, index){
            //console.log("valor del record:",record.data);
            /*var tpo = this.Cmp.id_parametro.store.baseParams.id_parametro = record.data.id_parametro;
            var id_parametro = this.Cmp.id_parametro.store.baseParams.v_id_parametro = record.data.valor_parametro;*/
            this.Cmp.id_funcionario.setValue("");
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
        this.ocultarComponente(this.Cmp.obs_participante);
        this.ocultarComponente(this.Cmp.exp_tec_externo);

        this.mostrarComponente(this.Cmp.id_parametro);
        this.mostrarComponente(this.Cmp.id_funcionario);
        this.mostrarComponente(this.Cmp.obs_participante);
    },
    formTeamResponsableFE: function () {

        this.ocultarComponente(this.Cmp.id_funcionario);
        this.ocultarComponente(this.Cmp.obs_participante);

        this.mostrarComponente(this.Cmp.id_parametro);
        this.mostrarComponente(this.Cmp.exp_tec_externo);
        this.mostrarComponente(this.Cmp.obs_participante);
    },
    validarFuncionarioResponsable: function () {

        var data = this.getSelectedData();

        this.Cmp.id_parametro.on('select',function (combo,record,index) {
            //alert("Estas en parametros....");
            console.log('combo',combo, 'record',record, 'index',index);
            console.log('valor parametro',record.data.valor_parametro,record.data.codigo_parametro);
            console.log('valor *******',this.maestro.id_aom);
            var codigo_parametro = '';
            if(record.data.codigo_parametro == "RESP"){
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/EquipoResponsable/listarEquipoResponsable',
                    params:{start:0, limit:50, v_id_aom: this.maestro.id_aom, v_codigo_parametro: record.data.codigo_parametro},
                    dataType:"JSON",
                    success:function (resp) {
                        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                        console.log("valor de respuesta:",reg);
                        if(reg.datos.length>0){
                            //alert("Ya existe un Responsable, no es permitido tener mas...!!!");
                            Ext.Msg.alert("status","Ya existe un Responsable, no es permitido tener mas...!!!");

                            this.Cmp.id_funcionario.disable(true);
                            this.Cmp.obs_participante.disable(true);
                            this.Cmp.id_parametro.setValue(null);
                            this.Cmp.exp_tec_externo.setValue(null);
                        }
                    },
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
            }
            else{
                this.Cmp.id_funcionario.enable(true);
                this.Cmp.obs_participante.enable(true);
            }
        },this);

        /*this.Cmp.id_funcionario.on('select',function (combo,record,index) {
            //alert("Estas en parametros....");
            console.log('combo',combo, 'record',record, 'index',index);
            console.log('valor parametro',record.data.valor_parametro,record.data.codigo_parametro);
            console.log('valor *******',this.maestro.id_aom);
            var codigo_parametro = '';
            if(record.data.codigo_parametro != "RESP"){
                console.log("valor de funcionario:",record.data.id_funcionario)
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/EquipoResponsable/esMiembroDelEquipo',
                    params:{start:0, limit:50, v_id_aom: this.maestro.id_aom, p_id_funcionario: record.data.id_funcionario},
                    dataType:"JSON",
                    success:function (resp) {
                        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                        console.log("valor de respuesta:",reg);
                        if(reg.datos.length>0){
                            //alert("Ya existe un Responsable, no es permitido tener mas...!!!");
                            Ext.Msg.alert("status","Ya es miembre del Equipo Responsable, no es permitido agregar mismo funcionario mas de una ves...!!!");

                            //this.Cmp.id_funcionario.disable(true);
                            this.Cmp.id_funcionario.setValue(null);
                            this.Cmp.obs_participante.disable(true);
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
                this.Cmp.obs_participante.enable(true);
            }
        },this);*/
    },
    /*iniciarEventos: function () {
        this.Cmp.id_equipo_responsable.store.baseParams ={par_filtro:'vfc.desc_funcionario1',pe_id_aom: this.maestro.id_aom,pe_id_actividad:this.maestro.id_actividad,pe_id_equipo_responsable:this.getSelectedData().id_equipo_responsable};
        this.Cmp.id_equipo_responsable.lastQuery = null;
    }*/

	}
)
</script>
		
		