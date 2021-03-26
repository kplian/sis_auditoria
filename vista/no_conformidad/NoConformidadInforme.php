<?php
/**
 *@package pXP
 *@file PlanificacionAOM.php
 *@author  Maximilimiano Camacho
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadInforme = {

        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'NoConformidad',
        nombreVista: 'NoConformidadInforme',
        bedit:false,
        bnew:false,
        bdel:false,
        dblclickEdit: false,
        columna: null,
        ma: null,
        descrip_nc : '',
        constructor: function(config) {
            this.Atributos[this.getIndAtributo('codigo_nc')].grid=false;
            Phx.vista.NoConformidadInforme.superclass.constructor.call(this,config);
            this.getBoton('btnNoram').setVisible(false);
            this.init();
            this.grid.addListener('cellclick', this.oncellclick,this);
            this.addButton('btnAceptar', {
                text: 'Aceptar Todo',
                iconCls: 'bok',
                disabled: false,
                handler: this.onAceptar,
                tooltip: '<b>Aceptar toda las no conformidades...</b>',
                scope:this
            });
        },
        loadCheckDocumentosRecWf:function() {
            var rec=this.sm.getSelected();
            rec.data.nombreVista = this.nombreVista;
            Phx.CP.loadWindows('../../../sis_workflow/vista/documento_wf/DocumentoWf.php',
                'Chequear documento del WF',
                {
                    width:'90%',
                    height:500
                },
                rec.data,
                this.idContenedor,
                'DocumentoWf'
            )
        },
        onReloadPage:function(m){
            this.maestro=m;
            this.store.baseParams = {id_aom: this.maestro.id_aom,interfaz : this.nombreVista};
            this.load({params:{start:0, limit:50}})
        },
        loadValoresIniciales: function () {
            Phx.vista.NoConformidadInforme.superclass.loadValoresIniciales.call(this);
            this.Cmp.id_aom.setValue(this.maestro.id_aom);
        },
        preparaMenu:function(n){
            const tb =this.tbar;
            Phx.vista.NoConformidadInforme.superclass.preparaMenu.call(this,n);
            return tb
        },
        liberaMenu:function(){
            const tb = Phx.vista.NoConformidadInforme.superclass.liberaMenu.call(this);
            if(tb){
            }
            return tb
        },
        oncellclick: function (grid, rowIndex, columnIndex, e) {
            const record = this.store.getAt(rowIndex),
                fieldName = grid.getColumnModel().getDataIndex(columnIndex);
            if (fieldName === 'revisar' || fieldName === 'rechazar') {
                this.cambiarAsignacion(record, fieldName);
            }
        },
        cambiarAsignacion: function (record, name) {
            this.columna = name;
            const select = this.getSelectedData();
            this.descrip_nc = select.descrip_nc;
            this.crearFormResponsableNC(select);
            this.crearFormObservacion(select);
            if (name === 'revisar') {
                if (select.revisar === 'si') {
                    Ext.Ajax.request({
                        url: '../../sis_auditoria/control/NoConformidad/aceptarNoConformidad',
                        params: {
                            id_nc: select.id_nc,
                            fieldName: name,
                            id_funcionario_nc: null
                        },
                        success: this.successWizard,
                        failure: this.conexionFailure,
                        timeout: this.timeout,
                        scope: this
                    });
                } else {
                    this.ventanaResponsable.show();
                }
            }
            if (name === 'rechazar') {
                if (select.rechazar === 'si') {
                    Ext.Ajax.request({
                        url: '../../sis_auditoria/control/NoConformidad/aceptarNoConformidad',
                        params: {
                            id_nc: select.id_nc,
                            fieldName: name,
                            id_funcionario_nc: null
                        },
                        success: this.successWizard,
                        failure: this.conexionFailure,
                        timeout: this.timeout,
                        scope: this
                    });
                } else {
                    this.ventanaObservacion.show();
                }
            }


        },
        onAceptar: function () {
            this.onFormularioTodo();
            this.ventanaTodoAcep.show();
        },
        crearFormResponsableNC: function (record) {
            const me = this;
            Phx.CP.loadingShow();
            const informe = {
                fieldLabel: 'Informe',
                xtype: 'box',
                autoEl: {
                    tag: 'a',
                    html: this.maestro.nombre_aom1 + ' ' + this.maestro.nro_tramite_wf,
                },
                style: 'cursor:pointer;',
                listeners: {
                    render: function (component) {
                        component.getEl().on('click', function (e) {
                            me.onCrearAuditoria(record);
                            me.formularioVentana.show();
                        });
                    }
                }
            };
            const area = new Ext.form.TextField({
                name: 'area',
                msgTarget: 'title',
                fieldLabel: 'Area',
                allowBlank: true,
                readOnly: true,
                anchor: '100%',
                style: 'background-image: none;',
                value: this.maestro.nombre_unidad,
                maxLength: 50
            });
            const responsable_area = new Ext.form.TextField({
                name: 'responsable_area',
                msgTarget: 'title',
                fieldLabel: 'Responsable area',
                allowBlank: true,
                readOnly: true,
                anchor: '100%',
                style: 'background-image: none;',
                value: '',
                maxLength: 50
            });
            const no_conformidad = {
                fieldLabel: 'No Conformidad',
                xtype: 'box',
                autoEl: {
                    tag: 'a',
                    html: this.descrip_nc.substr(1, 250) + '...'
                },
                style: 'cursor:pointer;',
                listeners: {
                    render: function (component) {
                        component.getEl().on('click', function (e) {
                            me.formularioNoConformidad(record);
                            me.ventanaNoConformidad.show();
                        });
                    }
                }
            };
            const storeCombo = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/NoConformidad/listarFuncionariosUO',
                id: 'id_funcionario',
                root: 'datos',
                sortInfo: {
                    field: 'desc_funcionario',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_funcionario', 'desc_funcionario', 'desc_funcionario_cargo'],
                remoteSort: true,
                baseParams: {par_filtro: 'vfc.desc_funcionario1 '}
            });

            const combo = new Ext.form.ComboBox({
                name: 'id_funcionario_nc',
                fieldLabel: 'Responsable de No Conformidad',
                allowBlank: false,
                typeAhead: true,
                store: storeCombo,
                mode: 'remote',
                pageSize: 15,
                triggerAction: 'all',
                valueField: 'id_funcionario',
                displayField: 'desc_funcionario',
                forceSelection: true,
                anchor: '100%',
                resizable: true,
                enableMultiSelect: false
            });
            this.formAuto = new Ext.form.FormPanel({
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                autoScroll: true,
                region: 'center',
                defaults: {height: 450},
                items: [
                    new Ext.form.FieldSet({
                        collapsible: false,
                        title: 'Datos Generales',
                        border: true,
                        layout: 'form',
                        items: [
                            informe,
                            area,
                            responsable_area,
                            no_conformidad,
                            combo
                        ]
                    })
                ]
            });
            this.ventanaResponsable = new Ext.Window({
                title: 'Asignar Responsable No Conformidad',
                width: 600,
                height: 400,
                closeAction: 'hide',
                labelAlign: 'bottom',
                items: this.formAuto,
                modal: true,
                bodyStyle: 'padding:5px',
                layout: 'form',
                buttons: [{
                    text: 'Guardar',
                    handler: this.saveResponsable,
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
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/listarRespAreaGerente',
                params: {
                    id_uo: this.maestro.id_uo
                },
                success: function (resp) {
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    this.formAuto.getForm().findField('responsable_area').setValue(reg.ROOT.datos.desc_funcionario);
                    Phx.CP.loadingHide();
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
            this.cmpResponsable = this.formAuto.getForm().findField('id_funcionario_nc');

        },
        saveResponsable: function () {
            Phx.CP.loadingShow();
            const select = this.getSelectedData();

            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/aceptarNoConformidad',
                params: {
                    id_nc: select.id_nc,
                    fieldName: this.columna,
                    id_funcionario_nc: this.cmpResponsable.getValue(),
                    obs_resp_area: this.cmpObservacion.getValue()
                },
                success: this.successWizard,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        successWizard: function (resp) {
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            if (!reg.ROOT.error) {
                if (this.ventanaResponsable) {
                    this.ventanaResponsable.hide();
                }
                if (this.ventanaObservacion) {
                    this.ventanaObservacion.hide();
                }
                if (this.ventanaTodoAcep) {
                    this.ventanaTodoAcep.hide();
                }
                Phx.CP.loadingHide();
                this.reload();
            } else {
                alert("Error no se no se registro el funcionario")
            }

        },
        crearFormObservacion: function (record) {
            const me = this;
            const informe = {
                fieldLabel: 'Informe',
                xtype: 'box',
                autoEl: {
                    tag: 'a',
                    html: this.maestro.nombre_aom1 + ' ' + this.maestro.nro_tramite_wf,
                },
                style: 'cursor:pointer;',
                listeners: {
                    render: function (component) {
                        component.getEl().on('click', function (e) {
                            me.onCrearAuditoria(record);
                            me.formularioVentana.show();
                        });
                    }
                }
            };
            const area = new Ext.form.TextField({
                name: 'area',
                msgTarget: 'title',
                fieldLabel: 'Area',
                allowBlank: true,
                readOnly: true,
                anchor: '90%',
                style: 'background-image: none;',
                maxLength: 50,
                value: this.maestro.nombre_unidad,
            });
            const responsable_area = new Ext.form.TextField({
                name: 'responsable_area',
                msgTarget: 'title',
                fieldLabel: 'Responsable area',
                allowBlank: true,
                readOnly: true,
                anchor: '90%',
                style: 'background-image: none;',
                maxLength: 50
            });
            const no_conformidad = {
                fieldLabel: 'No Conformidad',
                xtype: 'box',
                autoEl: {
                    tag: 'a',
                    html: this.descrip_nc.substr(1, 250) + '...'
                },
                style: 'cursor:pointer;',
                listeners: {
                    render: function (component) {
                        component.getEl().on('click', function (e) {
                            me.formularioNoConformidad(record);
                            me.ventanaNoConformidad.show();
                        });
                    }
                }
            };
            const obs_consultor = new Ext.form.TextArea({
                name: 'obs_resp_area',
                msgTarget: 'title',
                fieldLabel: 'Causa Rechazo',
                allowBlank: true,
                anchor: '90%',
                style: 'background-image: none;',
                maxLength: 50
            });

            this.formObs = new Ext.form.FormPanel({
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                autoScroll: true,
                region: 'center',
                defaults: {height: 450},
                items: [
                    new Ext.form.FieldSet({
                        collapsible: false,
                        title: 'Datos Generales',
                        border: true,
                        layout: 'form',
                        items: [informe,
                            area,
                            responsable_area,
                            no_conformidad,
                            obs_consultor
                        ]

                    })
                ]
            });

            this.ventanaObservacion = new Ext.Window({
                title: 'Rechazar No Conformidad',
                width: 600,
                height: 400,
                closeAction: 'hide',
                labelAlign: 'bottom',
                items: this.formObs,
                modal: true,
                bodyStyle: 'padding:5px',
                layout: 'form',
                buttons: [{
                    text: 'Guardar',
                    handler: this.saveResponsable,
                    scope: this
                },
                    {
                        text: 'Cancelar',
                        handler: function () {
                            this.ventanaObservacion.hide()
                        },
                        scope: this
                    }]
            });
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/listarRespAreaGerente',
                params: {
                    id_uo: this.maestro.id_uo
                },
                success: function (resp) {
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    this.formObs.getForm().findField('responsable_area').setValue(reg.ROOT.datos.desc_funcionario);
                    Phx.CP.loadingHide();
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
            this.cmpObservacion = this.formObs.getForm().findField('obs_resp_area');

        },
        onCrearAuditoria: function (record) {
            if (this.formularioVentana) {
                this.form_auditoria.destroy();
                this.formularioVentana.destroy();
            }

            Phx.CP.loadingShow();
            this.storeProceso = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/AuditoriaProceso/listarAuditoriaProceso',
                id: 'id_aproceso',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_aom', 'id_aproceso', 'proceso', 'desc_funcionario', 'estado_reg', 'usr_reg', 'fecha_reg'],
                remoteSort: true,
                baseParams: {dir: 'ASC', sort: 'id_aom', limit: '100', start: '0'}
            });
            this.storeEquipo = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/EquipoResponsable/listarEquipoResponsable',
                id: 'id_equipo_responsable',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_aom', 'id_formula_detalle', 'id_parametro', 'valor_parametro', 'id_funcionario',
                    'desc_funcionario1', 'estado_reg', 'usr_reg', 'fecha_reg'
                ], remoteSort: true,
                baseParams: {dir: 'ASC', sort: 'id_equipo_responsable', limit: '100', start: '0'}
            });
            this.storePuntoNorma = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/AuditoriaNpn/listarAuditoriaNpn',
                id: 'id_anpn',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_aom', 'id_anpn', 'id_norma', 'sigla_norma',
                    'id_pn', 'nombre_pn', 'codigo_pn', 'desc_punto_norma',
                    'usr_reg', 'estado_reg', 'fecha_reg', 'nombre_descrip'],
                remoteSort: true,
                baseParams: {dir: 'ASC', sort: 'id_anpn', limit: '100', start: '0'}
            });
            this.storePregunta = new Ext.data.GroupingStore({
                url: '../../sis_auditoria/control/AuditoriaNpnpg/listarAuditoriaNpnpg',
                id: 'id_anpnpg',
                root: 'datos',
                sortInfo: {
                    field: 'id_anpnpg',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_anpnpg', 'descrip_pregunta', 'estado_reg', 'usr_reg', 'fecha_reg'
                ], remoteSort: true,
                baseParams: {dir: 'ASC', sort: 'id_anpnpg', limit: '100', start: '0'}
            });
            this.storeCronograma = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/Cronograma/listarCronograma',
                id: 'id_cronograma',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_cronograma', 'id_aom', 'id_actividad',
                    'nueva_actividad', 'fecha_ini_activ', 'actividad',
                    'fecha_fin_activ', 'hora_ini_activ', 'hora_fin_activ', 'lista_funcionario',
                    'estado_reg', 'usr_reg', 'fecha_reg'], remoteSort: true,
                baseParams: {dir: 'ASC', sort: 'id_cronograma', limit: '100', start: '0'}
            });

            Ext.Ajax.request({
                url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarAuditoriaOportunidadMejora',
                params: {
                    dir: 'ASC',
                    sort: 'id_aom',
                    limit: '100',
                    start: '0',
                    id_aom: record.id_aom
                },
                success: this.successRevision,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
            const crorograma = new Ext.grid.GridPanel({
                layout: 'fit',
                store: this.storeCronograma,
                region: 'center',
                split: true,
                border: false,
                plain: true,
                trackMouseOver: false,
                stripeRows: true,
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Actividad',
                        dataIndex: 'id_actividad',
                        width: 150,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['actividad'])
                        },
                    },
                    {
                        header: 'Funcionarios',
                        dataIndex: 'lista_funcionario',
                        width: 210,
                        renderer: function (value, p, record) {
                            return String.format('<div class="gridmultiline">{0}</div>', record.data['lista_funcionario']);
                        }
                    },
                    {
                        header: 'Fecha Inicio',
                        dataIndex: 'fecha_ini_activ',
                        align: 'center',
                        width: 100,
                        renderer: function (value, p, record) {
                            const fecha = value.split("-");
                            return fecha[2] + '/' + fecha[1] + '/' + fecha[0];
                        }
                    },
                    {
                        header: 'Fecha Fin',
                        dataIndex: 'fecha_fin_activ',
                        align: 'center',
                        width: 100,
                        // renderer: function (value, p, record) {
                        //     const fecha = value.split("-");
                        //     return fecha[2] + '/' + fecha[1] + '/' + fecha[0];
                        // }
                    },
                    {
                        header: 'Hora Inicio',
                        dataIndex: 'hora_ini_activ',
                        align: 'center',
                        width: 100,
                    },
                    {
                        header: 'Hora Fin',
                        dataIndex: 'hora_fin_activ',
                        align: 'center',
                        width: 100,
                    },
                    {
                        header: 'Estado Reg.',
                        dataIndex: 'estado_reg',
                        width: 100,
                        sortable: false
                    },
                    {
                        header: 'Creado por.',
                        dataIndex: 'usr_reg',
                        width: 100,
                        sortable: false
                    },
                    {
                        header: 'Fecha creación',
                        dataIndex: 'fecha_reg',
                        align: 'center',
                        width: 110
                    }]
            });


            this.form_auditoria = new Ext.form.FormPanel({
                id: this.idContenedor + '_formulario_aud',
                items: [{
                    region: 'center',
                    layout: 'column',
                    border: false,
                    autoScroll: true,
                    items: [{
                        xtype: 'tabpanel',
                        plain: true,
                        activeTab: 0,
                        height: 400,
                        deferredRender: false,
                        items: [{
                            title: 'Datos Principales',
                            layout: 'form',
                            defaults: {width: 700},
                            autoScroll: true,
                            defaultType: 'textfield',
                            items: [
                                new Ext.form.FieldSet({
                                    collapsible: false,
                                    border: false,
                                    items: [
                                        new Ext.form.FieldSet({
                                            collapsible: false,
                                            border: true,
                                            layout: 'form',
                                            items: [
                                                {
                                                    xtype: 'field',
                                                    fieldLabel: 'Código',
                                                    name: 'nro_tramite_wf',
                                                    anchor: '100%',
                                                    readOnly: true,
                                                    id: this.idContenedor + '_nro_tramite_wf',
                                                    style: 'background-image: none;',
                                                },
                                                {
                                                    xtype: 'field',
                                                    fieldLabel: 'Area',
                                                    name: 'nombre_unidad',
                                                    anchor: '100%',
                                                    id: this.idContenedor + '_nombre_unidad',
                                                    readOnly: true,
                                                    style: 'background-image: none;',
                                                },
                                                {
                                                    xtype: 'field',
                                                    fieldLabel: 'Nombre',
                                                    name: 'nombre_aom1',
                                                    anchor: '100%',
                                                    readOnly: true,
                                                    id: this.idContenedor + '_nombre_aom1',
                                                    style: 'background-image: none;',
                                                },
                                            ]
                                        }),
                                        new Ext.form.FieldSet({
                                            collapsible: false,
                                            border: true,
                                            layout: 'form',
                                            items: [
                                                {
                                                    xtype: 'field',
                                                    fieldLabel: 'Lugar',
                                                    name: 'lugar',
                                                    anchor: '100%',
                                                    allowBlank: false,
                                                    disabled: false,
                                                    id: this.idContenedor + '_lugar',
                                                    readOnly: true,
                                                    style: 'background-image: none;',
                                                },
                                                {
                                                    xtype: 'combo',
                                                    fieldLabel: 'Tipo de Auditoria',
                                                    name: 'id_tnorma',
                                                    allowBlank: false,
                                                    id: this.idContenedor + '_id_tnorma',
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
                                                    anchor: '100%',
                                                    readOnly: true,
                                                    style: 'background-image: none;',
                                                },
                                                {
                                                    xtype: 'combo',
                                                    fieldLabel: 'Objeto Auditoria',
                                                    name: 'id_tobjeto',
                                                    allowBlank: false,
                                                    id: this.idContenedor + '_id_tobjeto',
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
                                                    anchor: '100%',
                                                    readOnly: true,
                                                    style: 'background-image: none;',
                                                },
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Inicio Prev',
                                                    name: 'fecha_prev_inicio',
                                                    disabled: false,
                                                    anchor: '100%',
                                                    id: this.idContenedor + '_fecha_prev_inicio',
                                                    style: 'background-image: none;',
                                                    readOnly: true,
                                                },
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Fin Prev',
                                                    name: 'fecha_prev_fin',
                                                    disabled: false,
                                                    anchor: '100%',
                                                    id: this.idContenedor + '_fecha_prev_fin',
                                                    style: 'background-image: none;',
                                                    readOnly: true,
                                                },
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Inicio Real',
                                                    name: 'fecha_prog_inicio',
                                                    disabled: false,
                                                    anchor: '100%',
                                                    id: this.idContenedor + '_fecha_prog_inicio',
                                                    style: 'background-image: none;',
                                                    readOnly: true,
                                                },
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Fin Real',
                                                    name: 'fecha_prog_fin',
                                                    disabled: false,
                                                    anchor: '100%',
                                                    id: this.idContenedor + '_fecha_prog_fin',
                                                    style: 'background-image: none;',
                                                    readOnly: true,
                                                },

                                            ]
                                        })
                                    ]
                                })
                            ]
                        },
                            {
                                title: 'Procesos',
                                layout: 'fit',
                                defaults: {width: 400},
                                items: [
                                    new Ext.grid.GridPanel({
                                        layout: 'fit',
                                        store: this.storeProceso,
                                        region: 'center',
                                        trackMouseOver: false,
                                        split: true,
                                        border: false,
                                        plain: true,
                                        plugins: [],
                                        stripeRows: true,
                                        loadMask: true,
                                        columns: [
                                            new Ext.grid.RowNumberer(),
                                            {
                                                header: 'Proceso',
                                                dataIndex: 'id_proceso',
                                                width: 300,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    return String.format('{0}', record.data['proceso']);
                                                },
                                            },
                                            {
                                                header: 'Responsable',
                                                dataIndex: 'desc_funcionario',
                                                width: 300,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    return String.format('{0}', record.data['desc_funcionario']);
                                                },
                                            },
                                            {
                                                header: 'Estado Reg.',
                                                dataIndex: 'estado_reg',
                                                width: 100,
                                                sortable: false
                                            },
                                            {
                                                header: 'Creado por.',
                                                dataIndex: 'usr_reg',
                                                width: 100,
                                                sortable: false
                                            },
                                            {
                                                header: 'Fecha creación',
                                                dataIndex: 'fecha_reg',
                                                align: 'center',
                                                width: 110
                                            }
                                        ]
                                    })
                                ]
                            },
                            {
                                title: 'Responsables',
                                layout: 'fit',
                                region: 'center',
                                items: [
                                    new Ext.grid.GridPanel({
                                        layout: 'fit',
                                        store: this.storeEquipo,
                                        region: 'center',
                                        split: true,
                                        border: false,
                                        plain: true,
                                        plugins: [],
                                        stripeRows: true,
                                        trackMouseOver: false,
                                        columns: [
                                            new Ext.grid.RowNumberer(),
                                            {
                                                header: 'Tipo Auditor',
                                                dataIndex: 'id_parametro',
                                                width: 100,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    return String.format('{0}', record.data['valor_parametro'])
                                                },
                                            },
                                            {
                                                header: 'Funcionario',
                                                dataIndex: 'id_funcionario',
                                                width: 200,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    return String.format('{0}', record.data['desc_funcionario1'])
                                                },
                                            },
                                            {
                                                header: 'Interno',
                                                dataIndex: 'id_funcionario_interno',
                                                width: 150,
                                                sortable: false,
                                            },
                                            {
                                                header: 'Externo',
                                                dataIndex: 'exp_tec_externo',
                                                width: 150,
                                                sortable: false,
                                            },
                                            {
                                                header: 'Estado Reg.',
                                                dataIndex: 'estado_reg',
                                                width: 100,
                                                sortable: false
                                            },
                                            {
                                                header: 'Creado por.',
                                                dataIndex: 'usr_reg',
                                                width: 100,
                                                sortable: false
                                            },
                                            {
                                                header: 'Fecha creación',
                                                dataIndex: 'fecha_reg',
                                                align: 'center',
                                                width: 110
                                            }
                                        ]
                                    })
                                ]
                            },
                            {
                                title: 'Punto de Norma',
                                layout: 'fit',
                                region: 'center',
                                items: [
                                    new Ext.grid.GridPanel({
                                        layout: 'fit',
                                        store: this.storePuntoNorma,
                                        region: 'center',
                                        margins: '3 3 3 0',
                                        trackMouseOver: false,
                                        columns: [
                                            new Ext.grid.RowNumberer(),
                                            {
                                                header: 'Norma',
                                                dataIndex: 'id_norma',
                                                width: 150,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    let resultao = '';
                                                    if (this.sigla !== record.data['sigla_norma']) {
                                                        resultao = String.format('<b>{0}</b>', record.data['sigla_norma']);
                                                        this.sigla = record.data['sigla_norma']
                                                    }
                                                    return resultao
                                                }
                                            },
                                            {
                                                header: 'Codigo',
                                                dataIndex: 'codigo_pn',
                                                width: 100,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    return String.format('<span>{0}</span>', record.data['codigo_pn'])
                                                },

                                            },
                                            {
                                                header: 'Punto de Norma',
                                                dataIndex: 'id_pn',
                                                width: 350,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    return String.format('<span>{0}</span>', record.data['nombre_pn'])
                                                },
                                            },
                                            {
                                                header: 'Estado Reg.',
                                                dataIndex: 'estado_reg',
                                                width: 100,
                                                sortable: false
                                            },
                                            {
                                                header: 'Creado por.',
                                                dataIndex: 'usr_reg',
                                                width: 100,
                                                sortable: false
                                            },
                                            {
                                                header: 'Fecha creación',
                                                dataIndex: 'fecha_reg',
                                                align: 'center',
                                                width: 110
                                            }
                                        ]
                                    })
                                ]
                            },
                            {
                                title: 'Lista de Verificación',
                                layout: 'fit',
                                region: 'center',
                                items: [
                                    new Ext.grid.GridPanel({
                                        layout: 'fit',
                                        store: this.storePregunta,
                                        region: 'center',
                                        margins: '3 3 3 0',
                                        trackMouseOver: false,
                                        columns: [
                                            new Ext.grid.RowNumberer(),
                                            {
                                                header: 'Norma',
                                                dataIndex: 'id_norma',
                                                width: 150,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    return String.format('{0}', record.data['sigla_norma'])
                                                },
                                            },
                                            {
                                                header: 'Punto de Norma',
                                                dataIndex: 'id_pn',
                                                width: 300,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    return String.format('{0}', record.data['nombre_pn'])
                                                },
                                            },
                                            {
                                                header: 'Pregunta',
                                                dataIndex: 'id_pregunta',
                                                width: 300,
                                                sortable: false,
                                                renderer: function (value, p, record) {
                                                    return String.format('{0}', record.data['descrip_pregunta'])
                                                },
                                            },
                                            {
                                                header: 'Estado Reg.',
                                                dataIndex: 'estado_reg',
                                                width: 100,
                                                sortable: false
                                            },
                                            {
                                                header: 'Creado por.',
                                                dataIndex: 'usr_reg',
                                                width: 100,
                                                sortable: false
                                            },
                                            {
                                                header: 'Fecha creación',
                                                dataIndex: 'fecha_reg',
                                                align: 'center',
                                                width: 110
                                            }
                                        ]
                                    })
                                ]
                            },
                            {
                                title: 'Cronograma',
                                layout: 'fit',
                                region: 'center',
                                items: [
                                    crorograma
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
            this.storeProceso.baseParams.id_aom = record.id_aom;
            this.storeProceso.load();

            this.storeEquipo.baseParams.id_aom = record.id_aom;
            this.storeEquipo.load();

            this.storePuntoNorma.baseParams.id_aom = record.id_aom;
            this.storePuntoNorma.load();

            this.storeCronograma.baseParams.id_aom = record.id_aom;
            this.storeCronograma.load();


            this.formularioVentana = new Ext.Window({
                width: 750,
                height: 480,
                modal: true,
                maximizable: true,
                closeAction: 'hide',
                labelAlign: 'top',
                title: 'Auditoria Planificacion',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: [this.form_auditoria]
            });
        },
        formularioNoConformidad: function (data) {
            const maestro = this.sm.getSelected().data;
            const me = this;

            console.log(this.maestro)
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
                ]/*,
                tbar: [{
                    text: '<button class="btn"><i class="fa fa-edit fa-lg"></i>&nbsp;&nbsp;<b>Asignar / Designar Punto de Norma</b></button>',
                    scope: this,
                    width: '100',
                    handler: function() {
                        if(this.id_no_conformidad !==  null || data){
                            me.formularioPuntoNorma(data);
                            me.ventanaPuntoNorma.show();
                        }else{
                            alert('Tiene que registrar la no conformidad')
                        }
                    }
                }
                ]*/
            });
            const grilla = new Ext.grid.GridPanel({
                layout: 'fit',
                store: this.documentos,
                region: 'center',
                trackMouseOver: false,
                split: true,
                border: false,
                plain: true,
                plugins: [],
                stripeRows: true,
                loadMask: true,
                tbar: [{
                    text: '<button class="btn">&nbsp;&nbsp;<b>Nuevo</b></button>',
                    scope: this,
                    width: '100',
                    handler: function () {
                        this.onFormularioDocumento(data);
                    }
                },
                    {
                        text: '<button class="btn">&nbsp;&nbsp;<b>Eliminar</b></button>',
                        scope: this,
                        width: '100',
                        handler: function () {
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
                                    this.documentos.load({params: {start: 0, limit: 50}});
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
            this.isForm = new Ext.form.FormPanel({
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
                                            value: this.maestro.nro_tramite_wf,
                                            readOnly: true,
                                            style: 'background-image: none; background: #eeeeee;'
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Nombre Auditoria',
                                            name: 'nombre_aom1',
                                            anchor: '100%',
                                            value: maestro.nombre_aom1,
                                            readOnly: true,
                                            style: 'background-image: none; background: #eeeeee;'
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
                                            anchor: '100%',
                                            readOnly: true,
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
                                            readOnly: true,
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
                                            gwidth: 280,
                                            readOnly: true,
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'evidencia',
                                            fieldLabel: 'Evidencia',
                                            allowBlank: true,
                                            anchor: '100%',
                                            gwidth: 280,
                                            readOnly: true,
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'obs_consultor',
                                            fieldLabel: 'Observacion Consultor',
                                            allowBlank: true,
                                            anchor: '100%',
                                            gwidth: 150
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
            grilla.addListener('cellclick', this.oncellclicks, this);
            if (data) {
                this.isForm.getForm().findField('descrip_nc').setValue(data.descrip_nc);
                this.isForm.getForm().findField('evidencia').setValue(data.evidencia);
                this.isForm.getForm().findField('obs_consultor').setValue(data.obs_consultor);
                setTimeout(() => {
                    this.isForm.getForm().findField('id_parametro').setValue(data.id_parametro);
                    this.isForm.getForm().findField('id_parametro').setRawValue(data.valor_parametro);
                }, 1000);
                this.isForm.getForm().findField('calidad').setValue(this.onBool(data.calidad));
                this.isForm.getForm().findField('medio_ambiente').setValue(this.onBool(data.medio_ambiente));
                this.isForm.getForm().findField('seguridad').setValue(this.onBool(data.seguridad));
                this.isForm.getForm().findField('responsabilidad_social').setValue(this.onBool(data.responsabilidad_social));
                this.isForm.getForm().findField('sistemas_integrados').setRawValue(this.onBool(data.sistemas_integrados));
            }
            let id_funcionario = null;
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/getUo',
                params: {id_uo: maestro.id_uo},
                success: function (resp) {
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    this.isForm.getForm().findField('id_uo').setValue(reg.ROOT.datos.id_uo);
                    this.isForm.getForm().findField('id_uo').setRawValue(reg.ROOT.datos.nombre_unidad);
                    this.isForm.getForm().findField('id_funcionario').setValue(reg.ROOT.datos.desc_funcionario1);
                    id_funcionario = reg.ROOT.datos.id_funcionario;
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });

            this.isForm.getForm().findField('id_uo').on('select', function (combo, record, index) {
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
                height: 680,
                modal: false,
                minimizable: true,
                maximizable: true,
                closeAction: 'hide',
                labelAlign: 'bottom',
                title: 'Formulario',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: [this.isForm]
            });
        },
        successNoConformidad: function (resp) {
            Phx.CP.loadingHide();
            const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            this.cargaFormulario(reg.datos[0], this.isForm);
        },
        successRevision: function (resp) {
            Phx.CP.loadingHide();
            const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            this.cargaFormulario(reg.datos[0], this.form_auditoria);
        },
        oncellclicks: function (grid, rowIndex, columnIndex, e) {

            var record = this.documentos.getAt(rowIndex),
                fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name

            if (fieldName == 'nro_tramite_ori' && record.data.id_proceso_wf_ori) {
                //open documentos de origen
                this.loadCheckDocumentosSolWf(record);
            } else if (fieldName == 'upload') {

                if (record.data.solo_lectura == 'no' && !record.data.id_proceso_wf_ori) {
                    this.SubirArchivo(record);
                    // this.onSubirDocumento(record.data);
                }
            } else if (fieldName == 'modificar') {
                if (record.data['modificar'] == 'si') {

                    this.cambiarMomentoClick(record);

                }
            } else if (fieldName == 'chequeado') {
                if (record.data['extension'].length != 0) {
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


                } else if (record.data['tipo_documento'] == 'generado') {
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
        cargaFormulario: function (data, formulario) {
            var obj, key;
            Ext.each(formulario.getForm().items.keys, function (element, index) {
                obj = Ext.getCmp(element);
                if (obj && obj.items) {
                    Ext.each(obj.items.items, function (elm, b, c) {
                        if (elm.getXType() == 'combo' && elm.mode == 'remote' && elm.store != undefined) {
                            if (!elm.store.getById(data[elm.name])) {
                                rec = new Ext.data.Record({
                                    [elm.displayField]: data[elm.gdisplayField],
                                    [elm.valueField]: data[elm.name]
                                }, data[elm.name]);
                                elm.store.add(rec);
                                elm.store.commitChanges();
                                elm.modificado = true;
                            }
                        }
                        elm.setValue(data[elm.name]);
                    }, this);
                } else {
                    key = element.replace(this.idContenedor + '_', '');
                    if (obj) {
                        if ((obj.getXType() == 'combo' && obj.mode == 'remote' && obj.store != undefined) || key == 'id_centro_costo') {
                            if (!obj.store.getById(data[key])) {
                                rec = new Ext.data.Record({
                                    [obj.displayField]: data[obj.gdisplayField],
                                    [obj.valueField]: data[key]
                                }, data[key]);
                                obj.store.add(rec);
                                obj.store.commitChanges();
                                obj.modificado = true;
                            }
                        }
                        obj.setValue(data[key]);
                    }
                }
            }, this);
        },
        onBool: function (valor) {
            return valor === 't';
        },
        onFormularioTodo: function () {
            const me = this;
            Phx.CP.loadingShow();
            const informe = {
                fieldLabel: 'Informe',
                xtype: 'box',
                autoEl: {
                    tag: 'a',
                    html: this.maestro.nombre_aom1 + ' ' + this.maestro.nro_tramite_wf,
                },
                style: 'cursor:pointer;',
                listeners: {
                    render: function (component) {
                        component.getEl().on('click', function (e) {


                        });
                    }
                }
            };
            const area = new Ext.form.TextField({
                name: 'area',
                msgTarget: 'title',
                fieldLabel: 'Area',
                allowBlank: true,
                readOnly: true,
                anchor: '100%',
                style: 'background-image: none;',
                value: this.maestro.nombre_unidad,
                maxLength: 50
            });
            const responsable_area = new Ext.form.TextField({
                name: 'responsable_area',
                msgTarget: 'title',
                fieldLabel: 'Responsable area',
                allowBlank: true,
                readOnly: true,
                anchor: '100%',
                style: 'background-image: none;',
                // value: this.maestro.desc_funcionario_destinatario,
                maxLength: 50
            });
            const storeCombo = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/NoConformidad/listarFuncionariosUO',
                id: 'id_funcionario',
                root: 'datos',
                sortInfo: {
                    field: 'desc_funcionario',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_funcionario', 'desc_funcionario', 'desc_funcionario_cargo'],
                remoteSort: true,
                baseParams: {par_filtro: 'vfc.desc_funcionario1 '}
            });

            const combo = new Ext.form.ComboBox({
                name: 'id_funcionario_nc',
                fieldLabel: 'Responsable de No Conformidad',
                allowBlank: false,
                typeAhead: true,
                store: storeCombo,
                mode: 'remote',
                pageSize: 15,
                triggerAction: 'all',
                valueField: 'id_funcionario',
                displayField: 'desc_funcionario',
                forceSelection: true,
                anchor: '100%',
                resizable: true,
                enableMultiSelect: false
            });

            this.formTodoAceptar = new Ext.form.FormPanel({
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                autoScroll: true,
                region: 'center',
                defaults: {height: 450},
                items: [
                    new Ext.form.FieldSet({
                        collapsible: false,
                        title: 'Datos Generales',
                        border: true,
                        layout: 'form',
                        items: [
                            informe,
                            area,
                            responsable_area,
                            combo
                        ]
                    })
                ]
            });

            this.ventanaTodoAcep = new Ext.Window({
                title: 'Asignar Responsable No Conformidad',
                width: 600,
                height: 250,
                closeAction: 'hide',
                labelAlign: 'bottom',
                items: this.formTodoAceptar,
                modal: true,
                bodyStyle: 'padding:5px',
                layout: 'form',
                buttons: [{
                    text: 'Guardar',
                    handler: this.saveResponsableTodo,
                    scope: this
                },
                    {
                        text: 'Cancelar',
                        handler: function () {
                            this.ventanaTodoAcep.hide()
                        },
                        scope: this
                    }]
            });

            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/listarRespAreaGerente',
                params: {
                    id_uo: this.maestro.id_uo
                },
                success: function (resp) {
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    this.formTodoAceptar.getForm().findField('responsable_area').setValue(reg.ROOT.datos.desc_funcionario);
                    Phx.CP.loadingHide();
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
            this.cmpResponsable = this.formTodoAceptar.getForm().findField('id_funcionario_nc');
        },
        saveResponsableTodo: function () {
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/siTodoNoConformidad',
                params: {
                    id_aom: this.maestro.id_aom,
                    id_funcionario_nc: this.cmpResponsable.getValue()
                },
                success: this.successWizard,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
    };
</script>
