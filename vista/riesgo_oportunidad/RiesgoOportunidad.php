<?php
/**
 * @package pXP
 * @file gen-RiesgoOportunidad.php
 * @author  (max.camacho)
 * @date 16-12-2019 17:57:34
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                16-12-2019                 (max.camacho)                CREACION
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.RiesgoOportunidad = Ext.extend(Phx.gridInterfaz, {
            id_tipo_ro_maestro: null,
            id_ro: null,
            constructor: function (config) {
                this.maestro = config.maestro;
                this.id_tipo_ro_maestro = config.data.id_tipo_ro;
                this.id_ro = config.data.id_ro;
                Phx.vista.RiesgoOportunidad.superclass.constructor.call(this, config);
                this.init()
                this.store.baseParams.id_tipo_ro = this.id_tipo_ro_maestro;
                this.load({params: {start: 0, limit: this.tam_pag}});
            },
            Atributos: [
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_ro'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_tipo_ro'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'desc_tipo_ro',
                        fieldLabel: 'Tipo Riesgo Oportunidad',
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
                        name: 'nombre_ro',
                        fieldLabel: 'Nombre RO',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 200,
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'riop.nombre_ro', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'codigo_ro',
                        fieldLabel: 'Codigo RO',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 150
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'riop.codigo_ro', type: 'string'},
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
                    filters: {pfiltro: 'riop.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: '',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'riop.id_usuario_ai', type: 'numeric'},
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
                    filters: {pfiltro: 'riop.usuario_ai', type: 'string'},
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
                    filters: {pfiltro: 'riop.fecha_reg', type: 'date'},
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
                    filters: {pfiltro: 'riop.fecha_mod', type: 'date'},
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
            title: 'Riesgo Oportunidad',
            ActSave: '../../sis_auditoria/control/RiesgoOportunidad/insertarRiesgoOportunidad',
            ActDel: '../../sis_auditoria/control/RiesgoOportunidad/eliminarRiesgoOportunidad',
            ActList: '../../sis_auditoria/control/RiesgoOportunidad/listarRiesgoOportunidad',
            id_store: 'id_ro',
            fields: [
                {name: 'id_ro', type: 'numeric'},
                {name: 'id_tipo_ro', type: 'numeric'},
                {name: 'nombre_ro', type: 'string'},
                {name: 'codigo_ro', type: 'string'},
                {name: 'estado_reg', type: 'string'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'tipo_ro', type: 'string'},
                {name: 'desc_tipo_ro', type: 'string'},

            ],
            sortInfo: {
                field: 'id_ro',
                direction: 'DESC'
            },
            bdel: true,
            bsave: false,
            onButtonNew: function () {
                Phx.vista.RiesgoOportunidad.superclass.onButtonNew.call(this);
                this.Cmp.id_tipo_ro.setValue(this.id_tipo_ro_maestro);
                this.Cmp.codigo_ro.enable();
            },
            onButtonEdit: function () {
                Phx.vista.RiesgoOportunidad.superclass.onButtonEdit.call(this);
                this.Cmp.id_tipo_ro.setValue(this.id_tipo_ro_maestro);
                this.Cmp.codigo_ro.disable();
            },
            successSave: function (resp) {
                this.store.rejectChanges();
                Phx.CP.loadingHide();
                if (resp.argument && resp.argument.news) {
                    if (resp.argument.def == 'reset') {
                        //this.form.getForm().reset();
                        this.onButtonNew();
                    }

                    //this.loadValoresIniciales() //RAC 02/06/2017  esta funcion se llama dentro del boton NEW
                } else {
                    this.window.hide();
                }
                this.id_ro.modificado = true;
                this.id_ro.reset();
                this.reload();

            },
        // funcion que corre cuando se elimina con exito
        successDel:function(resp){
            //console.log(resp)
            Phx.CP.loadingHide();
            //this.sm.fireEvent('rowdeselect',this.sm);
            this.id_ro.modificado = true;
            this.id_ro.reset();
            this.reload();

        },
        }
    )
</script>
		
		