<?php
/**
 * @package pXP
 * @file gen-Parametro.php
 * @author  (max.camacho)
 * @date 03-07-2019 16:18:31
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.Parametro = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                this.initButtons = [this.cmbTipoParametro];
                Phx.vista.Parametro.superclass.constructor.call(this, config);
                this.cmbTipoParametro.on('select', function (combo, record, index) {
                    // this.tmpGestion = record.data.gestion;
                    this.store.removeAll();
                    this.capturaFiltros();
                }, this);
                this.init();
            },

            Atributos: [
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_parametro'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_tipo_parametro'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'descrip_parametro',
                        fieldLabel: 'Tipo Parametro',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 200,
                    },
                    type: 'TextField',
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'valor_parametro',
                        fieldLabel: 'Parametro',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 200,
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'prm.valor_parametro', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'codigo_parametro',
                        fieldLabel: 'Codigo Parametro',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 200,
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'prm.codigo_parametro', type: 'string'},
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
                    filters: {pfiltro: 'prm.estado_reg', type: 'string'},
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
                    filters: {pfiltro: 'prm.fecha_reg', type: 'date'},
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
                    filters: {pfiltro: 'prm.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'prm.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
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
                    filters: {pfiltro: 'prm.fecha_mod', type: 'date'},
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
                }
            ],
            tam_pag: 50,
            title: 'Parametro',
            ActSave: '../../sis_auditoria/control/Parametro/insertarParametro',
            ActDel: '../../sis_auditoria/control/Parametro/eliminarParametro',
            ActList: '../../sis_auditoria/control/Parametro/listarParametro',
            id_store: 'id_parametro',
            fields: [
                {name: 'id_parametro', type: 'numeric'},
                {name: 'id_tipo_parametro', type: 'numeric'},
                {name: 'estado_reg', type: 'string'},
                {name: 'valor_parametro', type: 'string'},
                {name: 'codigo_parametro', type: 'string'},
                //{name:'tipo_parametro', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'tipo_parametro', type: 'string'},
                {name: 'descrip_parametro', type: 'string'},

            ],
            sortInfo: {
                field: 'id_parametro',
                direction: 'ASC'
            },
            bdel: true,
            bsave: false,
            onButtonNew: function () {
                if (!this.validarFiltros()) {
                    alert('Especifique el tipo paramtro')
                } else {
                    Phx.vista.Parametro.superclass.onButtonNew.call(this);
                    this.Cmp.id_tipo_parametro.setValue(this.cmbTipoParametro.getValue());
                    this.Cmp.codigo_parametro.enable();
                }
            },
            onButtonEdit: function () {
                Phx.vista.Parametro.superclass.onButtonEdit.call(this);
                this.Cmp.id_tipo_parametro.setValue(this.cmbTipoParametro.getValue());
                this.Cmp.codigo_parametro.disable();
            },
            preparaMenu: function (n) {
                Phx.vista.Parametro.superclass.preparaMenu.call(this, n);
                this.getBoton('edit').enable();
                this.getBoton('del').enable();
            },
            liberaMenu: function () {
                var tb = Phx.vista.Parametro.superclass.liberaMenu.call(this);
                if (tb) {
                    this.getBoton('edit').disable();
                    this.getBoton('del').disable();
                }
            },
            capturaFiltros: function (combo, record, index) {
                if (this.validarFiltros()) {
                    this.store.baseParams.id_tipo_parametro = this.cmbTipoParametro.getValue();
                    this.getBoton('edit').enable();
                    this.getBoton('del').enable();
                    this.load({params: {start: 0, limit: this.tam_pag}})
                }
            },
            validarFiltros: function () {
                return !!this.cmbTipoParametro.validate();
            },
            onButtonAct: function () {
                if (!this.validarFiltros()) {
                    alert('Especifique el tipo paramtro')
                } else {
                    this.store.baseParams.id_tipo_parametro = this.cmbTipoParametro.getValue();
                    Phx.vista.Parametro.superclass.onButtonAct.call(this);
                }
            },
            cmbTipoParametro: new Ext.form.ComboBox({
                fieldLabel: 'Tipo Parametro',
                allowBlank: false,
                emptyText: 'Tipo Parametro...',
                blankText: 'Parametro',
                grupo: [0, 1, 2, 3, 4],
                store: new Ext.data.JsonStore({
                    url: '../../sis_auditoria/control/TipoParametro/listarTipoParametro',
                    id: 'id_tipo_parametro',
                    root: 'datos',
                    sortInfo: {
                        field: 'descrip_parametro',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_tipo_parametro', 'tipo_parametro', 'descrip_parametro'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'tpr.id_tipo_parametro'}
                }),
                valueField: 'id_tipo_parametro',
                triggerAction: 'all',
                displayField: 'descrip_parametro',
                hiddenName: 'id_tipo_parametro',
                mode: 'remote',
                pageSize: 50,
                queryDelay: 500,
                listWidth: '280',
                width: 200
            }),
        }
    )
</script>
		
		