<?php
/*
*/

header("content-type: text/javascript; charset=UTF-8");
?>

<script>
    Phx.vista.FormFiltroPlan = Ext.extend(Phx.frmInterfaz, {

        constructor: function (config) {
            this.panelResumen = new Ext.Panel({html: ''});
            this.Grupos =
                [
                    {
                        xtype: 'fieldset',
                        border: true,
                        autoScroll: true,
                        layout: 'form',
                        items:
                            [],
                        id_grupo: 0
                    },
                    this.panelResumen
                ];

            Phx.vista.FormFiltroPlan.superclass.constructor.call(this, config);
            this.init();
            this.panel.on('collapse', function (p) {
                if (!p.col) {
                    var id = p.getEl().id,
                        parent = p.getEl().parent(),
                        buscador = '#' + id + '-xcollapsed',
                        col = parent.down(buscador);
                    col.insertHtml('beforeEnd', '<div style="writing-mode: vertical-lr; transform: rotate(180deg); text-align: center; height: 100%;"><span class="x-panel-header-text"><b>' + p.title + '</b></span></div>');
                    p.col = col;
                }
            }, this);
            this.onEvento();

            if (config.detalle) {
                //cargar los valores para el FormFiltro
                this.loadForm({data: config.detalle});
                var me = this;
                setTimeout(function () {
                    me.onSubmit()
                }, 1500);
            }
        },
        //
        Atributos: [
            {
                config: {
                    name: 'tipo_filtro',
                    fieldLabel: 'Filtros',
                    items: [
                        {boxLabel: 'Gestión', name: 'tipo_filtro', inputValue: 'gestion', checked: true},
                        {boxLabel: 'Solo fechas', name: 'tipo_filtro', inputValue: 'fechas'}
                    ],


                },
                type: 'RadioGroupField',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'id_gestion',
                    origen: 'GESTION',
                    fieldLabel: 'Gestion',
                    gdisplayField: 'desc_gestion',
                    allowBlank: false,
                    anchor: '100%',

                },
                type: 'ComboRec',
                id_grupo: 0,
                form: true
            }, {
                config: {
                    name: 'desde',
                    fieldLabel: 'Fecha (Desde)',
                    allowBlank: true,
                    format: 'd/m/Y',
                    anchor: '100%',

                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'hasta',
                    fieldLabel: 'Fecha (Hasta)',
                    allowBlank: true,
                    format: 'd/m/Y',
                    anchor: '100%',

                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'id_tipo_estado',
                    fieldLabel: 'Estado',
                    allowBlank: true,
                    resizable: true,
                    emptyText: 'Elija una opción...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarEstados',
                        id: 'id_tipo_estado',
                        root: 'datos',
                        sortInfo: {
                            field: 'codigo',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_tipo_estado', 'codigo', 'nombre_estado'],
                        remoteSort: true,
                        baseParams: {par_filtro: 'ts.codigo', planificacion: 'si',}
                    }),
                    valueField: 'codigo',
                    displayField: 'nombre_estado',
                    gdisplayField: 'codigo',
                    hiddenName: 'id_tipo_estado',
                    forceSelection: true,
                    typeAhead: false,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 15,
                    queryDelay: 1000,
                    anchor: '100%',
                    gwidth: 80,
                    minChars: 2
                },
                type: 'ComboBox',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'id_uo',
                    baseParams: {
                        estado_reg: 'activo'
                    },
                    origen: 'UO',
                    allowBlank: true,
                    fieldLabel: 'Area',
                    gdisplayField: 'nombre_unidad', //mapea al store del grid
                    tpl: '<tpl for="."><div class="x-combo-list-item"><p>{nombre_unidad}</p> </div></tpl>',
                    gwidth: 250,
                    anchor: '100%',
                },
                type: 'ComboRec',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'id_tobjeto',
                    fieldLabel: 'Objeto',
                    allowBlank: true,
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
                    anchor: '100%',
                    gwidth: 200,
                    minChars: 2
                },
                type: 'ComboBox',
                id_grupo: 1,
                form: true
            },
        ],
        labelSubmit: '<i class="fa fa-check"></i> Aplicar FormFiltro',
        title: 'FormFiltro',
        fwidth: 200,

        onSubmit: function () {

            const me = this;

            if (this.form.getForm().isValid()) {
                var parametros = me.getValForm();
                this.fireEvent('beforesave', this, this.getValues());
                this.getValues();
                this.onEnablePanel(me.idContenedorPadre, parametros)
            }
        },
        onEvento: function () {
            this.ocultarComponente(this.Cmp.desde);
            this.ocultarComponente(this.Cmp.hasta);
            this.Cmp.tipo_filtro.on('change', function (cmp, check) {
                if (check.getRawValue() !== 'gestion') {
                    this.ocultarComponente(this.Cmp.id_gestion);
                    this.mostrarComponente(this.Cmp.desde);
                    this.mostrarComponente(this.Cmp.hasta);
                } else {
                    this.mostrarComponente(this.Cmp.id_gestion);
                    this.ocultarComponente(this.Cmp.desde);
                    this.ocultarComponente(this.Cmp.hasta);
                }
            }, this);
        },
        getValues: function () {
            return {
                id_gestion: this.Cmp.id_gestion.getValue(),
                desde: this.Cmp.desde.getValue(),
                hasta: this.Cmp.hasta.getValue(),
            };
        },
        loadValoresIniciales: function () {
            Phx.vista.FormFiltroPlan.superclass.loadValoresIniciales.call(this);
        },
        onReloadPage: function () {

        }
    })
</script>
