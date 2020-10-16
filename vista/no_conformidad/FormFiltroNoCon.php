<?php
/*
*/

header("content-type: text/javascript; charset=UTF-8");
?>

<script>
    Phx.vista.FormFiltroNoCon=Ext.extend(Phx.frmInterfaz,{

        constructor:function(config){
            this.panelResumen = new Ext.Panel({html:''});
            this.Grupos =
                [
                    {
                        xtype: 'fieldset',
                        border: true,
                        autoScroll: true,
                        layout: 'form',
                        items:
                            [
                            ],
                        id_grupo: 0
                    },
                    this.panelResumen
                ];

            Phx.vista.FormFiltroNoCon.superclass.constructor.call(this,config);
            this.init();
            this.onEvento();
            if(config.detalle){
                this.loadForm({data: config.detalle});
                const me = this;
                setTimeout(function(){
                    me.onSubmit()
                }, 1500);
            }
        },
        //
        Atributos:[
            {
                config:{
                    name : 'tipo_filtro',
                    fieldLabel : 'Filtros',
                    items: [
                        {boxLabel: 'Gestión', name: 'tipo_filtro', inputValue: 'gestion', checked: true},
                        {boxLabel: 'Solo fechas', name: 'tipo_filtro', inputValue: 'fechas'}
                    ],


                },
                type : 'RadioGroupField',
                id_grupo : 0,
                form : true
            },
            {
                config:{
                    name : 'id_gestion',
                    origen : 'GESTION',
                    fieldLabel : 'Gestion',
                    gdisplayField: 'desc_gestion',
                    allowBlank : false,
                    anchor: '100%',
                },
                type : 'ComboRec',
                id_grupo : 0,
                form : true
            },{
                config:{
                    name: 'desde',
                    fieldLabel: 'Fecha (Desde)',
                    allowBlank: false,
                    format: 'd/m/Y',
                    anchor: '100%',
                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            },
            {
                config:{
                    name: 'hasta',
                    fieldLabel: 'Fecha (Hasta)',
                    allowBlank: false,
                    format: 'd/m/Y',
                    anchor: '100%',
                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'tipo_estado',
                    fieldLabel: 'Estado',
                    allowBlank: false,
                    resizable:true,
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
                        fields: ['id_tipo_estado', 'codigo','nombre_estado'],
                        remoteSort: true,
                        baseParams: {par_filtro: 'ts.codigo'}
                    }),
                    valueField: 'codigo',
                    displayField: 'codigo',
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
                        estado_reg : 'activo'
                    },
                    origen:'UO',
                    allowBlank:true,
                    fieldLabel:'Area',
                    gdisplayField:'nombre_unidad', //mapea al store del grid
                    tpl:'<tpl for="."><div class="x-combo-list-item"><p>{nombre_unidad}</p> </div></tpl>',
                    gwidth: 250,
                    anchor: '100%'
                },
                type:'ComboRec',
                id_grupo:0,
                form:true
            },
            {
                config: {
                    name: 'id_tipo_auditoria',
                    fieldLabel: 'Tipo Auditoria',
                    allowBlank: false,
                    resizable:true,
                    emptyText: 'Elija una opción...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_auditoria/control/TipoAuditoria/listarTipoAuditoria',
                        id: 'id_tipo_auditoria',
                        root: 'datos',
                        sortInfo: {
                            field: 'tipo_auditoria',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_tipo_auditoria', 'tipo_auditoria','codigo_tpo_aom'],
                        remoteSort: true,
                        baseParams: {par_filtro: 'tau.tipo_auditoria'}
                    }),
                    valueField: 'id_tipo_auditoria',
                    displayField: 'tipo_auditoria',
                    gdisplayField: 'tipo_auditoria',
                    hiddenName: 'id_tipo_auditoria',
                    forceSelection: true,
                    typeAhead: false,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 15,
                    queryDelay: 1000,
                    anchor: '100%',
                    minChars: 2
                },
                type: 'ComboBox',
                id_grupo: 0,
                form: true
            },
        ],
        labelSubmit: '<i class="fa fa-check"></i> Aplicar Filtro',
        // fwidth:200,
        east: {
            url: '../../../sis_auditoria/vista/auditoria_oportunidad_mejora/Auditoria.php',
            title: 'Procesos',
            width: '70%',
            cls: 'Auditoria'
        },
        title: 'Filtro de Auditoria',
        autoScroll: true,

        onSubmit:function(){

            var me = this;

            if (this.form.getForm().isValid()) {
                const parametros = me.getValForm();
                this.onEnablePanel(this.idContenedor + '-east',
                    Ext.apply(parametros,{
                        id_gestion: this.Cmp.id_gestion.getValue(),
                        desde: this.Cmp.desde.getValue(),
                        hasta: this.Cmp.hasta.getValue(),
                        tipo_estado: this.Cmp.tipo_estado.getValue(),
                        id_tipo_auditoria: this.Cmp.id_tipo_auditoria.getValue(),
                    }));
            }
        },
        onEvento:function(){
            this.ocultarComponente(this.Cmp.desde);
            this.ocultarComponente(this.Cmp.hasta);
            this.Cmp.tipo_filtro.on('change', function(cmp, check){
                if(check.getRawValue() !== 'gestion'){
                    this.ocultarComponente(this.Cmp.id_gestion);
                    this.mostrarComponente(this.Cmp.desde);
                    this.mostrarComponente(this.Cmp.hasta);
                }else{
                    this.mostrarComponente(this.Cmp.id_gestion);
                    this.ocultarComponente(this.Cmp.desde);
                    this.ocultarComponente(this.Cmp.hasta);
                }
            },this);
        },
        loadValoresIniciales: function(){
            Phx.vista.FormFiltroNoCon.superclass.loadValoresIniciales.call(this);
        },


    })
</script>
