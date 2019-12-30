<?php
/**
*@package pXP
*@file gen-CronogramaEquipoResponsable.php
*@author  (max.camacho)
*@date 12-12-2019 20:16:51
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-12-2019				 (max.camacho)				CREACION	

*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.CronogramaEquipoResponsable=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.CronogramaEquipoResponsable.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_cronog_eq_resp'
            },
            type:'Field',
            form:true
        },
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
        /*{
            config: {
                name: 'id_cronograma',
                fieldLabel: 'id_cronograma',
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
                hiddenName: 'id_cronograma',
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
                name: 'id_equipo_responsable',
                fieldLabel: 'Funcionario',
                typeAhead: false,
                forceSelection: true,
                allowBlank: false,
                disableSearchButton: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/EquipoResponsable/listarEquipoResponsable',
                    //url: '../../sis_auditoria/control/EquipoResponsable/listarEquipoRespCronog',
                    id: 'id_equipo_responsable',
                    root: 'datos',
                    sortInfo: {
                        field: 'desc_funcionario1',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_equipo_responsable', 'desc_funcionario1'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'desc_funcionario1'}
                }),
                valueField: 'id_equipo_responsable',
                displayField: 'desc_funcionario1',
                gdisplayField: 'desc_funcionario1',
                hiddenName: 'id_equipo_responsable',
                enableMultiSelect: true,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '80%',
                gwidth: 150,
                //listWidth:'280',
                resizable:true,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_funcionario1']);
                },
            },
            //type: 'ComboBox',
            type: 'AwesomeCombo',
            id_grupo: 0,
            filters: {pfiltro: 'vfc.desc_funcionario1',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'v_participacion',
                fieldLabel: 'v_participacion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:20
            },
            type:'TextField',
            filters:{pfiltro:'crer.v_participacion',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'obs_participacion',
                fieldLabel: 'Obs. Participacion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:1000
            },
            type:'TextArea',
            filters:{pfiltro:'crer.obs_participacion',type:'string'},
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
				filters:{pfiltro:'crer.estado_reg',type:'string'},
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
				filters:{pfiltro:'crer.fecha_reg',type:'date'},
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
				filters:{pfiltro:'crer.usuario_ai',type:'string'},
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
				filters:{pfiltro:'crer.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'crer.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Cronograma Equipo Responsable',
	ActSave:'../../sis_auditoria/control/CronogramaEquipoResponsable/insertarCronogramaEquipoResponsable',
	ActDel:'../../sis_auditoria/control/CronogramaEquipoResponsable/eliminarCronogramaEquipoResponsable',
	ActList:'../../sis_auditoria/control/CronogramaEquipoResponsable/listarCronogramaEquipoResponsable',
	id_store:'id_cronog_eq_resp',
	fields: [
		{name:'id_cronog_eq_resp', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'v_participacion', type: 'string'},
		{name:'obs_participacion', type: 'string'},
		{name:'id_equipo_responsable', type: 'numeric'},
		{name:'id_cronograma', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'desc_funcionario1', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_cronog_eq_resp',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    onReloadPage:function(m){
        this.maestro=m;
        this.store.baseParams = {id_cronograma: this.maestro.id_cronograma};
        //Ext.apply(this.Cmp.id_centro_costo.store.baseParams,{id_gestion: this.maestro.id_gestion});
        this.load({params:{start:0, limit:50}});
        this.Cmp.id_cronograma.disable(true);
    },
    loadValoresIniciales: function () {
        //this.Cmp.id_aom.setValue(this.maestro.id_aom);
        //Phx.vista.AuditoriaNorma.superclass.loadValoresIniciales.call(this);
        Phx.vista.CronogramaEquipoResponsable.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_cronograma.setValue(this.maestro.id_cronograma);

    },
    onButtonNew:function(){
        var data = this.getSelectedData();
        console.log('data',data);
        console.log('maestro',this.maestro);
        //console.log('maestro[ id_aom->',this.maestro.id_aom +', id cronograma->'+this.maestro.id_cronograma+']');
        this.Cmp.id_equipo_responsable.enableMultiSelect = true;
        this.Cmp.id_equipo_responsable.type = 'AwesomeCombo';
        this.ocultarComponente(this.Cmp.v_participacion);
        Phx.vista.CronogramaEquipoResponsable.superclass.onButtonNew.call(this);
        this.Cmp.id_equipo_responsable.on('select', function(c, r, i){
            var aux=this.store.data.length;
            for (i=0;i<aux;i++){
                var funcio=this.store.data.items[i].data.id_equipo_responsable;
                if (funcio==r.id){
                    alert ('EL FUNCIONARIO YA ESTA REGISTRADO'+r.id)
                    this.Cmp.id_equipo_responsable.reset();
                    return false;
                }
            }
        }, this);
        //this.inicarEvento();
        this.Cmp.id_equipo_responsable.store.baseParams ={par_filtro:'vfc.desc_funcionario1',p_id_aom: this.maestro.id_aom,p_id_cronograma:this.maestro.id_cronograma};
        this.Cmp.id_equipo_responsable.lastQuery = null;
    },
    onButtonEdit:function(){
        var data = this.getSelectedData();
        console.log('data',data);
        this.Cmp.id_equipo_responsable.enableMultiSelect = false;
        this.Cmp.id_equipo_responsable.type = 'ComboBox';
        this.ocultarComponente(this.Cmp.v_participacion);
        Phx.vista.CronogramaEquipoResponsable.superclass.onButtonEdit.call(this);

        this.Cmp.id_equipo_responsable.on('select', function(c, r, i){
            var aux=this.store.data.length;
            for (i=0;i<aux;i++){
                var funcio=this.store.data.items[i].data.id_equipo_responsable;
                if (funcio==r.id){
                    alert('EL FUNCIONARIO YA ESTA REGISTRADO'+r.id);
                    this.Cmp.id_equipo_responsable.setValue(data.id_equipo_responsable);
                    return false;
                }
            }
        }, this);

        //this.inicarEvento();
        this.Cmp.id_equipo_responsable.store.baseParams ={par_filtro:'vfc.desc_funcionario1',pe_id_aom: this.maestro.id_aom,pe_id_cronograma:this.maestro.id_cronograma,pe_id_equipo_responsable:this.getSelectedData().id_equipo_responsable};
        this.Cmp.id_equipo_responsable.lastQuery = null;

    },
    inicarEvento:function () {
        // console.log(this.maestro.id_aom);

        this.Cmp.id_equipo_responsable.store.baseParams ={par_filtro:'vfc.desc_funcionario1',p_id_aom: this.maestro.id_aom,p_id_cronograma:this.maestro.id_cronograma};
        this.Cmp.id_equipo_responsable.lastQuery = null;


        //this.getBoton('new').disable();
        //this.getBoton('save').disable();
    }

	}
)
</script>
		
		