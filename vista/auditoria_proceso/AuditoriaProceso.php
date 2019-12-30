<?php
/**
*@package pXP
*@file gen-AuditoriaProceso.php
*@author  (max.camacho)
*@date 25-07-2019 15:51:56
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AuditoriaProceso=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.AuditoriaProceso.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
        //this.bloquearMenu();
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        }
        else {
            this.bloquearMenus();
        }
        //this.validarProcesoSeleccionado();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_aproceso'
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
                fieldLabel: '#Auditoria',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                //disabled: true,
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarAuditoriaOportunidadMejora',
                    id: 'id_aom',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_aom',
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
                name: 'id_proceso',
                fieldLabel: 'Proceso',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/Proceso/listarProceso',
                    id: 'id_proceso',
                    root: 'datos',
                    sortInfo: {
                        field: 'proceso',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_proceso', 'proceso'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'pcs.proceso'}
                }),
                valueField: 'id_proceso',
                displayField: 'proceso',
                gdisplayField: 'proceso',
                hiddenName: 'id_proceso',
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
                    return String.format('{0}', record.data['proceso']);
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
                name: 'ap_valoracion',
                fieldLabel: 'ap_valoracion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:20
            },
            type:'TextField',
            filters:{pfiltro:'aupc.ap_valoracion',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
        {
            config:{
                name: 'obs_pcs',
                fieldLabel: 'obs_pcs',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:-5
            },
            type:'TextField',
            filters:{pfiltro:'aupc.obs_pcs',type:'string'},
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
				filters:{pfiltro:'aupc.estado_reg',type:'string'},
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
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'aupc.fecha_reg',type:'date'},
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
				filters:{pfiltro:'aupc.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'aupc.usuario_ai',type:'string'},
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
				filters:{pfiltro:'aupc.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Auditoria Proceso',
	ActSave:'../../sis_auditoria/control/AuditoriaProceso/insertarAuditoriaProceso',
	ActDel:'../../sis_auditoria/control/AuditoriaProceso/eliminarAuditoriaProceso',
	ActList:'../../sis_auditoria/control/AuditoriaProceso/listarAuditoriaProceso',
	id_store:'id_aproceso',
	fields: [
		{name:'id_aproceso', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_aom', type: 'numeric'},
		{name:'id_proceso', type: 'numeric'},
		{name:'ap_valoracion', type: 'string'},
		{name:'obs_pcs', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'nombre_aom1', type: 'string'},
		{name:'proceso', type: 'string'},

	],
	sortInfo:{
		field: 'id_aproceso',
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
        Phx.vista.AuditoriaProceso.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);
    },
    preparaMenu: function(n){

        var tb = Phx.vista.AuditoriaProceso.superclass.preparaMenu.call(this);
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

        var tb = Phx.vista.AuditoriaProceso.superclass.preparaMenu.call(this);
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
    /*onButtonEdit:function(){
        Phx.vista.AuditoriaProceso.superclass.onButtonEdit.call(this);
        this.eventAuditoria();
    },
    eventAuditoria: function () {
        // Para Ocultar un campo del formulario
        //this.ocultarComponente(this.Cmp.id_aom);
        // Para poner un campo no editable
        this.Cmp.id_aom.disable(true);
    }*/
    /*validarProcesoSeleccionado: function () {

        var data = this.getSelectedData();

        this.Cmp.id_proceso.on('select',function (combo,record,index) {
            //alert("Estas en parametros....");
            console.log('combo',combo, 'record',record, 'index',index);
            console.log('valor id_proceso',record.data.id_proceso);
            console.log('valor id_aom',this.maestro.id_aom);
            var codigo_parametro = '';
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/AuditoriaProceso/esSelectaProceso',
                params:{start:0, limit:50, p_id_aom: this.maestro.id_aom, p_id_proceso: record.data.id_proceso},
                dataType:"JSON",
                success:function (resp) {
                    var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    console.log("valor de respuesta:",reg);
                    if(reg.datos.length>0){
                        //alert("Ya existe un Responsable, no es permitido tener mas...!!!");
                        Ext.Msg.alert("status","Ya existe es proceso, no es permitido tener mas...!!!");

                        this.Cmp.id_proceso.setValue(null);
                    }
                },
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });


        },this);
    }*/
	}
)
</script>
		
		