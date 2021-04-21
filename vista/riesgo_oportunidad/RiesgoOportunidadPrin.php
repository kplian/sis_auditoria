<?php
/**
 * @package pXP
 * @file RiesgoOportunidadPrin.php
 * @author  MMV
 * @date 04-07-2019 19:53:16
 * @Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.RiesgoOportunidadPrin = {
        require: '../../../sis_auditoria/vista/riesgo_oportunidad/RiesgoOportunidad.php',
        requireclase: 'Phx.vista.RiesgoOportunidad',
        title: 'Riesgo Oportunidad',
        nombreVista: 'RiesgoOportunidadPrin',
        constructor: function (config) {
            this.idContenedor = config.idContenedor;
            this.maestro = config;
            this.initButtons = [this.cmbTipoRo];
            Phx.vista.RiesgoOportunidadPrin.superclass.constructor.call(this, config);
            this.store.baseParams.interfaz = this.nombreVista;
            this.cmbTipoRo.on('select', function (combo, record, index) {
                // this.tmpGestion = record.data.gestion;
                this.store.removeAll();
                this.capturaFiltros();
            }, this);
        },
        onButtonNew: function () {
            if (!this.validarFiltros()) {
                alert('Especifique el tipo riesgo oportunidad');
            } else {
                Phx.vista.RiesgoOportunidadPrin.superclass.onButtonNew.call(this);
                this.Cmp.id_tipo_ro.setValue(this.cmbTipoRo.getValue());
                this.Cmp.codigo_ro.enable();
            }
        },
        onButtonEdit: function () {
            Phx.vista.RiesgoOportunidadPrin.superclass.onButtonEdit.call(this);
            this.Cmp.id_tipo_ro.setValue(this.cmbTipoRo.getValue());
            this.Cmp.codigo_ro.disable();
        },
        preparaMenu: function (n) {
            Phx.vista.RiesgoOportunidadPrin.superclass.preparaMenu.call(this, n);
            this.getBoton('edit').enable();
            this.getBoton('del').enable();
        },
        liberaMenu: function () {
            var tb = Phx.vista.RiesgoOportunidadPrin.superclass.liberaMenu.call(this);
            if (tb) {
                this.getBoton('edit').disable();
                this.getBoton('del').disable();
            }
        },
        capturaFiltros: function (combo, record, index) {
            if (this.validarFiltros()) {
                this.store.baseParams.id_tipo_ro = this.cmbTipoRo.getValue();
                this.getBoton('edit').enable();
                this.getBoton('del').enable();
                this.load({params: {start: 0, limit: this.tam_pag}})
            }
        },
        validarFiltros: function () {
            return !!this.cmbTipoRo.validate();
        },
        onButtonAct: function () {
            if (!this.validarFiltros()) {
                alert('Especifique el tipo riesgo oportunidad');
            } else {
                this.store.baseParams.id_tipo_ro = this.cmbTipoRo.getValue();
                Phx.vista.RiesgoOportunidadPrin.superclass.onButtonAct.call(this);
            }
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
            this.reload();
        },
        // funcion que corre cuando se elimina con exito
        successDel:function(resp){
            //console.log(resp)
            Phx.CP.loadingHide();
            //this.sm.fireEvent('rowdeselect',this.sm);
            this.reload();

        },
        cmbTipoRo: new Ext.form.ComboBox({
            fieldLabel: 'Tipo RO',
            allowBlank: false,
            emptyText: 'Tipo Riesgo Oportunidad...',
            blankText: 'Riesgo Oportunidad',
            grupo: [0, 1, 2, 3, 4],
            store: new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/TipoRo/ListarTipoRo',
                id: 'id_tipo_ro',
                root: 'datos',
                sortInfo: {
                    field: 'desc_tipo_ro',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_tipo_ro', 'tipo_ro', 'desc_tipo_ro'],
                remoteSort: true,
                baseParams: {par_filtro: 'tro.tipo_ro'}
            }),
            valueField: 'id_tipo_ro',
            triggerAction: 'all',
            displayField: 'desc_tipo_ro',
            hiddenName: 'id_tipo_ro',
            mode: 'remote',
            pageSize: 50,
            queryDelay: 500,
            listWidth: '280',
            width: 200
        }),
    };

</script>
