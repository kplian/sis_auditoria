<?php
/**
 *@package pXP
 *@file    FormFiltroAuditoriaUnidad.php
 *@author  JMH
 *@date    21/11/2018
 *@description Archivo con la interfaz para generación de reporte
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormFiltroAuditoriaUnidad = Ext.extend(Phx.frmInterfaz, {

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
                        anchor: '40%',
                        gwidth: 100,
                        minChars: 2,
                        renderer : function(value, p, record) {
                            var tipo = record.data['codigo_tpo_aom'];
                            return String.format('{0}',"<div style='text-align:center;'>"+tipo+"</div>");
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'movtip.nombre',type: 'string'},
                    //valorInicial: 'Todos',
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_uo',
                        baseParams : { correspondencia : 'si' },
                        origen : 'UO',
                        allowBlank: false,
                        anchor: '40%',
                        gwidth: 150,
                        //LabelWidth:500,
                        fieldLabel : 'Area/UO',
                        //labelStyle: 'width:100px; margin: 5;',

                        //labelStyle: 'white-space: nowrap;',

                        gdisplayField : 'desc_uo', //mapea al store del grid
                        //gwidth : 500,
                        renderer : function(value, p, record) {
                            return String.format('{0}', record.data['desc_uo']);
                        }
                    },
                    type: 'ComboRec',
                    id_grupo : 1,
                    filters: {  pfiltro : 'desc_uo', type : 'string'},
                    //valorInicial: 'Todos',
                    grid : true,
                    form : true
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
                /*{
                    config: {
                        //name: 'id_responsable',
                        name: 'estado_aom1',
                        fieldLabel: 'Estado',
                        allowBlank: false,
                        resizable: true,
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
                            //fields: ['id_no_funcionario','id_responsable', 'id_uo','desc_funcionario1'],
                            fields: ['id_funcionario','desc_funcionario1'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'vfc.desc_funcionario1'}
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
                        anchor: '50%',
                        gwidth: 150,
                        minChars: 2,
                        renderer : function(value, p, record) {
                            return String.format('{0}', record.data['desc_funcionario1']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'movtip.nombre',type: 'string'},
                    grid: true,
                    form: true
                },*/
                /*{
                    config: {
                        name : 'fecha_ini',
                        id:'fecha_ini'+this.idContenedor,
                        fieldLabel : 'Fecha Desde',
                        labelStyle: 'width:150px; margin: 5;',
                        allowBlank : false,
                        format : 'd/m/Y',
                        renderer : function(value, p, record) {
                            return value ? value.dateFormat('d/m/Y h:i:s') : ''
                        },
                        vtype: 'daterange',
                        width : 250,
                        endDateField: 'fecha_fin'+this.idContenedor
                    },
                    type : 'DateField',
                    id_grupo : 0,
                    grid : true,
                    form : true
                },
                {
                    config: {
                        name : 'fecha_fin',
                        id:'fecha_fin'+this.idContenedor,
                        fieldLabel: 'Fecha Hasta',
                        labelStyle: 'width:150px; margin: 5;',
                        allowBlank: false,
                        gwidth: 250,
                        format: 'd/m/Y',
                        renderer: function(value, p, record) {
                            return value ? value.dateFormat('d/m/Y h:i:s') : ''
                        },
                        vtype: 'daterange',
                        width : 250,
                        startDateField: 'fecha_ini'+this.idContenedor
                    },
                    type : 'DateField',
                    id_grupo : 0,
                    grid : true,
                    form : true
                },*/
                /*{
                    config: {
                        name: 'id_usuario',
                        fieldLabel: 'Usuario',
                        labelStyle: 'width:150px; margin: 5;',

                        allowBlank: true,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_seguridad/control/Usuario/listarUsuario',
                            id: 'id_usuario',
                            root: 'datos',
                            sortInfo: {
                                field: 'desc_person',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_usuario', 'desc_person', 'descripcion'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'PERSON.nombre_completo2'}
                        }),
                        valueField: 'id_usuario',
                        displayField: 'desc_person',
                        gdisplayField: 'desc_persona',

                        hiddenName: 'id_usuario',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,

                        //anchor: '100%',
                        // gwidth: 250,
                        width : 250,
                        minChars: 2,
                        renderer: function(value, p, record) {
                            return String.format('{0}', record.data['desc_persona']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'vusu.desc_persona',type: 'string'},
                    grid: true,
                    form: true
                }*/
            ];

            Phx.vista.FormFiltroAuditoriaUnidad.superclass.constructor.call(this, config);
            this.init();

            //this.iniciarEventos();
            //this.onSubmit();

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

                //Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/reportAuditPDF',
                    params:{ //parametros
                        'p_fecha_de': parametros.fecha_inicio,
                        'p_fecha_hasta': parametros.fecha_fin,
                        'p_id_uo': parametros.id_uo,
                        //'fecha':rec.fecha
                    },
                    success:this.successExport,
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });

            }
        },
        desc_item:''

    })
</script>
