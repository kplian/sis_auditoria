<?php
/**
*@package pXP
*@file gen-Cronograma.php
*@author  (max.camacho)
*@date 12-12-2019 15:50:53
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-12-2019				 (max.camacho)				CREACION	

*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Cronograma=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Cronograma.superclass.constructor.call(this,config);
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
					name: 'id_cronograma'
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
                anchor: '80%',
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
                name: 'id_actividad',
                fieldLabel: 'Actividad',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/Actividad/listarActividad',
                    id: 'id_actividad',
                    root: 'datos',
                    sortInfo: {
                        field: 'actividad',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_actividad', 'actividad','codigo_actividad'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'atv.actividad'}
                }),
                valueField: 'id_actividad',
                displayField: 'actividad',
                gdisplayField: 'actividad',
                hiddenName: 'id_actividad',
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
                    return String.format('{0}', record.data['actividad']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'cronog.actividad',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'nueva_actividad',
                fieldLabel: 'Otra Actividad',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:500
            },
            type:'TextField',
            filters:{pfiltro:'cronog.nueva_actividad',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'fecha_ini_activ',
                fieldLabel: 'Fecha Inicio',
                allowBlank: false,
                anchor: '40%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'cronog.fecha_ini_activ',type:'date'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'fecha_fin_activ',
                fieldLabel: 'Fecha Fin',
                allowBlank: false,
                anchor: '40%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'cronog.fecha_fin_activ',type:'date'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'hora_ini_activ',
                fieldLabel: 'Hora Inicio',
                allowBlank: false,
                anchor: '40%',
                // minValue: '12:00 AM',
                // maxValue: '11:59 PM',
                format: 'H:i',
                increment: 1,
                //allowBlank: false,
                width: 250,
            },
            type:'TimeField',
            filters:{pfiltro:'cronog.hora_ini_activ',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        /*{
            config:{
                name: 'hora_ini_activ',
                fieldLabel: 'hora_ini_activ',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:8
            },
            type:'TextField',
            filters:{pfiltro:'cronog.hora_ini_activ',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },*/
        {
            config:{
                name: 'hora_fin_activ',
                fieldLabel: 'Hora Fin',
                allowBlank: false,
                anchor: '40%',
                // minValue: '12:00 AM',
                // maxValue: '11:59 PM',
                format: 'H:i',
                increment: 1,
                //allowBlank: false,
                width: 250,
            },
            type:'TimeField',
            filters:{pfiltro:'cronog.hora_fin_activ',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        /*{
            config:{
                name: 'hora_fin_activ',
                fieldLabel: 'hora_fin_activ',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:8
            },
            type:'TextField',
            filters:{pfiltro:'cronog.hora_fin_activ',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },*/
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
				filters:{pfiltro:'cronog.obs_actividad',type:'string'},
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
				filters:{pfiltro:'cronog.estado_reg',type:'string'},
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
				filters:{pfiltro:'cronog.fecha_reg',type:'date'},
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
				filters:{pfiltro:'cronog.usuario_ai',type:'string'},
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
				filters:{pfiltro:'cronog.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'cronog.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Cronograma',
	ActSave:'../../sis_auditoria/control/Cronograma/insertarCronograma',
	ActDel:'../../sis_auditoria/control/Cronograma/eliminarCronograma',
	ActList:'../../sis_auditoria/control/Cronograma/listarCronograma',
	id_store:'id_cronograma',
	fields: [
		{name:'id_cronograma', type: 'numeric'},
		{name:'nueva_actividad', type: 'string'},
		{name:'obs_actividad', type: 'string'},
		{name:'estado_reg', type: 'string'},
		//{name:'hora_ini_activ', type: 'string'},
		{name:'hora_ini_activ', type: 'date',dateFormat:'H:i:s'},
		{name:'fecha_ini_activ', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin_activ', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_actividad', type: 'numeric'},
		{name:'hora_fin_activ', type: 'date',dateFormat:'H:i:s'},
		{name:'id_aom', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'actividad', type: 'string'},

	],
	sortInfo:{
		field: 'id_cronograma',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    east:{
        url:'../../../sis_auditoria/vista/cronograma_equipo_responsable/CronogramaEquipoResponsable.php',
        title:'Participantes en la Actividad',
        //height:'50%',
        width: '40%',
        cls:'CronogramaEquipoResponsable'
    },
    //arrayDefaultColumHidden:['nueva_actividad'],
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
        Phx.vista.Cronograma.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);
    },
    preparaMenu: function(n){

        var tb = Phx.vista.Cronograma.superclass.preparaMenu.call(this);
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

        var tb = Phx.vista.Cronograma.superclass.preparaMenu.call(this);
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
    },
    onButtonNew: function () {
        var data = this.getSelectedData();
        this.formCronoggrama();
        Phx.vista.Cronograma.superclass.onButtonNew.call(this);

        this.Cmp.id_actividad.on('select',function (combo,record,index) {
            console.log('combitoooooo',record);
            if(record.data.codigo_actividad != 'OTHER_ACTIVITY'){
                this.formCronoggrama();
            }
            else{
                this.formCronogNewActivity();
            }
        },this);

    },
    onButtonEdit: function () {
	    var data = this.getSelectedData();
        Phx.vista.Cronograma.superclass.onButtonEdit.call(this);
        if(data.nueva_actividad != ''){
            this.formCronogNewActivity();
            this.Cmp.id_actividad.disable();
        }
        else{
            this.formCronoggrama();
        }
        /*this.Cmp.id_actividad.on('select',function (combo,record,index) {
            console.log('combitoooooo',record);
            if(data.nueva_actividad == ''){
                this.formCronoggrama();
            }
            else{
                this.formCronogNewActivity();
            }
        },this);*/
        
    },
    formCronoggrama:function () {
        this.mostrarComponente(this.Cmp.id_actividad);
        this.mostrarComponente(this.Cmp.fecha_ini_activ);
        this.mostrarComponente(this.Cmp.fecha_fin_activ);
        this.mostrarComponente(this.Cmp.hora_ini_activ);
        this.mostrarComponente(this.Cmp.hora_fin_activ);
        this.mostrarComponente(this.Cmp.obs_actividad);

        this.ocultarComponente(this.Cmp.nueva_actividad);
    },
    formCronogNewActivity:function () {
        this.mostrarComponente(this.Cmp.id_actividad);
        this.mostrarComponente(this.Cmp.fecha_ini_activ);
        this.mostrarComponente(this.Cmp.fecha_fin_activ);
        this.mostrarComponente(this.Cmp.hora_ini_activ);
        this.mostrarComponente(this.Cmp.hora_fin_activ);
        this.mostrarComponente(this.Cmp.obs_actividad);

        this.mostrarComponente(this.Cmp.nueva_actividad);
    }

	}
)
</script>
		
		