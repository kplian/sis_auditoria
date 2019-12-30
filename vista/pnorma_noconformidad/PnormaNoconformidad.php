<?php
/**
*@package pXP
*@file PnormaNoconformidad.php
*@author  (szambrana)
*@date 19-07-2019 15:25:54
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PnormaNoconformidad=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.PnormaNoconformidad.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pnnc'
			},
			type:'Field',
			form:true 
		},
        {
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_nc'
			},
			type:'Field',
			form:true
		}, 
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'estado_reg'
			},
			type:'Field',
			form:true
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'usuario_ai'
			},
			type:'Field',
			form:true
		},

        {
            config: {
                name: 'id_norma',
                fieldLabel: 'Norma',
                allowBlank: true,
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
                    fields: ['id_norma', 'nombre_norma', 'sigla_norma'],
                    remoteSort: true,
                    //baseParams: {par_filtro: 'norm.nombre_norma#norm.sigla_norma'}
                    baseParams: {par_filtro: 'norm.sigla_norma#norm.nombre_norma'}
                }),
                valueField: 'id_norma',
                //displayField: 'nombre_norma',
                //gdisplayField: 'desc_norma',
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
                anchor: '50%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_norma']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'norm.nombre_norma',type: 'string'},
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
					url: '../../sis_auditoria/control/PuntoNorma/listarPuntoNormaMulti',
					id: 'id_pn',
					root: 'datos',
					sortInfo: {
						field: 'nombre_pn',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_pn', 'nombre_pn', 'codigo_pn'],
					remoteSort: true
					//baseParams: {par_filtro: 'pnorm.nombre_pn#pnorm.codigo_pn'}
				}),
				valueField: 'id_pn',
				displayField: 'nombre_pn',
				gdisplayField: 'desc_pn',
				hiddenName: 'id_pn',
                //tpl:'<tpl for="."><div class="x-combo-list-item"><p> <b>Codigo: </b>{codigo_pn}</p><p style="color: blue"><b>Nombre: </b>{{nombre_pn}</p></div></tpl>',
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
				enableMultiSelect: true,
				renderer : function(value, p, record) {
					//return String.format('{0}', record.data['desc_pn']);
					return String.format('{0}', record.data['codigo_pn','desc_pn']);
				}
			},
			type: 'AwesomeCombo',
			id_grupo: 0,
			filters: {pfiltro: 'pnorm.nombre_pn',type: 'string'},
			grid: true,
			form: true
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
				filters:{pfiltro:'pnnc.fecha_reg',type:'date'},
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
				filters:{pfiltro:'pnnc.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'pnnc.fecha_mod',type:'date'},
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
	title:'Puntos de norma para No Conformidades',
	ActSave:'../../sis_auditoria/control/PnormaNoconformidad/insertarPnormaNoconformidad',
	ActDel:'../../sis_auditoria/control/PnormaNoconformidad/eliminarPnormaNoconformidad',
	ActList:'../../sis_auditoria/control/PnormaNoconformidad/listarPnormaNoconformidad',
	id_store:'id_pnnc',
	fields: [
		{name:'id_pnnc', type: 'numeric'},
		{name:'id_nc', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_pn', type: 'numeric'},
		{name:'nombre_pn', type: 'string'},
		{name:'id_norma', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        //**********SSS
        {name:'desc_norma', type: 'string'},
        {name:'desc_pn', type: 'string'},
        //**********
		
	],
	sortInfo:{
		field: 'id_pnnc',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    //***********SSS
    /*onReloadPage:function (m)
    {
	    this.maestro=m;
	    this.store.baseParams={id_nc:this.maestro.id_nc};
	    this.load({params:{start:0, limit:50}})
    },
    loadValoresIniciales:function ()
    {
        Phx.vista.PnormaNoconformidad.superclass.loadValoresIniciales.call(this);
        //console.log(this.maestro);
        this.Cmp.id_nc.setValue(this.maestro.id_nc);
    },
	*/
	//
    onButtonNew :function () {
        Phx.vista.PnormaNoconformidad.superclass.onButtonNew.call(this);
        this.Cmp.id_nc.setValue(this.maestro.id_nc);
        //*** Filtro para seleccionar solo los punto de norma de la norma seleccionada***SSS
        this.Cmp.id_norma.on('select', function(combo, record, index){
            this.Cmp.id_pn.store.baseParams ={	par_filtro: 'ptonor.nombre_pn#ptonor.codigo_pn',
											    id_norma : record.data.id_norma,
												id_nc: this.maestro.id_nc,
												fill : 'si'
											};
            this.Cmp.id_pn.reset();
          //  this.store.removeAll();
            this.Cmp.id_pn.modificado = true;
        },this);
        this.Cmp.id_pn.on('select', function(combo, record, index){
            //this.Cmp.nombre_pn.reset();
            // this.Cmp.nombre_pn.setValue(record.data.nombre_pn);
        },this);
    },

    }
)
</script>
		
		