<?php
/**
 *@package pXP
 *@file NoConformidadAdmin.php
 *@author  (szambrana)
 *@date 04-07-2019 19:53:16
 *@Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadAdmin = {
        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'No Conformidad Detalle ',
        nombreVista: 'NoConformidadAdmin',

		bdel:false,
		bsave:false,
		bnew:false,
		bedit:false,

        bodyStyleForm: 'padding:5px;',
        borderForm: true,
        frameForm: false,
        paddingForm: '5 5 5 5',

        storeResponsable:{},
        storeAcciones:{},
        constructor: function(config) {
			this.idContenedor = config.idContenedor;
			this.maestro = config;
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
			this.initButtons=[this.cmbTipoAuditoria, this.cmbAuditorias];
			Phx.vista.NoConformidadAdmin.superclass.constructor.call(this,config);
            this.getBoton('btnNoram').setVisible(false);
            this.iniciarEvento();
			this.init();
            //insertamos y habilitamos el boton siguiente
            this.addButton('atras',{argument: { estado: 'anterior'},
                text:'Anterior',
                iconCls: 'batras',
                disabled:true,
                handler:this.onButtonAtras,
                tooltip: '<b>Pasar al anterior Estado</b>'});

            this.addButton('siguiente', {
                    text:'Proponer Acciones',
                    iconCls: 'bok',
                    disabled:true,
                    handler:this.onCambiarEstado,   //creamos esta funcion para disparar el evento al presionar siguiente
                    tooltip: '<b>Siguiente</b><p>Pasar al siguiente estado</p>'
                }
            );

        },
        preparaMenu:function(n){
            const tb =this.tbar;
            Phx.vista.NoConformidadAdmin.superclass.preparaMenu.call(this,n);
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('siguiente').enable();
            this.getBoton('atras').enable();
            return tb
        },
        liberaMenu:function(){
            const tb = Phx.vista.NoConformidadAdmin.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('btnChequeoDocumentosWf').disable();
                this.getBoton('siguiente').disable();
                this.getBoton('atras').disable();
            }
            return tb
        },
        iniciarEvento:function(){
            this.cmbTipoAuditoria.on('select', function(combo, record, index){
                this.cmbTipoAuditoria = record.data.id_tipo_auditoria;
                this.cmbAuditorias.enable();
                this.cmbAuditorias.reset();
                this.store.removeAll();
                this.cmbAuditorias.store.baseParams = Ext.apply(
                    this.cmbAuditorias.store.baseParams, {
                        v_tipo_auditoria_nc: record.data.id_tipo_auditoria
                    });
                this.cmbAuditorias.modificado = true;
            },this);

            this.cmbAuditorias.on('select', function(combo, record, index){
                this.capturaFiltros();
            },this);

        },
        capturaFiltros:function(combo, record, index){
            if(this.validarFiltros()){
                this.store.baseParams.id_aom = this.cmbAuditorias.getValue();
                this.store.baseParams.interfaz = this.nombreVista;
                this.load();
            }
        },
        validarFiltros:function(){
            return !!this.cmbAuditorias.validate();
        },
        EnableSelect: function(){
            Phx.vista.NoConformidad.superclass.EnableSelect.call(this);
        },
        onButtonEdit:function(){
            this.onCrearFormulario();
            this.abrirVentana('edit');
        },
        abrirVentana: function(tipo){
            if(tipo === 'edit'){
                this.cargaFormulario(this.sm.getSelected().data);
                this.onData(this.sm.getSelected().data);
            }
            this.formularioVentana.show();
        },
        onData:function(record){
            this.storeResponsable.baseParams.id_nc = record.id_nc;
            this.storeResponsable.load();
            this.storeAcciones.baseParams.id_nc = record.id_nc;
            this.storeAcciones.load();
        },
        onCrearFormulario:function() {
            const me = this;
            if(this.formularioVentana) {
                this.form.destroy();
                this.formularioVentana.destroy();
            }
            const no_conformidad = this.sm.getSelected().data;
            const tienda = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/PnormaNoconformidad/listarPnormaNoconformidad',
                id: 'id_pnnc',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_aom','id_pnnc','id_nc','codigo_pn','nombre_pn','id_norma','desc_norma','desc_pn','id_pn','sigla_norma'],
                remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_pnnc',limit:'100',start:'0'}
            });
            tienda.baseParams.id_aom = no_conformidad.id_aom;
            tienda.baseParams.id_nc = no_conformidad.id_nc;
            tienda.load();
            const punto_norma = new Ext.grid.GridPanel({
                // layout: 'fit',
                store: tienda,
                height: 120,
               // width: 800,
                split: false,
                plain: false,
                trackMouseOver: false,
                stripeRows: false,
                border: true,
                columns: [
                    {
                        header: 'Norma',
                        dataIndex: 'id_norma',
                        width: 200,
                        sortable: true,
                        renderer:function(value, p, record){return String.format('{0}', record.data['desc_norma'])},
                    },
                    {
                        header: 'Codigo',
                        dataIndex: 'codigo_pn',
                        width: 80,
                        sortable: true,
                    },
                    {
                        header: 'Punto de Norma',
                        dataIndex: 'id_pn',
                        width: 310,
                        sortable: true,
                        renderer:function(value, p, record){return String.format('{0}', record.data['nombre_pn'])},
                    }
                ]
            });

            this.storeResponsable = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/RespAccionesProp/listarRespAccionesProp',
                id: 'id_respap',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_respap','id_nc','id_funcionario','desc_funcionario1','estado_reg', 'fecha_reg','usr_reg'],
                remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_respap',limit:'100',start:'0'}
            });
            const responsable_accion = new Ext.grid.GridPanel({
                layout: 'fit',
                store:  this.storeResponsable,
                region: 'center',
                trackMouseOver: false,
                split: true,
                border: true,
                plain: true,
                stripeRows: true,
                tbar: [{
                    text: '<i class="fa fa-plus fa-lg">&nbsp;&nbsp;Asignar</i>',
                    scope: this,
                    width: '100',
                    handler: function() {
                        me.onCrearFormularioResponsable();
                        me.ventanaResponsable.show();
                    }
                    },
                    {
                        text: '<i class="fa fa-trash fa-lg">&nbsp;&nbsp;Eliminar</i>',
                        scope:this,
                        width: '100',
                        handler: function(){
                            const  s =  responsable_accion.getSelectionModel().getSelections();
                            Phx.CP.loadingShow();
                            Ext.Ajax.request({
                                url: '../../sis_auditoria/control/RespAccionesProp/eliminarRespAccionesProp',
                                params: {
                                    id_respap : s[0].data.id_respap
                                },
                                isUpload: false,
                                success: function(a,b,c){
                                    Phx.CP.loadingHide();
                                    me.storeResponsable.load();
                                },
                                argument: this.argumentSave,
                                failure: this.conexionFailure,
                                timeout: this.timeout,
                                scope: this
                            })
                        }
                    }
                ],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Funcionario',
                        dataIndex: 'id_funcionario',
                        width:300,
                        sortable: false,
                        renderer : function(value, p, record) {
                            return String.format('{0}', record.data['desc_funcionario1']);
                        }
                    },
                    {
                        header: 'Estado Reg.',
                        dataIndex: 'estado_reg',
                        sortable: false
                    },
                    {
                        header: 'Creado por.',
                        dataIndex: 'usr_reg',
                        sortable: false
                    },
                    {
                        header: 'Fecha creación',
                        dataIndex: 'fecha_reg',
                        width: 110
                    }
                ]
            });
            this.storeAcciones = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/AccionPropuesta/listarAccionPropuesta',
                id: 'id_ap',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_ap',
                        'id_nc',
                        'obs_resp_area',
                        'descripcion_ap',
                        'id_parametro',
                        'descrip_causa_nc',
                        'efectividad_cumpl_ap',
                        'fecha_fin_ap',
                        'obs_auditor_consultor',
                        'fecha_inicio_ap',
                        'valor_parametro'
                ],
                remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_ap',limit:'100',start:'0'}
            });
            const acciones = new Ext.grid.GridPanel({
                layout: 'fit',
                store: this.storeAcciones,
                region: 'center',
                trackMouseOver: false,
                split: true,
                border: true,
                plain: true,
                stripeRows: true,
                tbar: [{
                    text: '<i class="fa fa-plus fa-lg">&nbsp;&nbsp;Asignar</i>',
                    scope: this,
                    width: '100',
                    handler: function() {
                        me.onCrearFormularioAcciones(null);
                        me.ventanaAcciones.show();
                    },
                },
                    {
                        text: '<i class="fa fa-edit fa-lg">&nbsp;&nbsp;Editar</i>',
                        scope:this,
                        width: '100',
                        handler: function(){
                            const s =  acciones.getSelectionModel().getSelections();
                            if (s.length === 0) {
                                alert('Selection un registro')
                            }
                            me.onCrearFormularioAcciones(s[0].data);
                            me.ventanaAcciones.show();
                        }
                    },
                    {
                        text: '<i class="fa fa-trash fa-lg">&nbsp;&nbsp;Eliminar</i>',
                        scope:this,
                        width: '100',
                        handler: function(){
                            const  s =  acciones.getSelectionModel().getSelections();
                            Phx.CP.loadingShow();
                            Ext.Ajax.request({
                                url: '../../sis_auditoria/control/AccionPropuesta/eliminarAccionPropuesta',
                                params: {
                                    id_ap : s[0].data.id_ap
                                },
                                isUpload: false,
                                success: function(a,b,c){
                                    Phx.CP.loadingHide();
                                    me.storeAcciones.load();
                                },
                                argument: this.argumentSave,
                                failure: this.conexionFailure,
                                timeout: this.timeout,
                                scope: this
                            })
                        }
                    }
                ],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Tipo',
                        dataIndex: 'id_parametro',
                        width: 100,
                        renderer:function(value, p, record){return String.format('{0}', record.data['valor_parametro'])},

                    },
                    {
                        header: 'Descripcion',
                        dataIndex: 'descripcion_ap',
                        align: 'justify',
                        width: 280,
                        renderer : function(value, p, record) {
                            return String.format('<div class="gridmultiline" style=" font-size: 10px; ">{0}</div>', record.data['descripcion_ap']);
                        }
                    },
                    {
                        header: 'Fecha Inicio',
                        dataIndex: 'fecha_inicio_ap',
                        align: 'center',
                        width: 100,
                    },
                    {
                        header: 'Fecha Fin',
                        dataIndex: 'fecha_fin_ap',
                        align: 'center',
                        width: 100,
                    },
                    {
                        header: 'Estado',
                        dataIndex: 'estado_wf',
                        align: 'center',
                        width: 150,
                        renderer : function(value, p, record) {
                            return String.format('<div class="gridmultiline" style=" font-size: 10px; ">{0}</div>', record.data['estado_wf']);
                        }
                    }
                ]
            });
            console.log(no_conformidad,'--> saske')
            this.form = new Ext.form.FormPanel({
                id: this.idContenedor + '_formulario_aud',
                items: [{ region: 'center',
                    layout: 'column',
                    border: false,
                    autoScroll: true,
                    items: [{
                        xtype: 'tabpanel',
                        plain: true,
                        activeTab: 0,
                        height: 600,
                        deferredRender: false,
                        items: [{
                            title: 'Datos Generales',
                            layout: 'form',
                            defaults: {
                                width: 700,
                            },
                            autoScroll: true,
                            defaultType: 'textfield',
                            items: [
                                new Ext.form.FieldSet({
                                    collapsible: false,
                                    border: true,
                                    layout: 'form',
                                    defaults: {width: 650},
                                    items: [
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Nombre Auditoria',
                                            name: 'nombre_aom1',
                                            anchor: '100%',
                                            value: no_conformidad.nombre_aom1,
                                            readOnly :true,
                                            style: 'background-image: none; background: #eeeeee;'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Area',
                                            name: 'nombre_unidad',
                                            anchor: '100%',
                                            value: no_conformidad.nombre_unidad,
                                            readOnly :true,
                                            style: 'background-image: none; background: #eeeeee;'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Nombre Auditoria',
                                            name: 'desc_funcionario_resp',
                                            anchor: '100%',
                                            value: no_conformidad.desc_funcionario_resp,
                                            readOnly :true,
                                            style: 'background-image: none; background: #eeeeee;'
                                        },
                                    ]
                                }),
                                new Ext.form.FieldSet({
                                    collapsible: false,
                                    border: true,
                                    layout: 'form',
                                    defaults: {width: 650},
                                    items: [
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Tipo',
                                            name: 'valor_parametro',
                                            anchor: '100%',
                                            value: no_conformidad.valor_parametro,
                                            readOnly :true,
                                            style: 'background-image: none; background: #eeeeee;'
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'descrip_nc',
                                            fieldLabel: 'No conformidad',
                                            allowBlank: true,
                                            anchor: '100%',
                                            height:150,
                                            readOnly :true,
                                            value: no_conformidad.descrip_nc,
                                            style: 'background-image: none; background: #eeeeee;'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Área de la NC',
                                            name: 'nombre_unidad_nc',
                                            anchor: '100%',
                                            value: no_conformidad.gerencia_uo1,
                                            readOnly :true,
                                            style: 'background-image: none; background: #eeeeee;'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Resp. de Aprobar NC',
                                            name: 'desc_funcionario_nc',
                                            anchor: '100%',
                                            value: no_conformidad.funcionario_uo,
                                            readOnly :true,
                                            style: 'background-image: none; background: #eeeeee;'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Evidencia',
                                            name: 'evidencia',
                                            anchor: '100%',
                                            value: no_conformidad.evidencia,
                                            readOnly :true,
                                            style: 'background-image: none; background: #eeeeee;'
                                        }, new Ext.form.FieldSet({
                                            collapsible: false,
                                            title:'Puntos Norma',
                                            border: true,
                                            layout: 'form',
                                            // defaults: {width: 650},
                                            items: [
                                                punto_norma,
                                            ]
                                        }),
                                        {
                                            xtype: 'textarea',
                                            name: 'obs_consultor',
                                            fieldLabel: 'Observación',
                                            allowBlank: true,
                                            anchor: '100%',
                                           //  id: this.idContenedor + '_obs_consultor',

                                            height:80
                                        },
                                    ]
                                }),
                            ]},
                            {
                                title: 'Responsables de Acciones',
                                layout: 'fit',
                                region:'center',
                                items: [
                                    responsable_accion
                                ]},
                            {
                                title: 'Acciones Propuestas',
                                layout: 'fit',
                                region:'center',
                                items: [
                                    acciones
                                ]}
                        ]
                    }]
                }],
                padding: this.paddingForm,
                bodyStyle: this.bodyStyleForm,
                border: this.borderForm,
                frame: this.frameForm,
                autoDestroy: true,
                autoScroll: true,
                region: 'center'
            });
            this.formularioVentana = new Ext.Window({
                width: 750,
                height: 700,
                modal: true,
                closeAction: 'hide',
                labelAlign: 'top',
                title: 'Informe Auditoria',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: [
                    this.form
                ],
                buttons: [{
                    text: 'Guardar',
                    handler: this.onSubmit,
                    scope: this
                }, {
                    text: 'Declinar',
                    handler: function() {
                        this.formularioVentana.hide();
                    },
                    scope: this
                }]
            });
        },
        onSubmit:function(){
            const submit={};
            Ext.each(this.form.getForm().items.keys, function(element, index){
                obj = Ext.getCmp(element);
                if(obj.items){
                    Ext.each(obj.items.items, function(elm, ind){
                        submit[elm.name]=elm.getValue();
                    },this)
                } else {
                    submit[obj.name]=obj.getValue();
                }
            },this);
            const maestro = this.sm.getSelected().data;

            if (this.form.getForm().isValid()) {
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_auditoria/control/NoConformidad/insertarNoConformidad',
                    params: {
                        id_nc :maestro.id_nc,
                        obs_consultor:submit.obs_consultor,
                        extra: 'si'
                    },
                    isUpload: false,
                    success: function(a,b,c){
                        this.store.rejectChanges();
                        Phx.CP.loadingHide();
                        this.formularioVentana.hide();
                        this.reload();
                    },
                    argument: this.argumentSave,
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            } else {
                Ext.MessageBox.alert('Validación', 'Existen datos inválidos en el formulario. Corrija y vuelva a intentarlo');
            }
        },
        cargaFormulario: function(data){
            let obj;
            Ext.each(this.form.getForm().items.keys, function(element){
                obj = Ext.getCmp(element);
                if(obj){
                    if(obj.name === 'obs_consultor'){
                        obj.setValue(data[obj.name]);
                    }
                }
            },this);
        },
        onCrearFormularioResponsable:function () {
            const no_conformidad = this.sm.getSelected().data;
            console.log(no_conformidad,'--<>--');
            const me = this;
            const isForm = new Ext.form.FormPanel({
                id: this.idContenedor + '_no_form',
                items: [new Ext.form.FieldSet({
                    collapsible: false,
                    border: false,
                    layout: 'form',
                    defaults: { width: 600},
                    items: [
                        new Ext.form.FieldSet({
                            collapsible: false,
                            border: true,
                            layout: 'form',
                            defaults: {width: 650},
                            items: [
                                {
                                    xtype: 'field',
                                    fieldLabel: 'Nombre Auditoria',
                                    name: 'nombre_aom1',
                                    anchor: '100%',
                                    value: no_conformidad.nombre_aom1,
                                    readOnly: true,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    xtype: 'field',
                                    fieldLabel: 'Area',
                                    name: 'nombre_unidad',
                                    anchor: '100%',
                                    value: no_conformidad.nombre_unidad,
                                    readOnly :true,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    xtype: 'field',
                                    fieldLabel: 'Responsable Área:',
                                    name: 'desc_funcionario_resp',
                                    anchor: '100%',
                                    value: no_conformidad.funcionario_uo,
                                    readOnly :true,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    xtype: 'field',
                                    fieldLabel: 'Área de la NC:',
                                    name: 'desc_funcionario_resp',
                                    anchor: '100%',
                                    value: no_conformidad.gerencia_uo1,
                                    readOnly :true,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    xtype: 'textarea',
                                    name: 'descrip_nc',
                                    fieldLabel: 'No conformidad',
                                    allowBlank: true,
                                    anchor: '100%',
                                    height:150,
                                    readOnly :true,
                                    value: no_conformidad.descrip_nc,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    anchor: '100%',
                                    bodyStyle: 'padding:10px;',
                                    title: 'Destinatarios Adicionales',
                                    items:[{
                                        xtype: 'itemselector',
                                        name: 'id_res_funcionarios',
                                        fieldLabel: 'Destinatarios',
                                        imagePath: '../../../pxp/lib/ux/images/',
                                        drawUpIcon:false,
                                        drawDownIcon:false,
                                        drawTopIcon:false,
                                        drawBotIcon:false,
                                        multiselects: [{
                                            width: 250,
                                            height: 200,
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
                                                autoLoad: true,
                                                baseParams: {
                                                    dir:'ASC',
                                                    sort:'id_aom',
                                                    limit:'100',
                                                    start:'0',
                                                    codigo:'MEQ',
                                                    destinatario: no_conformidad.id_aom
                                                }
                                            }),
                                            displayField: 'desc_funcionario1',
                                            valueField: 'id_funcionario',
                                           },
                                            {
                                                width: 250,
                                                height: 200,
                                                store: new Ext.data.JsonStore({
                                                    url: '../../sis_auditoria/control/RespAccionesProp/listarRespAccionesProp',
                                                    id: 'id_funcionario',
                                                    root: 'datos',
                                                    totalProperty: 'total',
                                                    fields: ['id_funcionario', 'desc_funcionario1'],
                                                    remoteSort: true,
                                                    autoLoad: true,
                                                    baseParams: {
                                                        dir:'ASC',
                                                        sort:'id_nc',
                                                        limit:'100',
                                                        start:'0',
                                                        id_nc: no_conformidad.id_nc
                                                    }
                                                }),
                                                displayField: 'desc_funcionario1',
                                                valueField: 'id_funcionario',
                                            }]
                                    }]
                                },
                            ]
                        })
                    ]
                })],
                padding: this.paddingForm,
                bodyStyle: this.bodyStyleForm,
                border: this.borderForm,
                frame: this.frameForm,
                autoScroll: false,
                autoDestroy: true,
                autoScroll: true,
                region: 'center'
            });
            this.ventanaResponsable = new Ext.Window({
                width: 670,
                height: 650,
                modal: true,
                closeAction: 'hide',
                labelAlign: 'bottom',
                title: 'Responsables de Acciones',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: [isForm],
                buttons: [{
                    text: 'Guardar',
                    handler: function () {
                        const submit={};
                        Ext.each(isForm.getForm().items.keys, function(element, index){
                            obj = Ext.getCmp(element);
                            if(obj.items){
                                Ext.each(obj.items.items, function(elm, ind){
                                    submit[elm.name]=elm.getValue();
                                },this)
                            } else {
                                submit[obj.name]=obj.getValue();
                            }
                        },this);
                        Phx.CP.loadingShow();
                        Ext.Ajax.request({
                            url: '../../sis_auditoria/control/RespAccionesProp/insertarItemRespAccionesProp',
                            params: {
                                id_nc :no_conformidad.id_nc,
                                id_res_funcionarios: submit.id_res_funcionarios
                            },
                            isUpload: false,
                            success: function(a,b,c){
                                Phx.CP.loadingHide();
                                me.ventanaResponsable.hide();
                                me.storeResponsable.load();
                            },
                            argument: this.argumentSave,
                            failure: this.conexionFailure,
                            timeout: this.timeout,
                            scope: this
                        });
                    },
                    scope: this
                }, {
                    text: 'Declinar',
                    handler: function() {
                        me.ventanaResponsable.hide();
                    },
                    scope: this
                }]
            });
        },
        onCrearFormularioAcciones:function (data) {
            const no_conformidad = this.sm.getSelected().data;
            let id_modificacion = null;
            if (data){
               id_modificacion = data.id_ap;
            }
            console.log(data);
            console.log(no_conformidad,'--<>--');
            const me = this;
            const isForm = new Ext.form.FormPanel({
                id: this.idContenedor + '_no_form',
                items: [new Ext.form.FieldSet({
                    collapsible: false,
                    border: false,
                    layout: 'form',
                    defaults: { width: 600},
                    items: [
                        new Ext.form.FieldSet({
                            collapsible: false,
                            border: true,
                            layout: 'form',
                            defaults: {width: 650},
                            items: [
                                {
                                    xtype: 'field',
                                    fieldLabel: 'Nombre Auditoria',
                                    name: 'nombre_aom1',
                                    anchor: '100%',
                                     value: no_conformidad.nombre_aom1,
                                    readOnly: true,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    xtype: 'field',
                                    fieldLabel: 'Area',
                                    name: 'nombre_unidad',
                                    anchor: '100%',
                                     value: no_conformidad.nombre_unidad,
                                    readOnly :true,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    xtype: 'field',
                                    fieldLabel: 'Responsable Área:',
                                    name: 'desc_funcionario_resp',
                                    anchor: '100%',
                                    value: no_conformidad.funcionario_uo,
                                    readOnly :true,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    xtype: 'field',
                                    fieldLabel: 'Área de la NC:',
                                    name: 'desc_funcionario_resp',
                                    anchor: '100%',
                                    value: no_conformidad.gerencia_uo1,
                                    readOnly :true,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    xtype: 'textarea',
                                    name: 'descrip_nc',
                                    fieldLabel: 'No conformidad',
                                    allowBlank: true,
                                    anchor: '100%',
                                    height:120,
                                    readOnly :true,
                                    value: no_conformidad.descrip_nc,
                                    style: 'background-image: none; background: #eeeeee;'
                                },
                                {
                                    xtype: 'textarea',
                                    name: 'descrip_causa_nc',
                                    fieldLabel: 'Causa de la No Conformidad',
                                    allowBlank: true,
                                    anchor: '100%',
                                    height: 60
                                },
                            ]
                        }),
                        new Ext.form.FieldSet({
                            collapsible: false,
                            border: true,
                            layout: 'form',
                            defaults: {width: 650},
                            items: [
                                {
                                    xtype: 'combo',
                                    name: 'id_parametro',
                                    fieldLabel: 'Tipo de Acción',
                                    allowBlank: false,
                                    emptyText: 'Elija una opción...',
                                    store: new Ext.data.JsonStore({
                                        url: '../../sis_auditoria/control/Parametro/listarParametro',
                                        id: 'id_parametro',
                                        root: 'datos',
                                        sortInfo: {
                                            field: 'valor_parametro',
                                            direction: 'ASC'
                                        },
                                        totalProperty: 'total',
                                        fields: ['id_parametro', 'valor_parametro', 'id_tipo_parametro'],
                                        remoteSort: true,
                                        baseParams: {par_filtro: 'prm.id_parametro#prm.valor_parametro',id_tipo_parametro:1}
                                    }),
                                    valueField: 'id_parametro',
                                    displayField: 'valor_parametro',
                                    gdisplayField: 'valor_parametro',
                                    hiddenName: 'id_parametro',
                                    mode: 'remote',
                                    triggerAction: 'all',
                                    lazyRender: true,
                                    pageSize: 15,
                                    minChars: 2,
                                    anchor: '100%',
                                },
                                {
                                    xtype: 'textarea',
                                    name: 'descripcion_ap',
                                    fieldLabel: 'Descripción',
                                    allowBlank: true,
                                    anchor: '100%',
                                    height: 60
                                },
                                {
                                    xtype: 'textarea',
                                    name: 'efectividad_cumpl_ap',
                                    fieldLabel: 'Efectividad Cumplimiento',
                                    allowBlank: true,
                                    anchor: '100%',
                                    height: 60
                                },
                                {
                                    xtype: 'datefield',
                                    anchor: '100%',
                                    name: 'fecha_inicio_ap',
                                    fieldLabel: 'Inicio',
                                    allowBlank: false,
                                    format: 'd/m/Y'
                                },
                                {
                                    xtype: 'datefield',
                                    anchor: '100%',
                                    name: 'fecha_fin_ap',
                                    fieldLabel: 'Conclusión',
                                    allowBlank: false,
                                    format: 'd/m/Y',
                                },
                            ]
                        }),
                    ]
                })],
                padding: this.paddingForm,
                bodyStyle: this.bodyStyleForm,
                border: this.borderForm,
                frame: this.frameForm,
                autoScroll: false,
                autoDestroy: true,
                autoScroll: true,
                region: 'center'
            });
           if(data){
               console.log(isForm.getForm().items.items);
               isForm.getForm().items.items[5].setValue(data.descrip_causa_nc);
               isForm.getForm().items.items[6].setValue(data.id_parametro);
               isForm.getForm().items.items[6].modificado = true;
               isForm.getForm().items.items[7].setValue(data.descripcion_ap);
               isForm.getForm().items.items[8].setValue(data.efectividad_cumpl_ap);
               isForm.getForm().items.items[9].setValue(data.fecha_inicio_ap);
               isForm.getForm().items.items[10].setValue(data.fecha_fin_ap);
           }

            this.ventanaAcciones = new Ext.Window({
                width: 670,
                height: 650,
                modal: true,
                closeAction: 'hide',
                labelAlign: 'bottom',
                title: 'Acciones Propuestas',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: [isForm],
                buttons: [{
                    text: 'Guardar',
                    handler: function () {
                        const submit={};
                        Ext.each(isForm.getForm().items.keys, function(element, index){
                            obj = Ext.getCmp(element);
                            if(obj.items){
                                Ext.each(obj.items.items, function(elm, ind){
                                    submit[elm.name]=elm.getValue();
                                },this)
                            } else {
                                submit[obj.name]=obj.getValue();
                            }
                        },this);
                        console.log(submit);
                        Phx.CP.loadingShow();
                        Ext.Ajax.request({
                            url: '../../sis_auditoria/control/AccionPropuesta/insertarAccionPropuesta',
                            params: {
                                id_ap: id_modificacion,
                                id_nc :no_conformidad.id_nc,
                                obs_resp_area : null,
                                descripcion_ap : submit.descrip_nc,
                                id_parametro : submit.id_parametro,
                                descrip_causa_nc : submit.descrip_causa_nc,
                                efectividad_cumpl_ap : submit.efectividad_cumpl_ap,
                                fecha_inicio_ap : submit.fecha_inicio_ap,
                                fecha_fin_ap : submit.fecha_fin_ap,
                                obs_auditor_consultor : null,
                                nro_tramite_padre:no_conformidad.nro_tramite
                            },
                            isUpload: false,
                            success: function(a,b,c){
                                Phx.CP.loadingHide();
                                me.ventanaAcciones.hide();
                                this.storeAcciones.load();

                            },
                            argument: this.argumentSave,
                            failure: this.conexionFailure,
                            timeout: this.timeout,
                            scope: this
                        });
                    },
                    scope: this
                }, {
                    text: 'Declinar',
                    handler: function() {
                        me.ventanaAcciones.hide();
                    },
                    scope: this
                }]
            });
        },
        onCambiarEstado:function(){
            Phx.CP.loadingShow();
            const rec = this.sm.getSelected();
            const id_estado_wf = rec.data.id_estado_wf;
            const id_proceso_wf = rec.data.id_proceso_wf;
            if(confirm(' Acciones Propuestas a Responsable')){
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/NoConformidad/aprobarEstado',
                    params:{
                        id_proceso_wf:  id_proceso_wf,
                        id_estado_wf:   id_estado_wf
                    },
                    success:this.successWizard,
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
            }else {
                Phx.CP.loadingHide();
            }
        },
        successWizard:function(){
            Phx.CP.loadingHide();
            this.reload();
        },
        onButtonAtras : function(res){
            //console.log("entra atras");
            var rec=this.sm.getSelected();
            Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/AntFormEstadoWf.php',
                'Estado de Wf',
                {
                    modal:true,
                    width:450,
                    height:250
                }, { data:rec.data, estado_destino: res.argument.estado}, this.idContenedor,'AntFormEstadoWf',
                {
                    config:[{
                        event:'beforesave',
                        delegate: this.onAntEstado
                    }
                    ],
                    scope:this
                });
        },
        onAntEstado: function(wizard,resp){
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/anteriorEstado',
                params:{
                    id_proceso_wf: resp.id_proceso_wf,
                    id_estado_wf:  resp.id_estado_wf,
                    obs: resp.obs,
                    estado_destino: resp.estado_destino
                },
                argument:{wizard:wizard},
                success:this.successEstadoSinc,
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
        },
        successEstadoSinc:function(resp){
            Phx.CP.loadingHide();
            resp.argument.wizard.panel.destroy();
            this.reload();
        },
        south: {
                url:'../../../sis_auditoria/vista/accion_propuesta/AccionePropuestaNoConformidad.php',
                title:'Acciones Propuestas',
                height:'50%',
                cls:'AccionePropuestaNoConformidad'
        },
        arrayDefaultColumHidden:['nombre_aom1','nombre_unidad','desc_funcionario_resp','nro_tramite','descrip_nc'],
        rowExpander: new Ext.ux.grid.RowExpander({
            tpl : new Ext.Template(
                '<br>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Nombre Auditoria:&nbsp;&nbsp;</b> {nombre_aom1}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Area:&nbsp;&nbsp;</b> {nombre_unidad}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Responsable Auditoria:&nbsp;&nbsp;</b> {desc_funcionario_resp}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Codigo:&nbsp;&nbsp;</b> {nro_tramite}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Descripcion:&nbsp;&nbsp;</b> {descrip_nc}</p>',
            )
        }),
	    cmbTipoAuditoria: new Ext.form.ComboBox({
			name:'tipoauditoria',
			fieldLabel: 'Tipo de Auditoria',
			allowBlank: false,
			emptyText:'Tipo de Auditoria...',
			blankText: 'Tipo de auditoria',
			store:new Ext.data.JsonStore(
				{
					url: '../../sis_auditoria/control/TipoAuditoria/listarTipoAuditoria',
					id: 'id_tipo_auditoria',
					root: 'datos',
					sortInfo:{
						field: 'id_tipo_auditoria',
						direction: 'DESC'
					},
					totalProperty: 'total',
					fields: ['id_tipo_auditoria','tipo_auditoria','id_uo','nombre_unidad','' ],
					//fields: ['id_aom','nombre_aom2','gerencia_uo'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'tipo_auditoria'}
				}),
			valueField: 'id_tipo_auditoria',
			triggerAction: 'all',
			displayField: 'tipo_auditoria',
			hiddenName: 'id_tipo_auditoria',
			mode:'remote',
			pageSize:50,
			queryDelay:500,
			listWidth:'280',
			width:200
		}),
        cmbAuditorias: new Ext.form.ComboBox({
                fieldLabel: 'Auditoria u Oportunidad de mejora',
                allowBlank: false,
                emptyText:'Auditoria u Oportunidad de mejora...',
                blankText: 'Auditorias',
                store:new Ext.data.JsonStore(
                    {
                        url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarAuditoriaOportunidadMejora',
                        id: 'id_aom',
                        root: 'datos',
                        sortInfo:{
                            field: 'nombre_aom1',
                            direction: 'DESC'
                        },
                        totalProperty: 'total',
                        fields: ['id_aom','nombre_aom1','id_uo','nombre_unidad','' ],
                        remoteSort: true,
                        baseParams:{par_filtro:'nombre_aom1'}
                    }),
                valueField: 'id_aom',
                triggerAction: 'all',
                displayField: 'nombre_aom1',
                hiddenName: 'id_aom',
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                width:200
            }),
    };
	
</script>
