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
		Phx.vista.AuditoriaProceso.superclass.constructor.call(this,config);
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
                    fields: ['id_proceso', 'proceso','desc_funcionario1','vigencia'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'pcs.proceso'}
                }),
                valueField: 'id_proceso',
                displayField: 'proceso',
                gdisplayField: 'proceso',
                hiddenName: 'id_proceso',
               // tpl:'<tpl for="."><div class="x-combo-list-item"><p>{proceso}</p>' +
               // '<p><b>Responsable: </b>{desc_funcionario1}</div></tpl>',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '100%',
                gwidth: 200,
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
                name: 'desc_funcionario',
                fieldLabel: 'Responsable',
                allowBlank: true,
                anchor: '80%',
                gwidth: 200,
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
                fieldLabel: 'Obs',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:-5
            },
            type:'TextField',
            filters:{pfiltro:'aupc.obs_pcs',type:'string'},
            id_grupo:1,
            grid:false,
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
		{name:'desc_funcionario', type: 'string'},
		{name:'proceso', type: 'string'},

	],
	sortInfo:{
		field: 'id_aproceso',
		direction: 'ASC'
	},
	bdel:true,
	bsave:false,
    fwidth: '40%',
    fheight: '20%',
    onReloadPage:function(m){
        this.maestro=m;
        this.store.baseParams = {id_aom: this.maestro.id_aom};
        this.load({params:{start:0, limit:50}})
    },
    loadValoresIniciales: function () {
        Phx.vista.AuditoriaProceso.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);
    },
	}
)
</script>
		
		