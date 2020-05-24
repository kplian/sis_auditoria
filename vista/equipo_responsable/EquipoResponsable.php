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
		Phx.vista.EquipoResponsable.superclass.constructor.call(this,config);
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
        {
            config: {
                name: 'id_parametro',
                fieldLabel: 'Tipo Auditor',
                allowBlank: false,
                resizable:true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
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
                    baseParams: { par_filtro: 'prm.id_parametro',
                                  tipo_parametro:'TIPO_PARTICIPACION'/*,
                                  codigo_parametro:"''ETE'',''RESP'',''OTHERS'',''INV''"*/}
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
      /*  {
            config:{
                name:'id_funcionario',
                origen:'FUNCIONARIOCAR',
                fieldLabel:'Responsable',
                gdisplayField:'desc_funcionario', //mapea al store del grid
                valueField:'id_funcionario',
                width:300,
                gwidth:250,
                renderer:function(value, p, record) {
                    return String.format('{0}', record.data['desc_funcionario1']);
                }
            },
            type:'ComboRec',
            id_grupo:2,
            grid:true,
            form:true
        },*/
		{
			config: {
				name: 'id_funcionario',
				fieldLabel: 'Funcionario',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListAuditores',
					id: 'id_funcionario',
					root: 'datos',
					sortInfo: {
						field: 'desc_funcionario1',
						direction: 'DESC'
					},
					totalProperty: 'total',
					fields: ['id_funcionario', 'desc_funcionario1'],
					remoteSort: true,
					baseParams: {par_filtro: 'fun.desc_funcionario1'}
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
	bsave:false,
    onReloadPage:function(m){
        this.maestro=m;
        this.store.baseParams = {id_aom: this.maestro.id_aom};
        this.load({params:{start:0, limit:50}})
    },
    loadValoresIniciales: function () {
        Phx.vista.EquipoResponsable.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_aom.setValue(this.maestro.id_aom);
    },
    onButtonNew: function () {
        Phx.vista.EquipoResponsable.superclass.onButtonNew.call(this);
        this.Cmp.id_parametro.on('select', function( combo, record, index){
            this.Cmp.id_funcionario.store.baseParams ={
                codigo: record.data.codigo_parametro,
                id_uo: this.maestro.id_uo,
                par_filtro:'fun.desc_funcionario1'}; 
            this.Cmp.id_funcionario.modificado = true;
        },this);
    },
    onButtonEdit:function(){
        Phx.vista.EquipoResponsable.superclass.onButtonEdit.call(this);
    },
    preparaMenu:function(n){
        var tb =this.tbar;
        Phx.vista.EquipoResponsable.superclass.preparaMenu.call(this,n);
        
        if (this.maestro.estado_wf ==='programada') {
            this.getBoton('new').disable();
            this.getBoton('edit').disable();
            this.getBoton('del').disable();
        }else{
            this.getBoton('new').enable();
            this.getBoton('edit').enable();
            this.getBoton('del').enable();
        }

        return tb
    },
    liberaMenu:function(){
        var tb = Phx.vista.EquipoResponsable.superclass.liberaMenu.call(this);
        if(tb){
            if (this.maestro.estado_wf ==='programada'){
                this.getBoton('new').disable();
                this.getBoton('edit').disable();
                this.getBoton('del').disable();
            }else{
                this.getBoton('new').enable();
                this.getBoton('edit').enable();
                this.getBoton('del').enable();
            }
        }
        return tb
    }
	}
)
</script>
		
		