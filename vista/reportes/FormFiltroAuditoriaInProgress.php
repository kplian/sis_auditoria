<?php
/**
 *@package pXP
 *@file    FormFiltroAuditoriaInProcess.php
 *@author  JMH
 *@date    21/11/2018
 *@description Archivo con la interfaz para generación de reporte
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormFiltroAuditoriaInProcess = Ext.extend(Phx.frmInterfaz, {

        constructor: function(config) {
            Ext.apply(this,config);
            this.Atributos = [
                {
                    config:{
                        name: 'fecha_inicio',
                        fieldLabel: 'Desde',
                        allowBlank: false,
                        //labelStyle: 'width:100px; margin: 5;',
                        //minValue : (new Date()).clearTime(),
                        emptyText: 'Fecha Inicio...',
                        anchor: '40%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                    },
                    type:'DateField',
                    //filters:{pfiltro:'aom.fecha_prog_inicio',type:'date'},
                    id_grupo:0,
                    //valorInicial: (new Date().getDate()),
                    grid:true,
                    form:true
                },
                {
                    config:{
                        name: 'fecha_fin',
                        fieldLabel: 'Hasta',
                        allowBlank: false,
                        //labelStyle: 'width:100px; margin: 5;',
                        //minValue : (new Date()).clearTime(),
                        emptyText: 'Fecha fin...',
                        anchor: '40%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                    },
                    type:'DateField',
                    //filters:{pfiltro:'aom.fecha_prog_inicio',type:'date'},
                    id_grupo:0,
                    //valorInicial: (new Date().getDate()),
                    grid:true,
                    form:true
                },
                {
                    config:{
                        name:'estado',
                        fieldLabel:'Estado',
                        allowBlank:false,
                        typeAhead: true,
                        triggerAction: 'all',
                        emptyText:'Elija una opción...',
                        lazyRender:true,
                        selectOnFocus:true,
                        mode:'local',
                        store:new Ext.data.ArrayStore({
                            fields: ['ID', 'valor'],
                            data: [
                                //['todos','Todos'],
                                ['programado','Programada'],
                                ['prog_aprob','Aprobado por el Responsable de Área']
                            ]
                        }),
                        valueField:'ID',
                        displayField:'valor',
                        anchor: '65%',
                        width: 300,
                        gwidth:130
                    },
                    type:'ComboBox',
                    //id_grupo:1,
                    id_grupo:0,
                    //valorInicial: 'todos',
                    grid:true,
                    egrid: true,
                    form:true
                },
                {
                    config: {
                        name: 'id_uo',
                        fieldLabel: 'Area/UO',
                        allowBlank: false,
                        resizable:true,
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
                            fields: ['id_uo', 'nombre_unidad','codigo','nivel_organizacional'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'nombre_unidad', _adicionar : 'si'}
                        }),
                        valueField: 'id_uo',
                        displayField: 'nombre_unidad',
                        gdisplayField: 'nombre_unidad',
                        hiddenName: 'id_uo',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '65%',
                        gwidth: 150,
                        minChars: 2,
                        renderer : function(value, p, record) {
                            var v_uo = record.data['nombre_unidad'];
                            return String.format('{0}', "<div style='font-size:12px;'>"+v_uo+"</div>");
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'movtip.nombre',type: 'string'},
                    //valorInicial:'Todos',
                    grid: true,
                    form: true
                },
                {
                    //configuracion del componente
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'nombre_uo'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        name:'formato_reporte',
                        fieldLabel:'Formato del Reporte',
                        typeAhead: true,
                        allowBlank:false,
                        triggerAction: 'all',
                        emptyText:'Formato...',
                        selectOnFocus:true,
                        mode:'local',
                        store:new Ext.data.ArrayStore({
                            fields: ['ID', 'valor'],
                            data :[ ['pdf','PDF'],
                                ['csv','CSV']]
                        }),
                        valueField:'ID',
                        displayField:'valor',
                        width:250,

                    },
                    type:'ComboBox',
                    id_grupo:1,
                    form:true
                },

            ];
            Phx.vista.FormFiltroAuditoriaInProcess.superclass.constructor.call(this, config);
            this.init();

            //this.iniciarEventos();
            //this.onSubmit();
            this.setValueInitial();
        },
        title: 'Reporte Auditoria',
        topBar: true,
        botones: false,
        remoteServer: '',
        labelSubmit: 'Generar',
        labelWidth: 300,
        tooltipSubmit: '<b>Generar Reporte de Auditoria</b>',
        tipo: 'reporte',

        clsSubmit: 'bprint',

        Grupos: [
            {
                layout: 'column',
                border: false,
                default: {border: false},
                items: [{
                    xtype: 'fieldset',
                    layout: 'form',
                    border: true,
                    title: 'Generar Reporte',
                    bodyStyle : 'padding:25px 30px 25px 30px;',
                    columnWidth : '400px',

                    items: [],
                    id_grupo: 0,
                    width: 1050,
                    collapsible: true
                }]
            }
        ],

        /*iniciarEventos : function() {
            //this.Cmp.id_sucursal.on('select',function(c, r, i) {
            //  this.remoteServer = r.data.servidor_remoto;
            //},this);
            this.Cmp.tipo.on('select',function(c, r, i) {
                this.Cmp.id_documento.store.baseParams.tipo = r.data.ID;
                this.Cmp.id_documento.modificado=true;
                //this.Cmp.id_documento.add(rec);
                //this.Cmp.add(0,'to','Toods');
            },this);
        },*/

        onSubmit: function(){
            var me = this;

            if (this.form.getForm().isValid()) {
                var parametros = me.getValForm();
                console.log("param...",parametros);
                console.log("param... value",parametros.fecha_inicio+", "+parametros.fecha_fin+", "+parametros.id_uo);

                /*var data={};
                data.fecha_inicio=this.getComponente('fecha_inicio').getValue().dateFormat('d/m/Y');
                data.fecha_fin=this.getComponente('fecha_fin').getValue().dateFormat('d/m/Y');
                data.id_uo=this.getComponente('id_uo').getValue();
                data.estado = this.getComponente('estados').getValue();
                Phx.CP.loadWindows('../../../sis_correspondencia/vista/reportes/GridReporteCorrespondencia.php', 'Correspondencia '+ data.tipo+' de '+data.desc_uo, {
                    width : '90%',
                    height : '80%'
                }, data	, this.idContenedor, 'GridReporteCorrespondencia')*/
                console.log("formato",parametros.formato_reporte)
                //Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/reportAuditPDF',
                    params:{ //parametros
                        'p_fecha_de': parametros.fecha_inicio,
                        'p_fecha_hasta': parametros.fecha_fin,
                        'p_estado': parametros.estado,
                        'p_id_unidad': parametros.id_uo,
                        'p_unidad': parametros.nombre_uo,
                        'p_formato_rpt': parametros.formato_reporte

                    },
                    success:this.successExport,
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
                console.log("valor del nombre_uo->",this.Cmp.nombre_uo.getValue());
                console.log("valor del nombre_uo pppppppppppppppppp->",parametros.nombre_uo);
            }
        },
        desc_item:'',

        setValueInitial: function () {

            this.Cmp.id_uo.on('select',function(combo, record, index){
                var name_unidad = this.Cmp.id_uo.store.baseParams.nombre_uo = record.data.nombre_unidad;
                //var valor_tipo = this.Cmp.id_tipo_om.store.baseParams.tipo_om = record.data.valor_parametro;
                //var valor_tipo_om = valor_tipo.toUpperCase();
                console.log("hhhhhhhhhhhhhhh",name_unidad);
                console.log("",record);
                this.Cmp.nombre_uo.setValue(name_unidad);

            },this);
        }

    })
</script>
