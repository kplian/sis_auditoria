<?php
/**
*@package pXP
*@file gen-Actividad.php
*@author  (max.camacho)
*@date 05-08-2019 13:33:31
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Actividad=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Actividad.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
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
					name: 'id_actividad'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'actividad',
				fieldLabel: 'Actividad',
				allowBlank: false,
				anchor: '80%',
                //height: 50,
				gwidth: 100,
				maxLength:500
			},
				type:'TextField',
				filters:{pfiltro:'atv.actividad',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		/*{
			config:{
				name: 'fecha_ainicio',
				fieldLabel: 'Fecha Inicio',
				allowBlank: false,
				anchor: '45%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'atv.fecha_ainicio',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_afin',
				fieldLabel: 'Fecha Fin',
				allowBlank: false,
				anchor: '45%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'atv.fecha_afin',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
        {
            config:{
                name: 'hora_ainicio',
                fieldLabel: 'Hora Inicio',
                allowBlank: false,
                anchor: '45%',
                // minValue: '12:00 AM',
                // maxValue: '11:59 PM',
                format: 'H:i',
                increment: 1,
                //allowBlank: false,
                width: 250,
            },
            type:'TimeField',
            filters:{pfiltro:'act.hora_ainicio',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'hora_afin',
                fieldLabel: 'Hora Fin',
                allowBlank: false,
                anchor: '45%',
                // minValue: '12:00 AM',
                // maxValue: '11:59 PM',
                format: 'H:i',
                increment: 1,
                //allowBlank: false,
                width: 250,
            },
            type:'TimeField',
            filters:{pfiltro:'act.hora_afin',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },*/
        {
            config:{
                name: 'codigo_actividad',
                fieldLabel: 'Codigo Activ.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:50
            },
            type:'TextField',
            filters:{pfiltro:'atv.codigo_actividad',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
		{
			config:{
				name: 'obs_actividad',
				fieldLabel: 'Obs. Actividad',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:1000
			},
				type:'TextArea',
				filters:{pfiltro:'atv.obs_actividad',type:'string'},
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
				filters:{pfiltro:'atv.estado_reg',type:'string'},
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
				filters:{pfiltro:'atv.fecha_reg',type:'date'},
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
				filters:{pfiltro:'atv.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'atv.usuario_ai',type:'string'},
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
				filters:{pfiltro:'atv.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Actividad',
	ActSave:'../../sis_auditoria/control/Actividad/insertarActividad',
	ActDel:'../../sis_auditoria/control/Actividad/eliminarActividad',
	ActList:'../../sis_auditoria/control/Actividad/listarActividad',
	id_store:'id_actividad',
	fields: [
		{name:'id_actividad', type: 'numeric'},
		//{name:'id_aom', type: 'numeric'},
		{name:'actividad', type: 'string'},
		/*{name:'fecha_ainicio', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_afin', type: 'date',dateFormat:'Y-m-d'},
		{name:'hora_ainicio', type: 'string'},
		{name:'hora_afin', type: 'string'},*/
		{name:'codigo_actividad', type: 'string'},
		{name:'obs_actividad', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},

	],
	sortInfo:{
		field: 'id_actividad',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    /*east:{
        url:'../../../sis_auditoria/vista/actividad_equipo_responsable/ActividadEquipoResponsable.php',
        title:'Participantes en la Actividad',
        //height:'50%',
        width: '40%',
        cls:'ActividadEquipoResponsable'
    },*/
    /*onButtonNew:function () {
        Phx.vista.Actividad.superclass.onButtonNew.call(this);
        this.eventoHideFields();
    },
    eventoHideFields:function () {
        this.ocultarComponente(this.Cmp.fecha_ainicio);
    }*/
    /*onReloadPage:function(m){
        this.maestro=m;
        this.store.baseParams = {id_aom: this.maestro.id_aom};
        //Ext.apply(this.Cmp.id_centro_costo.store.baseParams,{id_gestion: this.maestro.id_gestion});
        this.load({params:{start:0, limit:50}});
        this.Cmp.id_aom.disable(true);
    },
    loadValoresIniciales: function () {
        //this.Cmp.id_aom.setValue(this.maestro.id_aom);
        //Phx.vista.AuditoriaNorma.superclass.loadValoresIniciales.call(this);
        Phx.vista.Actividad.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);
    },
    preparaMenu: function(n){

        var tb = Phx.vista.Actividad.superclass.preparaMenu.call(this);
        var data = this.getSelectedData();

        if(this.maestro.estado_wf == 'plani_aprob' || this.maestro.estado_wf == 'vob_planificacion'){
            tb.items.get('b-new-' + this.idContenedor).disable();
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

        var tb = Phx.vista.Actividad.superclass.preparaMenu.call(this);
        var data = this.getSelectedData();

        if(this.maestro.estado_wf == 'plani_aprob' || this.maestro.estado_wf == 'vob_planificacion'){
            tb.items.get('b-new-' + this.idContenedor).disable();
            tb.items.get('b-edit-' + this.idContenedor).disable();
            tb.items.get('b-del-' + this.idContenedor).disable();
            tb.items.get('b-save-' + this.idContenedor).disable();
        }
        else{
            //tb.items.get('b-new-' + this.idContenedor).disable();
            //tb.items.get('b-save-' + this.idContenedor).disable();
            tb.items.get('b-edit-' + this.idContenedor).disable();
            tb.items.get('b-del-' + this.idContenedor).disable();
        }
        return tb;
    },*/
	}
)
</script>
		
		