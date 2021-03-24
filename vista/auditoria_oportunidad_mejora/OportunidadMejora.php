<?php
/**
 * @package pXP
 * @file OportunidadMejora.php
 * @author MMV
 * @date 21/04/2020
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.OportunidadMejora = Ext.extend(Phx.gridInterfaz, {
            dblclickEdit: true,
            constructor: function (config) {
                this.eventoGrill();
                this.idContenedor = config.idContenedor;
                this.maestro = config.maestro;
                Phx.vista.OportunidadMejora.superclass.constructor.call(this, config);
                this.init();
                this.iniciarEventoOM();
                this.addButton('sig_estado', {
                    text: 'Aprobar',
                    grupo: [0],
                    iconCls: 'bok',
                    disabled: true,
                    handler: this.sigEstado,
                    tooltip: '<b>APROBAR</b> la programacion de esta oportunidad de mejora</b>'
                });
                this.store.baseParams.interfaz = 'OportunidadMejora';
                this.load({params: {start: 0, limit: this.tam_pag}})
            },
            Atributos: [
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_aom'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_proceso_wf'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_estado_wf'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_tipo_auditoria'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'nro_tramite_wf'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'estado_wf'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'codigo_tpo_aom',
                        fieldLabel: 'Tipo',
                        allowBlank: true,
                        anchor: '50%',
                        gwidth: 40,
                        renderer: function (value, p, record) {
                            var color = '#575F90';
                            return '<font color="' + color + '">' + record.data['codigo_tpo_aom'] + '</font>';
                        }
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'aom.nro_tramite_wf', type: 'string'},
                    id_grupo: 0,
                    grid: false,
                    form: false,
                },
                {
                    config: {
                        name: 'id_tipo_om',
                        fieldLabel: 'Tipo OM',
                        allowBlank: false,
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
                            fields: ['id_parametro', 'tipo_parametro', 'valor_parametro', 'codigo_parametro'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'prm.id_tipo_parametro', tipo_parametro: 'TIPO_OPORTUNIDAD_MEJORA'}
                        }),
                        valueField: 'id_parametro',
                        displayField: 'valor_parametro',
                        gdisplayField: 'desc_tipo_om',
                        hiddenName: 'id_tipo_om',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 200,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('<div class="gridmultiline">{0}</div>', record.data['desc_tipo_om']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'movtip.nombre', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'nro_tramite',
                        fieldLabel: 'Codigo',
                        allowBlank: true,
                        width: 130,
                        gwidth: 140,
                        readOnly: true,
                        style: 'background-image: none; border: 0;',
                        renderer: function (value, p, record) {
                            return String.format('<a style="cursor:pointer;">{0}</a>', value);
                        },
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'aom.nro_tramite', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    form: true,
                    bottom_filter: true
                },
                {
                    config: {
                        name: 'nombre_estado',
                        fieldLabel: 'Estado',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 180,
                        readOnly: true,
                        style: 'background-image: none; border: 0; color: #0C07F1; font-weight: bold;',
                        renderer: function (value, p, record) {
                            return String.format('<a style="cursor:pointer;">{0}</a>', value)
                        }
                    },
                    type: 'TextField',
                    id_grupo: 0,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_uo',
                        fieldLabel: 'Area',
                        tinit: false,
                        resizable: true,
                        tasignacion: false,
                        allowBlank: false,
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
                            fields: ['id_uo', 'nombre_unidad', 'codigo'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'uo.nombre_unidad#uo.codigo', nivel: '2,4'}
                        }),
                        valueField: 'id_uo',
                        displayField: 'nombre_unidad',
                        gdisplayField: 'nombre_unidad',
                        hiddenName: 'id_uo',
                        tpl: '<tpl for="."><div class="x-combo-list-item">' +
                            '<p>{codigo} - {nombre_unidad}</p> ' +
                            '</div>' +
                            '</tpl>',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 300,
                        listWidth: '500',
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('<a style="cursor:pointer;">{0}</a>', record.data['nombre_unidad']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'df.desc_funcionario1', type: 'string'},
                    grid: true,
                    form: true,
                    bottom_filter: true
                },
                {
                    config: {
                        name: 'id_gconsultivo',
                        fieldLabel: 'Grupo Consultivo',
                        allowBlank: true,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_auditoria/control/GrupoConsultivo/listarGrupoConsultivo',
                            id: 'id_gconsultivo',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre_gconsultivo',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_gconsultivo', 'nombre_gconsultivo', 'requiere_programacion', 'requiere_formulario', 'nombre_programacion', 'nombre_formulario'],//208
                            remoteSort: true,
                            baseParams: {par_filtro: 'gct.nombre_gconsultivo'}
                        }),
                        valueField: 'id_gconsultivo',
                        displayField: 'nombre_gconsultivo',
                        gdisplayField: 'nombre_gconsultivo',
                        hiddenName: 'id_gconsultivo',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 10,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 200,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['nombre_gconsultivo']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'movtip.nombre', type: 'string'},
                    grid: false,
                    form: true
                },
                {
                    config: {
                        name: 'nombre_aom1',
                        fieldLabel: 'Nombre de Auditoría ',
                        allowBlank: false,
                        anchor: '80%',
                        emptyText: 'Intruzca titulo...',
                        gwidth: 280,
                        renderer: function (value, p, record) {
                            return String.format('<a style="cursor:pointer;">{0}</a>', value);
                        },

                    },
                    type: 'TextField',
                    filters: {pfiltro: 'aom.nombre_aom1', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    form: true,
                    bottom_filter: true
                },
                {
                    config: {
                        name: 'fecha_prog_inicio',
                        fieldLabel: 'Fecha Inicio',
                        allowBlank: false,
                        anchor: '50%',
                        gwidth: 80,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'aom.fecha_prog_inicio', type: 'date'},
                    id_grupo: 0,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'fecha_prog_fin',
                        fieldLabel: 'Fecha Fin',
                        allowBlank: false,
                        anchor: '50%',
                        gwidth: 80,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'aom.fecha_prog_fin', type: 'date'},
                    id_grupo: 0,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_destinatario',
                        fieldLabel: 'Destinatario',
                        allowBlank: false,
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
                            baseParams: {par_filtro: 'fu.desc_funcionario1', codigo: 'RESP'}
                        }),
                        valueField: 'id_funcionario',
                        displayField: 'desc_funcionario1',
                        gdisplayField: 'desc_funcionario_destinatario',
                        hiddenName: 'id_destinatario',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 300,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('<b>{0}</b>', record.data['desc_funcionario_destinatario']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'vfc.desc_funcionario1', type: 'string'},
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'descrip_aom1',
                        fieldLabel: 'Descripcion',
                        allowBlank: true,
                        resizable: true,
                        anchor: '80%',
                        gwidth: 350,
                        renderer: function (value, p, record) {
                            return String.format('<div class="gridmultiline" style="text-align: justify;">{0}</div>', record.data['descrip_aom1']);
                        }
                    },
                    type: 'TextArea',
                    filters: {pfiltro: 'aom.descrip_aom1', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_funcionario',
                        fieldLabel: 'Responsable',
                        allowBlank: false,
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
                            fields: ['id_funcionario', 'desc_funcionario1', 'descripcion_cargo', 'cargo_equipo', 'codigo', 'gerencia'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'fun.desc_funcionario1'}
                        }),
                        valueField: 'id_funcionario',
                        displayField: 'desc_funcionario1',
                        gdisplayField: 'desc_funcionario2',
                        hiddenName: 'id_funcionario',
                        tpl: '<tpl for="."><div class="x-combo-list-item">' +
                            '<p>Nombre: <span style="color: #036419">{desc_funcionario1}</span></p> ' +
                            '<p>Cargo: <span style="color: mediumblue">{descripcion_cargo}</span></p>' +
                            '</div>' +
                            '</tpl>',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        // modificado: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        listWidth: '380',
                        gwidth: 300,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['desc_funcionario2']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'df.desc_funcionario1', type: 'string'},
                    grid: true,
                    form: false,
                    bottom_filter: true
                },
                {
                    config: {
                        name: 'fecha_prev_inicio',
                        fieldLabel: 'Fecha Inicio',
                        allowBlank: false,
                        anchor: '50%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'aom.fecha_prev_inicio', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'fecha_prev_fin',
                        fieldLabel: 'Fecha Fin',
                        allowBlank: false,
                        anchor: '50%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'aom.fecha_prev_fin', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'lugar',
                        fieldLabel: 'Lugar',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 200
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'aom.lugar', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'recomendacion',
                        fieldLabel: 'Recomendacion',
                        allowBlank: true,
                        anchor: '80%',
                        height: 200,
                        gwidth: 200
                    },
                    type: 'TextArea',
                    filters: {pfiltro: 'aom.recomendacion', type: 'string'},
                    rows: 50,
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'resumen',
                        fieldLabel: 'Resumen',
                        allowBlank: true,
                        anchor: '80%',
                        height: 200,
                        gwidth: 200
                    },
                    type: 'TextArea',
                    filters: {pfiltro: 'aom.resumen', type: 'string'},
                    rows: 50,
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'id_tnorma',
                        fieldLabel: 'Tipo de auditoria',
                        allowBlank: false,
                        resizable: true,
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
                            fields: ['id_parametro', 'tipo_parametro', 'valor_parametro'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'prm.id_parametro', tipo_parametro: 'TIPO_NORMA'}
                        }),
                        valueField: 'id_parametro',
                        displayField: 'valor_parametro',
                        gdisplayField: 'desc_tipo_norma',
                        hiddenName: 'id_parametro',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '60%',
                        gwidth: 200,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['desc_tipo_norma']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 1,
                    filters: {pfiltro: 'movtip.nombre', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_tobjeto',
                        fieldLabel: 'Objeto Auditoria',
                        allowBlank: false,
                        resizable: true,
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
                            fields: ['id_parametro', 'tipo_parametro', 'valor_parametro'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'prm.id_parametro', tipo_parametro: 'OBJETO_AUDITORIA'}
                        }),
                        valueField: 'id_parametro',
                        displayField: 'valor_parametro',
                        gdisplayField: 'desc_tipo_objeto',
                        hiddenName: 'id_tobjeto',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '60%',
                        gwidth: 200,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['desc_tipo_objeto']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 1,
                    filters: {pfiltro: 'movtip.nombre', type: 'string'},
                    grid: true,
                    form: true
                },

                {
                    config: {
                        name: 'fecha_eje_inicio',
                        fieldLabel: 'Fecha Ej. Inicio',
                        allowBlank: true,
                        anchor: '50%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'aom.fecha_eje_inicio', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'fecha_eje_fin',
                        fieldLabel: 'Fecha Ej. Fin',
                        allowBlank: true,
                        anchor: '50%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'aom.fecha_eje_fin', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'aom.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'aom.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 300
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'aro.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu1.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu2.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'aom.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            tam_pag: 50,
            title: 'AUDITORIA PROGRAMADA',
            id: 'id_aom',
            ActSave: '../../sis_auditoria/control/AuditoriaOportunidadMejora/insertarAuditoriaOportunidadMejora',
            ActDel: '../../sis_auditoria/control/AuditoriaOportunidadMejora/eliminarAuditoriaOportunidadMejora',
            ActList: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarAuditoriaOportunidadMejora',
            id_store: 'id_aom',
            fields: [
                {name: 'id_aom', type: 'numeric'},
                {name: 'id_proceso_wf', type: 'numeric'},
                {name: 'nro_tramite_wf', type: 'string'},
                {name: 'id_funcionario', type: 'numeric'},
                {name: 'fecha_prog_inicio', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'recomendacion', type: 'string'},
                {name: 'id_uo', type: 'numeric'},
                {name: 'id_gconsultivo', type: 'numeric'},
                {name: 'fecha_prev_inicio', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'fecha_prev_fin', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'fecha_prog_fin', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'nombre_aom1', type: 'string'},
                {name: 'estado_reg', type: 'string'},
                {name: 'estado_wf', type: 'string'},
                {name: 'id_tobjeto', type: 'string'},
                {name: 'id_estado_wf', type: 'numeric'},
                {name: 'id_tnorma', type: 'string'},
                {name: 'fecha_eje_inicio', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'codigo_aom', type: 'string'},
                {name: 'id_tipo_auditoria', type: 'numeric'},
                {name: 'descrip_aom1', type: 'string'},
                {name: 'lugar', type: 'string'},
                {name: 'id_tipo_om', type: 'numeric'},
                {name: 'formulario_ingreso', type: 'string'},
                {name: 'estado_form_ingreso', type: 'numeric'},
                {name: 'fecha_eje_fin', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'tipo_auditoria', type: 'string'},
                {name: 'nombre_unidad', type: 'string'},
                {name: 'nombre_gconsultivo', type: 'string'},
                {name: 'desc_funcionario2', type: 'string'},
                {name: 'desc_tipo_objeto', type: 'string'},
                {name: 'desc_tipo_norma', type: 'string'},
                {name: 'codigo_parametro', type: 'string'},
                {name: 'desc_tipo_om', type: 'string'},
                {name: 'codigo_tpo_aom', type: 'string'},
                {name: 'contador_estados', type: 'numeric'},
                {name: 'nombre_estado', type: 'string'},
                {name: 'id_destinatario', type: 'numeric'},
                {name: 'desc_funcionario_destinatario', type: 'string'},
                {name: 'resumen', type: 'string'},
                {name: 'nro_tramite', type: 'string'}
            ],
            sortInfo: {
                field: 'id_aom',
                direction: 'DESC'
            },
            fheight: '60%',
            bdel: true,
            bsave: false,

            iniciarEventoOM: function () {
                this.ocultarComponente(this.Cmp.lugar);
                this.ocultarComponente(this.Cmp.id_tnorma);
                this.ocultarComponente(this.Cmp.id_tobjeto);

                this.ocultarComponente(this.Cmp.fecha_prog_inicio);
                this.ocultarComponente(this.Cmp.fecha_prog_fin);
                this.ocultarComponente(this.Cmp.fecha_eje_inicio);
                this.ocultarComponente(this.Cmp.fecha_eje_fin);
            },
            eventoGrill: function () {
                this.Atributos[this.getIndAtributo('descrip_aom1')].grid = false;
                this.Atributos[this.getIndAtributo('lugar')].grid = false;
                this.Atributos[this.getIndAtributo('recomendacion')].grid = false;
                this.Atributos[this.getIndAtributo('id_gconsultivo')].grid = false;
                this.Atributos[this.getIndAtributo('id_tnorma')].grid = false;
                this.Atributos[this.getIndAtributo('id_tobjeto')].grid = false;
                this.Atributos[this.getIndAtributo('fecha_prev_inicio')].grid = false;
                this.Atributos[this.getIndAtributo('fecha_prev_fin')].grid = false;
                this.Atributos[this.getIndAtributo('fecha_eje_inicio')].grid = false;
                this.Atributos[this.getIndAtributo('fecha_eje_fin')].grid = false;
                this.Atributos[this.getIndAtributo('id_funcionario')].grid = false;
                this.Atributos[this.getIndAtributo('id_destinatario')].grid = false;
                this.Atributos[this.getIndAtributo('resumen')].grid = false;
            },
            onButtonNew: function () {
                Phx.vista.OportunidadMejora.superclass.onButtonNew.call(this);
                this.Cmp.id_tipo_auditoria.setValue(2);
                this.ocultarComponente(this.Cmp.nro_tramite);
                this.ocultarComponente(this.Cmp.nombre_estado);
                const sefl = this;
                this.Cmp.id_tipo_om.on('select', function (combo, record, index) {
                    Ext.Ajax.request({
                        url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getCorrelativo',
                        params: {id_tipo_auditoria: 0, codigo: record.data.codigo_parametro},
                        success: function (resp) {
                            const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                            this.Cmp.nro_tramite.setValue(reg.ROOT.datos.correlativo);
                            sefl.Cmp.nombre_estado.setValue('Programada');
                            sefl.mostrarComponente(sefl.Cmp.nro_tramite);
                            sefl.mostrarComponente(sefl.Cmp.nombre_estado);
                        },
                        failure: this.conexionFailure,
                        timeout: this.timeout,
                        scope: this
                    });
                }, this);
            },
            onReloadPage: function (m) {
                this.maestro = m;
                this.store.baseParams = {
                    tipo_filtro: this.maestro.tipo_filtro,
                    id_gestion: this.maestro.id_gestion,
                    desde: this.maestro.desde,
                    hasta: this.maestro.hasta,
                    tipo_estado: this.maestro.id_tipo_estado,
                    id_uo: this.maestro.id_uo,
                    start: 0,
                    limit: 50,
                    sort: 'id_aom',
                    dir: 'DESC',
                    interfaz: 'OportunidadMejora',
                    contenedor: this.idContenedor
                };
                this.store.reload({params: this.store.baseParams});
            },
            west: {
                url: '../../../sis_auditoria/vista/auditoria_oportunidad_mejora/filter/FormFiltro.php',
                width: '25%',
                title: 'Filtrar Datos',
                collapsed: false,
                cls: 'FormFiltro'
            },
            sigEstado: function () {
                Phx.CP.loadingShow();
                const rec = this.sm.getSelected();
                const id_estado_wf = rec.data.id_estado_wf;
                const id_proceso_wf = rec.data.id_proceso_wf;
                if (confirm('¿Desea APROBAR la Oportunidad de mejora')) {
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
                } else {
                    Phx.CP.loadingHide();
                }
            },
            successWizard: function () {
                Phx.CP.loadingHide();
                this.reload();
            },
            onButtonEdit: function () {
                Phx.vista.OportunidadMejora.superclass.onButtonEdit.call(this);
            },
            preparaMenu: function (n) {
                const tb = this.tbar;
                Phx.vista.OportunidadMejora.superclass.preparaMenu.call(this, n);
                this.getBoton('sig_estado').enable();
                // this.getBoton('btnChequeoDocumentosWf').enable();
                // this.getBoton('diagrama_gantt').enable();
                // this.getBoton('ant_estado').enable();
                return tb
            },
            liberaMenu: function () {
                const tb = Phx.vista.OportunidadMejora.superclass.liberaMenu.call(this);
                if (tb) {
                    this.getBoton('sig_estado').disable();
                    // this.getBoton('btnChequeoDocumentosWf').disable();
                    // this.getBoton('diagrama_gantt').disable();
                    // this.getBoton('ant_estado').disable();
                }
                return tb
            },
        }
    )
</script>
