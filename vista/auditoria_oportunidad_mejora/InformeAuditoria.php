<?php
/**
 * @package pXP
 * @file InformeAuditoria.php
 * @author  Maximilimiano Camacho
 * @date 24-07-2019
 * @description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.InformeAuditoria = {
        bedit: true,
        bnew: false,
        bsave: false,
        bdel: false,
        bodyStyleForm: 'padding:5px;',
        borderForm: true,
        frameForm: false,
        paddingForm: '5 5 5 5',
        require: '../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase: 'Phx.vista.AuditoriaOportunidadMejora',
        title: 'AuditoriaOportunidadMejora',
        nombreVista: 'InformeAuditoria',
        storePunto: {},
        tienda: {},
        punto: {},
        id_no_conformidad: null,
        id_proceso_no_conformidad: null,
        constructor: function (config) {
            this.Atributos[this.getIndAtributo('id_tipo_om')].grid = false;
            this.Atributos[this.getIndAtributo('fecha_eje_inicio')].grid = false;
            this.Atributos[this.getIndAtributo('fecha_eje_fin')].grid = false;
            this.idContenedor = config.idContenedor;
            Phx.vista.InformeAuditoria.superclass.constructor.call(this, config);
            this.getBoton('sig_estado').setVisible(false);
            this.getBoton('btnChequeoDocumentosWf').setVisible(false);
            this.recomendacionForm();
            this.store.baseParams.interfaz = this.nombreVista;
            this.init();
            this.addButton('notifcar_respo', {
                text: 'Notificar',
                grupo: [0],
                iconCls: 'bok',
                disabled: true,
                handler: this.sigEstado,
                tooltip: '<b>Pasar al Siguiente Estado</b>'
            });
            this.addButton('btnCerrarInforme', {
                text: 'Cerrar Informe',
                iconCls: 'block',
                disabled: true,
                handler: this.onCerrarAuditoria,
                tooltip: '<b>Cerrar</b> Cerrar auditoria'
            });
            this.load({params: {start: 0, limit: this.tam_pag}});
        },
        EnableSelect: function () {
            Phx.vista.InformeAuditoria.superclass.EnableSelect.call(this);
        },
        onButtonEdit: function () {
            this.onCrearFormulario();
            this.abrirVentana('edit');
        },
        abrirVentana: function (tipo) {
            if (tipo === 'edit') {
                this.cargaFormulario(this.sm.getSelected().data);
            }
            this.formularioVentana.show();
        },
        onCrearFormulario: function () {
            // Phx.CP.loadingShow();
            const me = this;
            const maestro = this.sm.getSelected().data;
            this.tienda = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/NoConformidad/listarNoConformidad',
                id: 'id_nc',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_aom', 'id_nc', 'valor_parametro', 'estado_wf', 'descrip_nc',
                    'calidad',
                    'medio_ambiente',
                    'seguridad',
                    'responsabilidad_social',
                    'sistemas_integrados',
                    'obs_resp_area',
                    'obs_consultor',
                    'evidencia',
                    'id_parametro',
                    'id_pnnc',
                    'id_proceso_wf',
                    'id_estado_wf',
                    'nro_tramite'
                ],
                remoteSort: true,
                baseParams: {dir: 'ASC', sort: 'id_nc', limit: '100', start: '0'}
            });
            this.tienda.baseParams.id_aom = maestro.id_aom;
            this.tienda.load();
            const noConformidad = new Ext.grid.GridPanel({
                store: this.tienda,
                layout: 'fit',
                region: 'center',
                anchor: '100%',
                split: true,
                border: false,
                plain: true,
                stripeRows: true,
                trackMouseOver: false,
                loadMask: true,
                tbar: [
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'a',
                            html: 'Crear nueva No Conformidad'
                        },
                        style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                        listeners: {
                            render: function (component) {
                                component.getEl().on('click', function (e) {
                                    me.formularioNoConformidad(null);
                                    me.ventanaNoConformidad.show();
                                });
                            }
                        }
                    }
                ],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Tipo',
                        dataIndex: 'valor_parametro',
                        align: 'center',
                        width: 100,
                        renderer: function (value, p, record) {
                            return String.format('<div class="gridmultiline" style=" font-size: 12px; ">{0}</div>', record.data['valor_parametro']);
                        }
                    },
                    {
                        header: 'Descripcion',
                        dataIndex: 'descrip_nc',
                        align: 'justify',
                        width: 400,
                        renderer: function (value, p, record) {
                            return String.format('<div class="gridmultiline" style=" font-size: 12px; "><a>{0}</a></div>', record.data['descrip_nc']);
                        }
                    },
                    {
                        xtype: 'actioncolumn',
                        width: 50,
                        items: [{
                            icon: '../../../pxp/lib/ux/images/delete.gif',  // ../../../pxp/lib/ux/images/
                            tooltip: 'Sell stock',
                            handler: function (grid, rowIndex, colIndex) {
                                const rec = me.tienda.getAt(rowIndex);
                                Phx.CP.loadingShow();
                                Ext.Ajax.request({
                                    url: '../../sis_auditoria/control/NoConformidad/eliminarNoConformidad',
                                    params: {
                                        id_nc: rec.get('id_nc')
                                    },
                                    isUpload: false,
                                    success: function (a, b, c) {
                                        Phx.CP.loadingHide();
                                        me.tienda.load();
                                    },
                                    argument: this.argumentSave,
                                    failure: this.conexionFailure,
                                    timeout: this.timeout,
                                    scope: this
                                });
                            }
                        }
                        ]
                    },
                    {
                        header: 'Estado',
                        dataIndex: 'estado_wf',
                        align: 'center',
                        width: 150,
                        renderer: function (value, p, record) {
                            return String.format('<div class="gridmultiline" style=" font-size: 12px; ">{0}</div>', record.data['estado_wf']);
                        }
                    }
                ]
            });
            noConformidad.addListener('cellclick', this.oncellclickNc, this);
            this.form = new Ext.form.FormPanel({
                items: [{
                    region: 'center',
                    layout: 'column',
                    border: false,
                    autoScroll: true,
                    items: [{
                        xtype: 'tabpanel',
                        plain: true,
                        activeTab: 0,
                        height: 615,
                        width: 620,
                        enableTabScroll: true,
                        defaults: {border: 0},
                        items: [{
                            title: 'Datos Principales',
                            labelAlign: 'top',
                            frame: true,
                            // layout: 'fit',
                            bodyStyle: 'padding:5px 5px 0',
                            width: 650,
                            items: [{
                                layout: 'column',
                                items: [{
                                    columnWidth: .5,
                                    layout: 'form',
                                    items: [{
                                        xtype: 'field',
                                        name: 'nro_tramite',
                                        fieldLabel: 'Codigo',
                                        anchor: '98%',
                                        readOnly: true,
                                        style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',

                                    }]
                                },
                                    {
                                        columnWidth: .5,
                                        layout: 'form',
                                        items: [{
                                            xtype: 'field',
                                            name: 'nombre_estado',
                                            fieldLabel: 'Estado',
                                            anchor: '98%',
                                            readOnly: true,
                                            style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                        }]
                                    }
                                ]
                            },
                                {
                                    layout: 'form',
                                    items: [
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Area',
                                            name: 'nombre_unidad',
                                            anchor: '98%',
                                            readOnly: true,
                                            style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Nombre',
                                            name: 'nombre_aom1',
                                            anchor: '98%',
                                            readOnly: true,
                                            style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                        }
                                    ]
                                },
                                {
                                    layout: 'column',
                                    items: [{
                                        columnWidth: .5,
                                        layout: 'form',
                                        items: [
                                            {
                                                xtype: 'combo',
                                                fieldLabel: 'Tipo de Auditoria',
                                                name: 'id_tnorma',
                                                allowBlank: true,
                                                emptyText: 'Elija una opción...',
                                                store: new Ext.data.JsonStore({
                                                    url: '../../sis_auditoria/control/Parametro/listarParametro',
                                                    id: 'id_parametro',
                                                    root: 'datos',
                                                    fields: ['id_parametro', 'tipo_parametro', 'valor_parametro'],
                                                    totalProperty: 'total',
                                                    sortInfo: {
                                                        field: 'valor_parametro',
                                                        direction: 'ASC'
                                                    },
                                                    baseParams: {
                                                        tipo_parametro: 'TIPO_NORMA',
                                                        par_filtro: 'prm.id_tipo_parametro'
                                                    }
                                                }),
                                                valueField: 'id_parametro',
                                                displayField: 'valor_parametro',
                                                gdisplayField: 'desc_tipo_norma',
                                                hiddenName: 'id_parametro',
                                                mode: 'remote',
                                                triggerAction: 'all',
                                                lazyRender: true,
                                                pageSize: 15,
                                                minChars: 2,
                                                readOnly: true,
                                                anchor: '98%',
                                                style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                            },
                                            {
                                                xtype: 'combo',
                                                fieldLabel: 'Objeto Auditoria',
                                                name: 'id_tobjeto',
                                                allowBlank: true,
                                                emptyText: 'Elija una opción...',
                                                store: new Ext.data.JsonStore({
                                                    url: '../../sis_auditoria/control/Parametro/listarParametro',
                                                    id: 'id_parametro',
                                                    root: 'datos',
                                                    fields: ['id_parametro', 'tipo_parametro', 'valor_parametro'],
                                                    totalProperty: 'total',
                                                    sortInfo: {
                                                        field: 'valor_parametro',
                                                        direction: 'ASC'
                                                    },
                                                    baseParams: {
                                                        tipo_parametro: 'OBJETO_AUDITORIA',
                                                        par_filtro: 'prm.id_parametro'
                                                    }
                                                }),
                                                valueField: 'id_parametro',
                                                displayField: 'valor_parametro',
                                                gdisplayField: 'desc_tipo_objeto',
                                                mode: 'remote',
                                                triggerAction: 'all',
                                                lazyRender: true,
                                                pageSize: 15,
                                                minChars: 2,
                                                readOnly: true,
                                                anchor: '98%',
                                                style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                            }
                                        ]
                                    },
                                        {
                                            columnWidth: .5,
                                            layout: 'form',
                                            items: [
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Inicio Real',
                                                    name: 'fecha_prog_inicio',
                                                    disabled: false,
                                                    readOnly: true,
                                                    anchor: '98%',
                                                    style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                                },
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Fin Real',
                                                    name: 'fecha_prog_fin',
                                                    disabled: false,
                                                    readOnly: true,
                                                    anchor: '98%',
                                                    style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    layout: 'form',
                                    items: [
                                        {
                                            xtype: 'combo',
                                            name: 'id_funcionario',
                                            fieldLabel: 'Auditor Reponsable',
                                            allowBlank: true,
                                            emptyText: 'Elija una opción...',
                                            store: new Ext.data.JsonStore({
                                                url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListFuncionario',
                                                id: 'id_funcionario',
                                                root: 'datos',
                                                sortInfo: {
                                                    field: 'desc_funcionario1',
                                                    direction: 'ASC'
                                                },
                                                totalProperty: 'total',
                                                fields: ['id_funcionario', 'desc_funcionario1', 'descripcion_cargo', 'cargo_equipo'],
                                                remoteSort: true,
                                                baseParams: {par_filtro: 'fu.desc_funcionario1'}
                                            }),
                                            valueField: 'id_funcionario',
                                            displayField: 'desc_funcionario1',
                                            gdisplayField: 'desc_funcionario2',
                                            hiddenName: 'id_funcionario',
                                            mode: 'remote',
                                            anchor: '98%',
                                            triggerAction: 'all',
                                            lazyRender: true,
                                            pageSize: 15,
                                            minChars: 2,
                                            readOnly: true,
                                            style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                        },
                                        {
                                            xtype: 'combo',
                                            name: 'id_destinatario',
                                            fieldLabel: 'Destinatario',
                                            allowBlank: false,
                                            emptyText: 'Elija una opción...',
                                            store: new Ext.data.JsonStore({
                                                url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarFuncionarioVigentes',
                                                id: 'id_funcionario',
                                                root: 'datos',
                                                sortInfo: {
                                                    field: 'desc_funcionario1',
                                                    direction: 'ASC'
                                                },
                                                totalProperty: 'total',
                                                fields: ['id_funcionario', 'desc_funcionario1', 'descripcion_cargo'],
                                                remoteSort: true,
                                                baseParams: {par_filtro: 'fc.desc_funcionario1'}
                                            }),
                                            valueField: 'id_funcionario',
                                            displayField: 'desc_funcionario1',
                                            gdisplayField: 'desc_funcionario_destinatario',
                                            hiddenName: 'id_destinatario',
                                            mode: 'remote',
                                            anchor: '98%',
                                            triggerAction: 'all',
                                            lazyRender: true,
                                            pageSize: 15,
                                            minChars: 2,
                                        },
                                        {
                                            anchor: '98%',
                                            bodyStyle: 'padding:10px;',
                                            title: 'Destinatarios Adicionales',
                                            items: [{
                                                xtype: 'itemselector',
                                                name: 'id_destinatarios',
                                                fieldLabel: 'Destinatarios',
                                                imagePath: '../../../pxp/lib/ux/images/',
                                                drawUpIcon: false,
                                                drawDownIcon: false,
                                                drawTopIcon: false,
                                                drawBotIcon: false,
                                                multiselects: [{
                                                    width: 280,
                                                    height: 175,
                                                    store: new Ext.data.JsonStore({
                                                        url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarFuncionarioVigentes',
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
                                                            dir: 'ASC',
                                                            sort: 'id_funcionario',
                                                            limit: '100',
                                                            start: '0'
                                                        }
                                                    }),
                                                    tbar: {
                                                        xtype: 'toolbar',
                                                        flex: 1,
                                                        dock: 'top',
                                                        items: [
                                                            'Filtro:',
                                                            {
                                                                xtype: 'textfield',
                                                                fieldStyle: 'text-align: left;',
                                                                enableKeyEvents: true,
                                                                listeners: {
                                                                    scope: this,
                                                                    specialkey: function (field, e) {
                                                                        if (e.getKey() === e.ENTER) {
                                                                            if (String(field).trim() !== '') {
                                                                                this.form.getForm().findField('id_destinatarios').multiselects[0].store.baseParams = {
                                                                                    desc_funcionario1: field.getValue(),
                                                                                    dir: 'ASC',
                                                                                    sort: 'id_funcionario',
                                                                                    limit: '100',
                                                                                    start: '0'
                                                                                };
                                                                                this.form.getForm().findField('id_destinatarios').multiselects[0].store.load();
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        ]
                                                    },
                                                    displayField: 'desc_funcionario1',
                                                    valueField: 'id_funcionario',
                                                },
                                                    {
                                                        width: 280,
                                                        height: 175,
                                                        store: new Ext.data.JsonStore({
                                                            url: '../../sis_auditoria/control/Destinatario/listarDestinatario',
                                                            id: 'id_funcionario',
                                                            root: 'datos',
                                                            totalProperty: 'total',
                                                            fields: ['id_funcionario', 'desc_funcionario1'],
                                                            remoteSort: true,
                                                            autoLoad: true,
                                                            baseParams: {
                                                                dir: 'ASC',
                                                                sort: 'id_aom',
                                                                limit: '100',
                                                                start: '0',
                                                                id_aom: maestro.id_aom,
                                                            }
                                                        }),
                                                        tbar: [
                                                            {
                                                                text: 'Todo',
                                                                handler: function () {
                                                                    const toStore = isForm.getForm().findField('id_proceso').multiselects[0].store;
                                                                    const fromStore = isForm.getForm().findField('id_proceso').multiselects[1].store;
                                                                    for (var i = toStore.getCount() - 1; i >= 0; i--) {
                                                                        const record = toStore.getAt(i);
                                                                        toStore.remove(record);
                                                                        fromStore.add(record);
                                                                    }
                                                                }
                                                            },
                                                            {
                                                                text: 'Limpiar',
                                                                handler: function () {
                                                                    isForm.getForm().findField('id_proceso').reset();
                                                                }
                                                            }],
                                                        displayField: 'desc_funcionario1',
                                                        valueField: 'id_funcionario',
                                                    }]
                                            }]
                                        },
                                    ]
                                }
                            ]
                        },
                            {
                                title: 'Resumen (4-R-27)',
                                layout: 'column',
                                defaults: {width: 600},
                                autoScroll: true,
                                defaultType: 'textfield',
                                items: [
                                    {
                                        xtype: 'htmleditor',
                                        name: 'resumen',
                                        width: 600,
                                        height: 459,

                                    },
                                ]
                            },
                            {
                                title: 'Recomendaciones',
                                layout: 'column',
                                defaults: {width: 600},
                                autoScroll: true,
                                defaultType: 'textfield',
                                items: [
                                    {
                                        xtype: 'textarea',
                                        name: 'recomendacion',
                                        width: 600,
                                        height: 459,
                                    },
                                ]
                            },
                            {
                                title: 'No Conformidades (4-R-10)',
                                layout: 'fit',
                                region: 'center',
                                items: [
                                    noConformidad // ALison
                                ]
                            }
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
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/listarRespAreaGerente',
                params: {
                    id_uo: maestro.id_uo
                },
                success: function (resp) {
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    this.form.getForm().findField('id_destinatario').setValue(reg.ROOT.datos.id_funcionario);
                    this.form.getForm().findField('id_destinatario').setRawValue(reg.ROOT.datos.desc_funcionario);
                    Phx.CP.loadingHide();
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
            this.formularioVentana = new Ext.Window({
                width: 640,
                height: 700,
                modal: false,
                autoScroll: true,
                closeAction: 'hide',
                labelAlign: 'top',
                title: 'Informe Auditoria',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: this.form,
                buttons: [{
                    text: 'Guardar',
                    handler: this.onSubmit,
                    scope: this
                }, {
                    text: 'Declinar',
                    handler: function () {
                        this.formularioVentana.hide();
                    },
                    scope: this
                }]
            });
        },
        onSubmit: function () {
            const arratFormulario = [];
            const submit = {};
            Ext.each(this.form.getForm().items.keys, function (element, index) {
                obj = Ext.getCmp(element);
                if (obj.items) {
                    Ext.each(obj.items.items, function (elm, ind) {
                        submit[elm.name] = elm.getValue();
                    }, this)
                } else {
                    submit[obj.name] = obj.getValue();
                    if (obj.name == 'id_tnorma' || obj.name == 'id_tobjeto') {
                        if (obj.selectedIndex != -1) {
                            submit[obj.name] = obj.store.getAt(obj.selectedIndex).id;
                        }
                    }
                }
            }, this);
            const {id_destinatario, id_destinatarios, recomendacion, resumen} = submit;
            const v3g = {id_destinatario, id_destinatarios, recomendacion};
            arratFormulario.push(v3g);
            const maestro = this.sm.getSelected().data;

            if (this.form.getForm().isValid()) {
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/planifiacionAuditoria',
                    params: {
                        id_aom: maestro.id_aom,
                        arratFormulario: JSON.stringify(arratFormulario),
                        resumen: resumen,
                        recomendacion: recomendacion,
                        informe: 'si'
                    },
                    isUpload: false,
                    success: function (a, b, c) {
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
        cargaFormulario: function (data) {
            let obj;
            Ext.each(this.form.getForm().items.keys, function (element, index) {
                obj = Ext.getCmp(element);
                if (obj) {
                    if (obj.name !== 'area') {
                        if (obj.name !== 'auditor_respo') {
                            if ((obj.getXType() === 'combo' && obj.mode === 'remote' && obj.store !== undefined) || obj.name === 'id_parametro') {
                                if (!obj.store.getById(data[obj.name])) {
                                    rec = new Ext.data.Record({
                                        [obj.displayField]: data[obj.gdisplayField],
                                        [obj.valueField]: data[obj.name]
                                    }, data[obj.name]);
                                    obj.store.add(rec);
                                    obj.store.commitChanges();
                                    obj.modificado = true;
                                }

                            }
                            obj.setValue(data[obj.name]);
                        }
                    }

                }
            }, this);
        },
        preparaMenu: function (n) {
            const tb = this.tbar;
            const data = this.sm.getSelected().data;

            Phx.vista.InformeAuditoria.superclass.preparaMenu.call(this, n);
            this.getBoton('notifcar_respo').disable();
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('ant_estado').disable();
            this.getBoton('btnCerrarInforme').disable();
            if (data['estado_wf'] === 'ejecutada') {
                this.getBoton('notifcar_respo').enable();
                this.getBoton('ant_estado').enable();
            }
            if (data['estado_wf'] === 'aceptado_resp') {
                this.getBoton('btnCerrarInforme').enable();
            }
            return tb
        },
        liberaMenu: function () {
            const tb = Phx.vista.InformeAuditoria.superclass.liberaMenu.call(this);
            if (tb) {
                this.getBoton('notifcar_respo').disable();
                this.getBoton('diagrama_gantt').disable();
                this.getBoton('ant_estado').disable();
                this.getBoton('btnCerrarInforme').disable();
            }
            return tb
        },
        onReporte: function () {
            var rec = this.sm.getSelected();
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/reporteResumen',
                params: {'id_aom': rec.data.id_aom},
                success: this.successExport,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        onRecomendacion: function () {
            var data = this.getSelectedData();
            if (data) {
                this.cmpRecomendacion.setValue(data.recomendacion);
                this.ventanaRecomendacion.show();
            }
        },
        recomendacionForm: function () {
            var recomendacion = new Ext.form.TextArea({
                name: 'recomendacion',
                msgTarget: 'title',
                fieldLabel: 'Recomendacion',
                allowBlank: true,
                width: 400,
                height: 100
            });
            this.formRecomendacion = new Ext.form.FormPanel({
                baseCls: 'x-plain',
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                items: [recomendacion]
            });
            this.ventanaRecomendacion = new Ext.Window({
                title: 'Recomendacion de Auditoria',
                collapsible: true,
                maximizable: true,
                autoDestroy: true,
                width: 550,
                height: 200,
                layout: 'fit',
                plain: true,
                bodyStyle: 'padding:5px;',
                buttonAlign: 'center',
                items: this.formRecomendacion,
                modal: true,
                closeAction: 'hide',
                buttons: [{
                    text: 'Guardar',
                    handler: this.saveRecomendacion,
                    scope: this
                },
                    {
                        text: 'Cancelar',
                        handler: function () {
                            this.ventanaRecomendacion.hide()
                        },
                        scope: this
                    }]
            });
            this.cmpRecomendacion = this.formRecomendacion.getForm().findField('recomendacion');
        },
        saveRecomendacion: function () {
            var d = this.getSelectedData();
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/insertSummary',
                params: {
                    id_aom: d.id_aom,
                    recomendacion: this.cmpRecomendacion.getValue()
                },
                success: this.successSincExtra,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        successSincExtra: function (resp) {
            Phx.CP.loadingHide();
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            if (!reg.ROOT.error) {
                if (this.ventanaRecomendacion) {
                    this.ventanaRecomendacion.hide();
                }
                this.load({params: {start: 0, limit: this.tam_pag}});
            } else {
                alert('ocurrio un error durante el proceso')
            }
        },
        onNoConformidades: function () {
            var rec = this.sm.getSelected();
            Phx.CP.loadWindows('../../../sis_auditoria/vista/no_conformidad/NoConformidadGestion.php', 'Gestion No conformidades', {
                //modal : true,
                width: '90%',
                height: '90%'
            }, rec.data, this.idContenedor, 'NoConformidadGestion');
        },
        onReloadPage: function (m) {
            this.maestro = m;
            console.log('=22222>', this);
            this.store.baseParams = {
                id_gestion: this.maestro.id_gestion,
                desde: this.maestro.desde,
                hasta: this.maestro.hasta,
                start: 0,
                limit: 50,
                sort: 'id_aom',
                dir: 'DESC',
                interfaz: this.nombreVista,
                contenedor: this.idContenedor
            };
            this.store.reload({params: this.store.baseParams});
        },
        formularioNoConformidad: function (data) {
            const maestro = this.sm.getSelected().data;
            const me = this;
            let evento = 'NEW';
            let id_modificacion = null;
            if (data) {
                evento = 'EDIT';
                id_modificacion = data.id_nc
            }

            this.punto = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/PnormaNoconformidad/listarPnormaNoconformidad',
                id: 'id_pnnc',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_pnnc', 'id_nc', 'id_pn', 'id_norma', 'nombre_pn', 'desc_norma', 'nombre_pn', 'sigla_norma', 'codigo_pn', 'nombre_descrip'],
                remoteSort: true,
                baseParams: {dir: 'ASC', sort: 'id_pnnc', limit: '100', start: '0'}
            });
            if (data) {
                this.punto.baseParams.id_nc = data ? data.id_nc : this.id_no_conformidad;
                this.punto.load();
            }
            this.documentos = new Ext.data.JsonStore({
                url: '../../sis_workflow/control/DocumentoWf/listarDocumentoWf',
                id: 'id_documento_wf',
                root: 'datos',
                totalProperty: 'total',
                fields: [
                    {name: 'id_documento_wf', type: 'numeric'},
                    {name: 'url', type: 'string'},
                    {name: 'num_tramite', type: 'string'},
                    {name: 'id_tipo_documento', type: 'numeric'},
                    {name: 'obs', type: 'string'},
                    {name: 'id_proceso_wf', type: 'numeric'},
                    {name: 'extension', type: 'string'},
                    {name: 'chequeado', type: 'string'},
                    {name: 'estado_reg', type: 'string'},
                    {name: 'nombre_tipo_doc', type: 'string'},
                    {name: 'nombre_doc', type: 'string'},
                    {name: 'momento', type: 'string'},
                    {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                    {name: 'id_usuario_reg', type: 'numeric'},
                    {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                    {name: 'id_usuario_mod', type: 'numeric'},
                    {name: 'priorizacion', type: 'numeric'},
                    {name: 'usr_reg', type: 'string'},
                    {name: 'usr_mod', type: 'string'},
                    'codigo_tipo_proceso',
                    'codigo_tipo_documento',
                    'nombre_tipo_documento',
                    'descripcion_tipo_documento',
                    'nro_tramite',
                    'codigo_proceso',
                    'descripcion_proceso_wf',
                    'nombre_estado',
                    'chequeado_fisico',
                    'usr_upload',
                    'tipo_documento',
                    'action', 'solo_lectura', 'id_documento_wf_ori', 'id_proceso_wf_ori', 'nro_tramite_ori',
                    {
                        name: 'fecha_upload',
                        type: 'date',
                        dateFormat: 'Y-m-d H:i:s.u'
                    }, 'modificar', 'insertar', 'eliminar', 'demanda',
                    'nombre_vista', 'esquema_vista', 'nombre_archivo_plantilla'
                ],
                remoteSort: true,
                baseParams: {dir: 'ASC', sort: 'id_documento_wf', limit: '100', start: '0'}
            });

            if (data) {
                this.documentos.baseParams.modoConsulta = 'no';
                this.documentos.baseParams.todos_documentos = 'no';
                this.documentos.baseParams.anulados = 'no';
                this.documentos.baseParams.id_proceso_wf = data.id_proceso_wf;
                this.documentos.load({params: {start: 0, limit: 50}});
            }
            const table = new Ext.grid.GridPanel({
                store: this.punto,
                height: 200,
                layout: 'fit',
                region: 'center',
                anchor: '100%',
                split: true,
                border: true,
                plain: true,
                stripeRows: true,
                trackMouseOver: false,
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Norma',
                        dataIndex: 'id_norma',
                        width: 180,
                        sortable: false,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['sigla_norma'])
                        },
                    },
                    {
                        header: 'Codigo',
                        dataIndex: 'codigo_pn',
                        width: 80,
                        sortable: false,
                    },
                    {
                        header: 'Punto de Norma',
                        dataIndex: 'id_pn',
                        width: 270,
                        sortable: false,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['nombre_pn'])
                        },
                    },
                ],
                tbar: [
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'a',
                            html: 'Asignar/Designar Punto de Norma'
                        },
                        style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                        listeners: {
                            render: function (component) {
                                component.getEl().on('click', function (e) {
                                    console.log(data)
                                    console.log(me.id_no_conformidad)
                                    if (me.id_no_conformidad !== null || data) {
                                        me.formularioPuntoNorma(data);
                                        me.ventanaPuntoNorma.show();
                                    } else {
                                        alert('Tiene que registrar la no conformidad')
                                    }
                                });
                            }
                        }
                    }
                ]
            });
            const grilla = new Ext.grid.GridPanel({
                layout: 'fit',
                store: this.documentos,
                region: 'center',
                trackMouseOver: false,
                split: true,
                border: false,
                plain: true,
                stripeRows: true,
                loadMask: true,
                tbar: [
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'a',
                            html: 'Nuevo'
                        },
                        style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                        listeners: {
                            render: function (component) {
                                component.getEl().on('click', function (e) {
                                    if (me.id_no_conformidad !== null || data) {
                                        me.onFormularioDocumento(data);
                                    } else {
                                        alert('Tiene que registrar la no conformidad')
                                    }
                                });
                            }
                        }
                    },
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'a',
                            html: 'Eliminar'
                        },
                        style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                        listeners: {
                            render: function (component) {
                                component.getEl().on('click', function (e) {
                                    const record = grilla.getSelectionModel().getSelections();
                                    Phx.CP.loadingShow();
                                    Ext.Ajax.request({
                                        url: '../../sis_workflow/control/DocumentoWf/eliminarDocumentoWf',
                                        params: {
                                            id_documento_wf: record[0].data.id_documento_wf
                                        },
                                        isUpload: false,
                                        success: function (a, b, c) {
                                            Phx.CP.loadingHide();
                                            me.documentos.load({params: {start: 0, limit: 50}});
                                        },
                                        argument: me.argumentSave,
                                        failure: me.conexionFailure,
                                        timeout: me.timeout,
                                        scope: me
                                    })
                                });
                            }
                        }
                    }
                    /*{
                    text: '<button class="btn">&nbsp;&nbsp;<b>Nuevo</b></button>',
                    scope: this,
                    width: '100',
                    handler: function() {

                    }
                },
                {
                    text: '<button class="btn">&nbsp;&nbsp;<b>Eliminar</b></button>',
                    scope: this,
                    width: '100',
                    handler: function() {

                    }
                }*/
                ],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Doc. Digital',
                        dataIndex: 'chequeado',
                        width: 100,
                        sortable: false,
                        renderer: function (value, p, record, rowIndex, colIndex) {

                            if (record.data['chequeado'] == 'si') {
                                return "<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Abrir Documento' src = '../../../lib/imagenes/icono_awesome/awe_print_good.png' align='center' width='30' height='30'></div>";
                            } else if (record.data.nombre_vista) {
                                return "<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Generar Plantilla' src = '../../../lib/imagenes/icono_awesome/awe_template.png' align='center' width='30' height='30'></div>";
                            } else if (record.data['action'] != '') {
                                return "<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Vista Previa Documento Generado' src = '../../../lib/imagenes/icono_awesome/awe_print_good.png' align='center' width='30' height='30'></div>";
                            } else {
                                return String.format('{0}', "<div style='text-align:center'><img title='Documento No Escaneado' src = '../../../lib/imagenes/icono_awesome/awe_wrong.png' align='center' width='30' height='30'/></div>");
                            }
                        },
                    },
                    {
                        header: 'Subir',
                        dataIndex: 'upload',
                        width: 100,
                        sortable: false,
                        renderer: function (value, p, record) {
                            if (record.data['solo_lectura'] == 'no' && !record.data['id_proceso_wf_ori']) {
                                if (record.data['extension'].length != 0) {
                                    return String.format('{0}', "<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Reemplazar Archivo' src = '../../../lib/imagenes/icono_awesome/awe_upload.png' align='center' width='30' height='30'></div>");
                                } else {
                                    return String.format('{0}', "<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Subir Archivo' src = '../../../lib/imagenes/icono_awesome/awe_upload.png' align='center' width='30' height='30'></div>");
                                }
                            }
                        }
                    },
                    {
                        header: 'Nombre Doc.',
                        dataIndex: 'nombre_tipo_documento',
                        width: 100,
                        sortable: false,
                        renderer: function (value, p, record) {
                            if (record.data.priorizacion == 0 || record.data.priorizacion == 9) {
                                return String.format('<b><font color="red">{0}***</font></b>', value);
                            } else {
                                return String.format('{0}', value);
                            }
                        }
                    },
                    {
                        header: 'Descripcion Proceso',
                        dataIndex: 'descripcion_proceso_wf',
                        width: 200,
                        sortable: false,
                        renderer: function (value, p, record) {
                            if (record.data.demanda == 'si') {
                                return String.format('<b><font color="green">{0}</font></b>', value);
                            } else {
                                return String.format('{0}', value);
                            }
                        }
                    },
                    {
                        header: 'Estado Reg.',
                        dataIndex: 'estado_reg',
                        width: 100,
                        sortable: false
                    },

                ]
            });
            const isForm = new Ext.form.FormPanel({
                items: [{
                    region: 'center',
                    layout: 'column',
                    border: false,
                    autoScroll: true,
                    defaults: {
                        //  bodyStyle: 'padding:10'
                    },
                    items: [{
                        xtype: 'tabpanel',
                        plain: true,
                        activeTab: 0,
                        height: 620,
                        deferredRender: false,
                        items: [{
                            title: 'No Conformidad',
                            layout: 'form',
                            defaults: {width: 600},
                            autoScroll: false,
                            frame: true,

                            defaultType: 'textfield',
                            items: [
                                new Ext.form.FieldSet({
                                    collapsible: false,
                                    border: false,
                                    items: [
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Código Auditoria',
                                            name: 'nro_tramite_wf',
                                            anchor: '100%',
                                            value: maestro.nro_tramite,
                                            readOnly: true,
                                            style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Nombre Auditoria',
                                            name: 'nombre_aom1',
                                            anchor: '100%',
                                            value: maestro.nombre_aom1,
                                            readOnly: true,
                                            style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                                        },
                                        {
                                            xtype: 'combo',
                                            name: 'id_uo',
                                            fieldLabel: 'Area',
                                            allowBlank: false,
                                            resizable: true,
                                            emptyText: 'Elija una opción...',
                                            store: new Ext.data.JsonStore({
                                                url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListUO',
                                                id: 'id_uo',
                                                root: 'datos',
                                                sortInfo: {
                                                    field: 'nombre_unidad',
                                                    direction: 'ASC'
                                                },
                                                totalProperty: 'total',
                                                fields: ['id_uo', 'nombre_unidad', 'codigo', 'nivel_organizacional'],
                                                remoteSort: true,
                                                baseParams: {par_filtro: 'nombre_unidad'}
                                            }),
                                            valueField: 'id_uo', //modificado
                                            displayField: 'nombre_unidad',
                                            gdisplayField: 'nombre_unidad',
                                            hiddenName: 'id_uo',
                                            mode: 'remote',
                                            triggerAction: 'all',
                                            lazyRender: true,
                                            pageSize: 15,
                                            minChars: 2,
                                            anchor: '100%'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Resp. Area de NC',
                                            name: 'id_funcionario',
                                            anchor: '100%',
                                            readOnly: true,
                                            style: 'background-image: none; background: #eeeeee;'
                                        },
                                        {
                                            xtype: 'combo',
                                            name: 'id_parametro',
                                            fieldLabel: '*Tipo',
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
                                                baseParams: {
                                                    par_filtro: 'prm.id_parametro#prm.valor_parametro',
                                                    tipo_no: 'TIPO_NO_CONFORMIDAD'
                                                }
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
                                        new Ext.form.FieldSet({
                                            collapsible: false,
                                            layout: "column",
                                            border: false,
                                            defaults: {
                                                flex: 1
                                            },
                                            items: [
                                                new Ext.form.Label({
                                                    text: 'Calidad :',
                                                    style: 'margin: 5px'
                                                }),
                                                {
                                                    xtype: 'checkbox',
                                                    name: 'calidad',
                                                    fieldLabel: 'Calidad',
                                                    renderer: function (value, p, record) {
                                                        return record.data['calidad'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth: 50
                                                }, //
                                                new Ext.form.Label({
                                                    text: 'Medio Ambiente  :',
                                                    style: 'margin: 5px'
                                                }),
                                                {
                                                    xtype: 'checkbox',
                                                    name: 'medio_ambiente',
                                                    fieldLabel: 'Medio Ambiente',
                                                    renderer: function (value, p, record) {
                                                        return record.data['medio_ambiente'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth: 50
                                                },
                                                new Ext.form.Label({
                                                    text: 'Seguridad :',
                                                    style: 'margin: 5px'
                                                }),
                                                {
                                                    xtype: 'checkbox',
                                                    name: 'seguridad',
                                                    fieldLabel: 'Seguridad',
                                                    renderer: function (value, p, record) {
                                                        return record.data['seguridad'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth: 50
                                                }, //
                                                new Ext.form.Label({
                                                    text: 'Responsabilidad Social :',
                                                    style: 'margin: 5px'
                                                }),
                                                {
                                                    xtype: 'checkbox',
                                                    name: 'responsabilidad_social',
                                                    fieldLabel: 'Responsabilidad Social',
                                                    renderer: function (value, p, record) {
                                                        return record.data['responsabilidad_social'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth: 50
                                                },
                                                new Ext.form.Label({
                                                    text: 'Sistemas Integrados :',
                                                    style: 'margin: 5px'
                                                }),
                                                {
                                                    xtype: 'checkbox',
                                                    name: 'sistemas_integrados',
                                                    fieldLabel: 'Sistemas Integrados',
                                                    renderer: function (value, p, record) {
                                                        return record.data['sistemas_integrados'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth: 50
                                                }
                                            ]
                                        }),
                                        {
                                            xtype: 'textarea',
                                            name: 'descrip_nc',
                                            fieldLabel: '*Descripcion',
                                            allowBlank: false,
                                            anchor: '100%',
                                            gwidth: 280
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'evidencia',
                                            fieldLabel: 'Evidencia',
                                            allowBlank: true,
                                            anchor: '100%',
                                            gwidth: 280
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'obs_consultor',
                                            fieldLabel: 'Observacion Consultor',
                                            allowBlank: true,
                                            anchor: '100%',
                                            gwidth: 150,
                                            disabled: true
                                        },
                                        table
                                    ]
                                })
                            ]
                        },
                            {
                                title: 'Archivos Evidencia',
                                layout: 'fit',
                                defaults: {width: 400},
                                items: [
                                    grilla
                                ]
                            },

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
            grilla.addListener('cellclick', this.oncellclick, this);
            if (data) {
                isForm.getForm().findField('descrip_nc').setValue(data.descrip_nc);
                isForm.getForm().findField('evidencia').setValue(data.evidencia);
                isForm.getForm().findField('obs_consultor').setValue(data.obs_consultor);
                setTimeout(() => {
                    isForm.getForm().findField('id_parametro').setValue(data.id_parametro);
                    isForm.getForm().findField('id_parametro').setRawValue(data.valor_parametro);
                }, 1000);
                isForm.getForm().findField('calidad').setValue(this.onBool(data.calidad));
                isForm.getForm().findField('medio_ambiente').setValue(this.onBool(data.medio_ambiente));
                isForm.getForm().findField('seguridad').setValue(this.onBool(data.seguridad));
                isForm.getForm().findField('responsabilidad_social').setValue(this.onBool(data.responsabilidad_social));
                isForm.getForm().findField('sistemas_integrados').setRawValue(this.onBool(data.sistemas_integrados));
            }
            let id_funcionario = null;
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/getUo',
                params: {id_uo: maestro.id_uo},
                success: function (resp) {
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    isForm.getForm().findField('id_uo').setValue(reg.ROOT.datos.id_uo);
                    isForm.getForm().findField('id_uo').setRawValue(reg.ROOT.datos.nombre_unidad);
                    isForm.getForm().findField('id_funcionario').setValue(reg.ROOT.datos.desc_funcionario1);
                    id_funcionario = reg.ROOT.datos.id_funcionario;
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
            isForm.getForm().findField('id_uo').on('select', function (combo, record, index) {
                Ext.Ajax.request({
                    url: '../../sis_auditoria/control/NoConformidad/getUo',
                    params: {id_uo: record.data.id_uo},
                    success: function (resp) {
                        isForm.getForm().findField('id_funcionario').reset();
                        const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                        isForm.getForm().findField('id_funcionario').setValue(reg.ROOT.datos.desc_funcionario1);
                        id_funcionario = reg.ROOT.datos.id_funcionario;
                    },
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            }, this);

            this.ventanaNoConformidad = new Ext.Window({
                width: 650,
                height: 720,
                modal: true,
                title: 'Formulario No Conformidad',
                bodyStyle: 'padding:5px',
                layout: 'fit',
                items: isForm,
                lain: true,
                buttons: [{
                    text: 'Guardar',
                    handler: function () {
                        let submit = {};
                        Ext.each(isForm.getForm().items.keys, function (element, index) {
                            obj = Ext.getCmp(element);
                            if (obj.items) {
                                Ext.each(obj.items.items, function (elm, ind) {
                                    submit[elm.name] = elm.getValue();
                                }, this)
                            } else {
                                submit[obj.name] = obj.getValue();
                            }
                        }, this);
                        if (isForm.getForm().isValid()) {

                            if (!this.id_no_conformidad) {
                                Phx.CP.loadingShow();
                                Ext.Ajax.request({
                                    url: '../../sis_auditoria/control/NoConformidad/insertarNoConformidad',
                                    params: {
                                        id_aom: maestro.id_aom,
                                        nro_tramite_padre: maestro.nro_tramite_wf,
                                        id_parametro: submit.id_parametro,
                                        id_uo: submit.id_uo,
                                        id_funcionario: id_funcionario,
                                        calidad: submit.calidad,
                                        medio_ambiente: submit.medio_ambiente,
                                        responsabilidad_social: submit.responsabilidad_social,
                                        seguridad: submit.seguridad,
                                        sistemas_integrados: submit.sistemas_integrados,
                                        descrip_nc: submit.descrip_nc,
                                        evidencia: submit.evidencia,
                                        obs_resp_area: '',// submit.obs_resp_area,
                                        obs_consultor: submit.obs_consultor,
                                        id_norma: submit.id_norma,
                                        // id_pn : submit.id_pn,
                                        id_nc: id_modificacion
                                    },
                                    isUpload: false,
                                    success: function (resp) {
                                        Phx.CP.loadingHide();
                                        const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                                        this.id_no_conformidad = reg.ROOT.datos.id_nc;
                                        this.id_proceso_no_conformidad = reg.ROOT.datos.id_proceso_wf;
                                        this.documentos.baseParams.modoConsulta = 'no';
                                        this.documentos.baseParams.todos_documentos = 'no';
                                        this.documentos.baseParams.anulados = 'no';
                                        this.documentos.baseParams.id_proceso_wf = reg.ROOT.datos.id_proceso_wf;
                                        this.documentos.load({params: {start: 0, limit: 50}});
                                    },
                                    argument: this.argumentSave,
                                    failure: this.conexionFailure,
                                    timeout: this.timeout,
                                    scope: this
                                });
                            } else {
                                me.ventanaNoConformidad.hide();
                                me.tienda.load();
                                this.id_no_conformidad = null;
                            }
                        }
                    },
                    scope: this
                }, {
                    text: 'Cerrar',
                    handler: function () {
                        this.id_no_conformidad = null;
                        me.ventanaNoConformidad.hide();
                        me.tienda.load();
                    },
                    scope: this
                }],
                listeners: {
                    close: function () {
                        console.log(1)
                        me.tienda.load();
                    },
                    scope: this
                }
            });
        },
        onBool: function (valor) {
            return valor === 't';
        },
        sigEstado: function () {
            Phx.CP.loadingShow();
            const rec = this.sm.getSelected();
            const id_estado_wf = rec.data.id_estado_wf;
            const id_proceso_wf = rec.data.id_proceso_wf;
            if (confirm('¿Desea NOTIFICAR este informe de auditoria a los destinatarios especificados?\n No podras retornar al estado actual')) {
                if (confirm('El informe de auditoria ser NOTIFICADO al responsable del Area Auditadas y a los destinatarios adicionales \n ¿Desea continuar?')) {
                    Ext.Ajax.request({
                        url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/aprobarEstado',
                        params: {
                            id_proceso_wf: id_proceso_wf,
                            id_estado_wf: id_estado_wf
                        },
                        success: this.successWizard,
                        failure: this.conexionFailure,
                        timeout: this.timeout,
                        scope: this
                    });
                }
            } else {
                Phx.CP.loadingHide();
            }
        },
        successWizard: function () {
            Phx.CP.loadingHide();
            alert('El informe ha sido notificado al Responsable de Area Auditada y a los  destinatarios adicionales');
            this.reload();
        },
        formularioPuntoNorma: function (data) {
            const maestro = this.sm.getSelected().data;
            const me = this;
            let id_norma_aux = null;

            const isForm = new Ext.form.FormPanel({
                labelAlign: 'top',
                frame: true,
                bodyStyle: 'padding:5px 5px 0',
                width: 600,
                items: [
                    {
                        xtype: 'field',
                        fieldLabel: 'Auditoria',
                        name: 'nro_tramite_wf',
                        anchor: '98%',
                        value: '(' + maestro.nro_tramite + ') ' + maestro.nombre_aom1,
                        readOnly: true,
                        style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                    },
                    {
                        xtype: 'field',
                        fieldLabel: 'Tipo',
                        name: 'desc_tipo_norma',
                        anchor: '98%',
                        value: maestro.desc_tipo_norma,
                        readOnly: true,
                        style: 'background: #F8F8F8; border: none;r: 0; font-weight: bold;',
                    },
                    {
                        xtype: 'radiogroup',
                        name: 'filtro',
                        fieldLabel: 'Filtro',
                        itemCls: 'x-check-group-alt',
                        items: [
                            {
                                boxLabel: 'Punto de norma auditoria',
                                name: 'filtro',
                                inputValue: 'auditoria',
                                checked: true
                            },
                            {boxLabel: 'Punto de norma', name: 'filtro', inputValue: 'norma'}
                        ],
                        value: 'auditoria'
                    },
                    {
                        xtype: 'combo',
                        name: 'id_norma',
                        fieldLabel: 'Norma',
                        allowBlank: false,
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
                            fields: ['id_norma', 'id_tipo_norma', 'nombre_norma', 'sigla_norma', 'descrip_norma'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'nor.sigla_norma', id_nc_aom: maestro.id_aom}
                        }),
                        valueField: 'id_norma',
                        displayField: 'sigla_norma',
                        gdisplayField: 'sigla_norma',
                        tpl: '<tpl for="."><div class="x-combo-list-item"><p style="color:#01010a">{sigla_norma} - {nombre_norma}</p></div></tpl>',
                        hiddenName: 'id_norma',
                        mode: 'remote',
                        anchor: '98%',
                        triggerAction: 'all',
                        lazyRender: true,
                        pageSize: 15,
                        minChars: 2
                    },
                    {
                        anchor: '98%',
                        bodyStyle: 'padding:10px;',
                        items: [{
                            xtype: 'itemselector',
                            name: 'id_pn',
                            fieldLabel: 'Punto Noma',
                            imagePath: '../../../pxp/lib/ux/images/',
                            drawUpIcon: false,
                            drawDownIcon: false,
                            drawTopIcon: false,
                            drawBotIcon: false,
                            multiselects: [{
                                width: 270,
                                height: 200,
                                store: new Ext.data.JsonStore({
                                    url: '../../sis_auditoria/control/PuntoNorma/listarPuntoNormaMulti',
                                    id: 'id_pn',
                                    root: 'datos',
                                    totalProperty: 'total',
                                    fields: ['id_pn', 'nombre_pn', 'nombre_descrip'],
                                    remoteSort: true,
                                    baseParams: {dir: 'ASC', sort: 'id_pn', limit: '100', start: '0'}
                                }),
                                tbar: {
                                    xtype: 'toolbar',
                                    flex: 1,
                                    dock: 'top',
                                    items: [
                                        'Filtro:',
                                        {
                                            xtype: 'textfield',
                                            fieldStyle: 'text-align: left;',
                                            enableKeyEvents: true,
                                            listeners: {
                                                scope: this,
                                                specialkey: function (field, e) {
                                                    if (e.getKey() === e.ENTER) {
                                                        if (String(field).trim() !== '') {
                                                            isForm.getForm().findField('id_pn').multiselects[0].store.baseParams = {
                                                                nombre_descrip: field.getValue(),
                                                                dir: "ASC",
                                                                sort: "id_pn",
                                                                limit: "100",
                                                                start: "0",
                                                                id_norma: id_norma_aux,
                                                                item: maestro.id_aom
                                                            };
                                                            isForm.getForm().findField('id_pn').multiselects[0].store.load();
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    ]
                                },
                                displayField: 'nombre_descrip',
                                valueField: 'id_pn',
                            }, {
                                width: 270,
                                height: 200,
                                store: new Ext.data.JsonStore({
                                    url: '../../sis_auditoria/control/PnormaNoconformidad/listarPnormaNoconformidad',
                                    id: 'id_pn',
                                    root: 'datos',
                                    totalProperty: 'total',
                                    fields: ['id_pn', 'nombre_pn', 'nombre_descrip'],
                                    remoteSort: true,
                                    baseParams: {
                                        dir: 'ASC',
                                        sort: 'id_pn',
                                        limit: '100',
                                        start: '0',
                                        id_nc: data ? data.id_nc : this.id_no_conformidad
                                    }
                                }),
                                tbar: [
                                    {
                                        text: 'Todo',
                                        handler: function () {
                                            const toStore = isForm.getForm().findField('id_pn').multiselects[0].store;
                                            const fromStore = isForm.getForm().findField('id_pn').multiselects[1].store;
                                            for (var i = toStore.getCount() - 1; i >= 0; i--) {
                                                const record = toStore.getAt(i);
                                                toStore.remove(record);
                                                fromStore.add(record);
                                            }
                                        }
                                    },
                                    {
                                        text: 'Limpiar',
                                        handler: function () {
                                            isForm.getForm().findField('id_pn').reset();
                                        }
                                    }],
                                displayField: 'nombre_descrip',
                                valueField: 'id_pn',
                            }]
                        }]
                    }
                ]
            });
            isForm.getForm().findField('id_norma').on('select', function (combo, record, index) {
                isForm.getForm().findField('id_pn').multiselects[0].store.baseParams = {
                    dir: "ASC",
                    sort: "id_pn",
                    limit: "100",
                    start: "0",
                    id_norma: record.data.id_norma,
                    itemNc: data ? data.id_nc : this.id_no_conformidad,
                };

                isForm.getForm().findField('id_pn').multiselects[1].store.baseParams = {
                    dir: "ASC",
                    sort: "id_pn",
                    limit: "100",
                    start: "0",
                    id_nc: data ? data.id_nc : this.id_no_conformidad,
                    id_norma: record.data.id_norma
                };

                id_norma_aux = record.data.id_norma;
                isForm.getForm().findField('id_pn').multiselects[0].store.load();
                isForm.getForm().findField('id_pn').multiselects[1].store.load();
                isForm.getForm().findField('id_pn').modificado = true;
                isForm.getForm().findField('id_pn').reset();
            }, this);

            isForm.getForm().findField('filtro').on('change', function (cmp, check) {
                isForm.getForm().findField('id_norma').reset();
                isForm.getForm().findField('id_norma').modificado = true;
                isForm.getForm().findField('id_pn').modificado = true;
                isForm.getForm().findField('id_pn').reset();
                // let norma = null
                if (check.getRawValue() === 'norma') {

                    console.log('Entra')
                    isForm.getForm().findField('id_pn').multiselects[0].store.removeAll();
                    isForm.getForm().findField('id_pn').multiselects[1].store.removeAll();

                    isForm.getForm().findField('id_norma').store.baseParams = {par_filtro: 'nor.sigla_norma'};
                    isForm.getForm().findField('id_norma').on('select', function (combo, record, index) {
                        console.log(record.data.id_norma)
                        isForm.getForm().findField('id_pn').multiselects[0].store.baseParams = {
                            dir: "ASC",
                            sort: "id_pn",
                            limit: "100",
                            start: "0",
                            id_norma: record.data.id_norma,
                            item: maestro.id_aom
                        };
                        isForm.getForm().findField('id_pn').multiselects[1].store.baseParams = {
                            dir: "ASC",
                            sort: "id_pn",
                            limit: "100",
                            start: "0",
                            id_aom: maestro.id_aom,
                            id_norma: record.data.id_norma
                        };
                        id_norma_aux = record.data.id_norma;
                        isForm.getForm().findField('id_pn').multiselects[0].store.load();
                        isForm.getForm().findField('id_pn').multiselects[1].store.load();
                        isForm.getForm().findField('id_pn').modificado = true;
                        isForm.getForm().findField('id_pn').reset();
                    }, this);

                } else {
                    isForm.getForm().findField('id_pn').multiselects[0].store.removeAll();
                    isForm.getForm().findField('id_pn').multiselects[1].store.removeAll();

                    isForm.getForm().findField('id_norma').store.baseParams = {
                        par_filtro: 'nor.sigla_norma',
                        id_nc_aom: maestro.id_aom
                    };
                    isForm.getForm().findField('id_norma').on('select', function (combo, record, index) {
                        isForm.getForm().findField('id_pn').multiselects[0].store.baseParams = {
                            dir: "ASC",
                            sort: "id_aom",
                            limit: "100",
                            start: "0",
                            id_norma: record.data.id_norma,
                            itemNc: data ? data.id_nc : this.id_no_conformidad,
                        };
                        isForm.getForm().findField('id_pn').multiselects[1].store.baseParams = {
                            dir: "ASC",
                            sort: "id_aom",
                            limit: "100",
                            start: "0",
                            id_nc: data ? data.id_nc : this.id_no_conformidad,
                            id_norma: record.data.id_norma
                        };
                        id_norma_aux = record.data.id_norma;
                        isForm.getForm().findField('id_pn').multiselects[0].store.load();
                        isForm.getForm().findField('id_pn').multiselects[1].store.load();
                        isForm.getForm().findField('id_pn').modificado = true;
                        isForm.getForm().findField('id_pn').reset();
                    }, this);
                }


            }, this);

            this.ventanaPuntoNorma = new Ext.Window({
                width: 610,
                height: 500,
                modal: true,
                closeAction: 'hide',
                labelAlign: 'bottom',
                title: 'Selección de punto de norma',
                bodyStyle: 'padding:5px',
                layout: 'form',
                items: [
                    isForm
                ],
                buttons: [{
                    text: 'Guardar',
                    handler: function () {
                        const submit = {};
                        Ext.each(isForm.getForm().items.keys, function (element, index) {
                            obj = Ext.getCmp(element);
                            if (obj.items) {
                                Ext.each(obj.items.items, function (elm, ind) {
                                    submit[elm.name] = elm.getValue();
                                }, this)
                            } else {
                                submit[obj.name] = obj.getValue();
                            }
                        }, this);
                        Phx.CP.loadingShow();
                        let id_nc;
                        if (data) {
                            id_nc = data.id_nc
                        } else {
                            id_nc = this.id_no_conformidad
                        }
                        Ext.Ajax.request({
                            url: '../../sis_auditoria/control/PnormaNoconformidad/insertarItemAuditoriaNpn',
                            params: {
                                id_nc: id_nc,
                                id_norma: submit.id_norma,
                                id_pn: submit.id_pn
                            },
                            isUpload: false,
                            success: function (a, b, c) {
                                Phx.CP.loadingHide();
                                me.ventanaPuntoNorma.hide();
                                me.punto.baseParams.id_nc = data ? data.id_nc : this.id_no_conformidad;
                                me.punto.load();

                            },
                            argument: this.argumentSave,
                            failure: this.conexionFailure,
                            timeout: this.timeout,
                            scope: this
                        });
                    },
                    scope: this
                },
                    {
                        text: 'Declinar',
                        handler: function () {
                            this.ventanaPuntoNorma.hide();
                        },
                        scope: this
                    }]
            });
        },
        oncellclick: function (grid, rowIndex, columnIndex, e) {

            const record = this.documentos.getAt(rowIndex),
                fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name

            if (fieldName === 'nro_tramite_ori' && record.data.id_proceso_wf_ori) {
                //open documentos de origen
                this.loadCheckDocumentosSolWf(record);
            } else if (fieldName === 'upload') {

                if (record.data.solo_lectura === 'no' && !record.data.id_proceso_wf_ori) {
                    this.SubirArchivo(record);
                    // this.onSubirDocumento(record.data);
                }
            } else if (fieldName === 'modificar') {
                if (record.data['modificar'] === 'si') {

                    this.cambiarMomentoClick(record);

                }
            } else if (fieldName === 'chequeado') {
                if (record.data['extension'].length !== 0) {
                    //Escaneados
                    var data = "id=" + record.data['id_documento_wf'];
                    data += "&extension=" + record.data['extension'];
                    data += "&sistema=sis_workflow";
                    data += "&clase=DocumentoWf";
                    data += "&url=" + record.data['url'];
                    window.open('../../../lib/lib_control/CTOpenFile.php?' + data);
                } else if (record.data.nombre_vista) {
                    //Plantillas
                    Phx.CP.loadingShow();
                    Ext.Ajax.request({
                        url: '../../sis_workflow/control/TipoDocumento/generarDocumento',
                        params: {
                            id_proceso_wf: record.data.id_proceso_wf,
                            id_tipo_documento: record.data.id_tipo_documento,
                            nombre_vista: record.data.nombre_vista,
                            esquema_vista: record.data.esquema_vista,
                            nombre_archivo_plantilla: record.data.nombre_archivo_plantilla
                        },
                        success: this.successExport,
                        failure: this.conexionFailure,
                        timeout: this.timeout,
                        scope: this
                    });


                } else if (record.data['tipo_documento'] === 'generado') {
                    Phx.CP.loadingShow();
                    Ext.Ajax.request({
                        url: '../../' + record.data.action,
                        params: {'id_proceso_wf': record.data.id_proceso_wf, 'action': record.data.action},
                        success: this.successExport,
                        failure: this.conexionFailure,
                        timeout: this.timeout,
                        scope: this
                    });
                } else {
                    alert('No se ha subido ningun archivo para este documento');
                }
            }
        },
        oncellclickNc: function (grid, rowIndex, columnIndex, e) {

            const record = this.tienda.getAt(rowIndex),
                fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name
            if (fieldName === 'descrip_nc') {
                this.formularioNoConformidad(record.json);
                this.ventanaNoConformidad.show();
            }
            if (fieldName === 'eliminar') {
                console.log(record)
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_auditoria/control/NoConformidad/eliminarNoConformidad',
                    params: {
                        id_nc: record.json.id_nc
                    },
                    isUpload: false,
                    success: function (a, b, c) {
                        Phx.CP.loadingHide();
                        this.tienda.load();
                    },
                    argument: this.argumentSave,
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                })
            }

        },
        SubirArchivo: function (rec) {
            const objecto = rec.data;
            objecto.reload_documento = this.documentos;
            Phx.CP.loadWindows('../../../sis_auditoria/vista/auditoria_oportunidad_mejora/SubirArchivoWf.php',
                'Subir ' + rec.data.nombre_tipo_documento, {
                    modal: true,
                    width: 450,
                    height: 150
                }, objecto, this.idContenedor, 'SubirArchivoWf',
                {
                    config: [{
                        event: 'successSave',

                    }],

                    scope: this
                }
            );
        },
        onSubirDocumento: function (record) {
            this.crearFormDocumento(record);
            this.ventanaDocumento.show();
        },
        onFormularioDocumento: function (data) {
            this.crearFormulario(data);
            this.ventanaResponsable.show();
        },
        crearFormulario: function (record) {
            const storeCombo = new Ext.data.JsonStore({
                url: '../../sis_workflow/control/TipoDocumento/listarTipoDocumento',
                id: 'id_tipo_documento',
                root: 'datos',
                sortInfo: {
                    field: 'tipdw.codigo',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_tipo_documento', 'codigo', 'nombre', 'descripcion'],
                remoteSort: true,
                baseParams: {par_filtro: 'tipdw.nombre#tipdw.codigo'}
            });
            const combo = new Ext.form.ComboBox({
                name: 'id_tipo_documentos',
                fieldLabel: 'Documentos',
                allowBlank: false,
                typeAhead: true,
                store: storeCombo,
                mode: 'remote',
                pageSize: 15,
                triggerAction: 'all',
                valueField: 'id_tipo_documento',
                displayField: 'nombre',
                gdysplayfield: 'descripcion_tipo_documento',
                forceSelection: true,
                anchor: '100%',
                resizable: true,
                enableMultiSelect: false
            });
            this.formAuto = new Ext.form.FormPanel({
                baseCls: 'x-plain',
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                items: [combo]
            });
            this.ventanaResponsable = new Ext.Window({
                title: 'Registar Nuevo Documento',
                collapsible: true,
                maximizable: true,
                autoDestroy: true,
                width: 500,
                height: 150,
                layout: 'fit',
                plain: true,
                bodyStyle: 'padding:5px;',
                buttonAlign: 'center',
                items: this.formAuto,
                modal: true,
                closeAction: 'hide',
                buttons: [{
                    text: 'Guardar',
                    handler: this.saveDocumento,
                    scope: this
                },
                    {
                        text: 'Cancelar',
                        handler: function () {
                            this.ventanaResponsable.hide()
                        },
                        scope: this
                    }]
            });
            this.cmpTipoDocumentos = this.formAuto.getForm().findField('id_tipo_documentos');
            this.cmpIdProceso_wf = record ? record.id_proceso_wf : this.id_proceso_no_conformidad;
            Ext.Ajax.request({
                url: '../../sis_workflow/control/DocumentoWf/verificarConfiguracion',
                params: {'id_proceso_wf': record ? record.id_proceso_wf : this.id_proceso_no_conformidad},
                success: function (resp) {
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    this.cmpTipoDocumentos.store.baseParams.id_tipo_documentos = reg.ROOT.datos.id_tipo_documentos;
                    this.cmpTipoDocumentos.enable();
                    this.cmpTipoDocumentos.show();
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        saveDocumento: function () {
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_workflow/control/DocumentoWf/insertarDocumentoWf',
                params: {
                    id_tipo_documentos: this.cmpTipoDocumentos.getValue(),
                    id_proceso_wf: this.cmpIdProceso_wf
                },
                success: this.successSinc,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        successSinc: function (resp) {
            Phx.CP.loadingHide();
            const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            this.documentos.load({params: {start: 0, limit: 50}});
            this.ventanaResponsable.hide();
        },
        crearFormDocumento: function (record) {
            const field = new Ext.form.Field({
                fieldLabel: "Documento (archivo Pdf,Word)",
                gwidth: 130,
                inputType: 'file',
                name: 'archivo',
                allowBlank: false,
                buttonText: '',
                maxLength: 150,
                anchor: '100%'
            });

            this.formAutoDoc = new Ext.form.FormPanel({
                baseCls: 'x-plain',
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                items: [field]
            });

            this.ventanaDocumento = new Ext.Window({
                title: 'Subir Documento',
                collapsible: true,
                maximizable: true,
                autoDestroy: true,
                width: 500,
                height: 150,
                layout: 'fit',
                plain: true,
                bodyStyle: 'padding:5px;',
                buttonAlign: 'center',
                items: this.formAutoDoc,
                modal: true,
                closeAction: 'hide',
                buttons: [{
                    text: 'Guardar',
                    handler: this.saveDocumentoInsert,
                    scope: this
                },
                    {
                        text: 'Cancelar',
                        handler: function () {
                            this.ventanaDocumento.hide()
                        },
                        scope: this
                    }]
            });
            this.cmpArchivo = this.formAutoDoc.getForm().findField('archivo');
            this.cmpIdDocumento = record.id_documento_wf;
            this.cmpNroTramite = record.nro_tramite;
        },
        saveDocumentoInsert: function () {
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_workflow/control/DocumentoWf/subirArchivoWf',
                params: {
                    id_documento_wf: this.cmpIdDocumento,
                    num_tramite: this.cmpNroTramite,
                    archivo: this.cmpArchivo.getValue()
                },
                isUpload: true,
                success: this.successSincDoc,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        successSincDoc: function (resp) {
            Phx.CP.loadingHide();
            const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            this.documentos.load({params: {start: 0, limit: 50}});
            this.ventanaDocumento.hide();
        },
        tabsouth: [
            {
                url: '../../../sis_auditoria/vista/destinatario/Destinatario.php',
                title: 'Destinatarios',
                height: '50%',
                cls: 'Destinatario'
            },
            {
                url: '../../../sis_auditoria/vista/no_conformidad/NoConformidadGestion.php',
                title: 'No Conformidad',
                height: '50%',
                cls: 'NoConformidadGestion'
            }
        ],
        west: {
            url: '../../../sis_auditoria/vista/auditoria_oportunidad_mejora/filter/FormFiltroInfo.php',
            width: '25%',
            title: 'Filtrar Datos',
            collapsed: false,
            cls: 'FormFiltroInfo'
        },
        onCerrarAuditoria: function () {
            alert(1)
        }
    };
</script>
