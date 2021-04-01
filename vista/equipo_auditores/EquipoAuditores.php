<?php
/**
 * @package pXP
 * @file gen-EquipoAuditores.php
 * @author  (admin.miguel)
 * @date 03-09-2020 16:11:03
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                03-09-2020                 (admin.miguel)                CREACION
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.EquipoAuditores = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.EquipoAuditores.superclass.constructor.call(this, config);
                this.init();
                this.load({params: {start: 0, limit: this.tam_pag}})
            },

            Atributos: [
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_equipo_auditores'
                    },
                    type: 'Field',
                    form: true
                },

                {
                    config: {
                        name: 'id_funcionario',
                        fieldLabel: 'Funcionario',
                        allowBlank: true,
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
                            fields: ['id_funcionario', 'desc_funcionario1', 'codigo'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'fc.desc_funcionario1#fc.codigo'}
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
                        anchor: '100%',
                        gwidth: 300,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['desc_funcionario1']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'fun.desc_funcionario1', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'descripcion_cargo',
                        fieldLabel: 'Cargo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'fun.descripcion_cargo', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'email_empresa',
                        fieldLabel: 'Correo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 250,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'fun.email_empresa', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_tipo_participacion',
                        fieldLabel: 'Tipo',
                        allowBlank: true,
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
                            baseParams: {par_filtro: 'prm.id_tipo_parametro', tipo_parametro: 'TIPO_PARTICIPACION'}
                        }),
                        valueField: 'id_parametro',
                        displayField: 'valor_parametro',
                        gdisplayField: 'desc_tipo',
                        hiddenName: 'id_tipo_participacion',
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
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['desc_tipo']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'pa.valor_parametro', type: 'string'},
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
                    filters: {pfiltro: 'eus.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'obs_dba',
                        fieldLabel: 'obs_dba',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'eus.obs_dba', type: 'string'},
                    id_grupo: 1,
                    grid: false,
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
                    filters: {pfiltro: 'eus.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'eus.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
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
                    filters: {pfiltro: 'eus.usuario_ai', type: 'string'},
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
                    filters: {pfiltro: 'eus.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            tam_pag: 50,
            title: 'Equipo Aduitores',
            ActSave: '../../sis_auditoria/control/EquipoAuditores/insertarEquipoAuditores',
            ActDel: '../../sis_auditoria/control/EquipoAuditores/eliminarEquipoAuditores',
            ActList: '../../sis_auditoria/control/EquipoAuditores/listarEquipoAuditores',
            id_store: 'id_equipo_auditores',
            fields: [
                {name: 'id_equipo_auditores', type: 'numeric'},
                {name: 'estado_reg', type: 'string'},
                {name: 'obs_dba', type: 'string'},
                {name: 'id_funcionario', type: 'numeric'},
                {name: 'id_tipo_participacion', type: 'numeric'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'desc_funcionario1', type: 'string'},
                {name: 'descripcion_cargo', type: 'string'},
                {name: 'email_empresa', type: 'string'},
                {name: 'desc_tipo', type: 'string'},

            ],
            sortInfo: {
                field: 'id_equipo_auditores',
                direction: 'ASC'
            },
            bdel: true,
            bsave: false,
            tabsouth: [
                {
                    url: '../../../sis_auditoria/vista/competencia/Competencia.php',
                    title: 'Competencia',
                    height: '50%',
                    cls: 'Competencia'
                }
            ],
            onButtonNew: function () {
                Phx.vista.EquipoAuditores.superclass.onButtonNew.call(this);
                this.mostrarComponente(this.Cmp.id_funcionario);
            },
            onButtonEdit: function () {
                Phx.vista.EquipoAuditores.superclass.onButtonEdit.call(this);
                this.ocultarComponente(this.Cmp.id_funcionario);
            },
        }
    )
</script>
		
		