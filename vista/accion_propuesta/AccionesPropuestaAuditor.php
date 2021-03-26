<?php
/**
 *@package pXP
 *@file VBPlanificacionAuditoria.php
 *@author  MMV
 *@date 18-09-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AccionesPropuestaAuditor = {
        require:'../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php',
        requireclase:'Phx.vista.AccionPropuesta',
        nombreVista: 'AccionesPropuestaAuditor',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        maestro: {},
        dblclickEdit: true,
        tipoStore: 'GroupingStore',//GroupingStore o JsonStore #
        remoteGroup: true,
        groupField: 'nro_tramite_no',
        viewGrid: new Ext.grid.GroupingView({
            forceFit: false,
        }),
        bodyStyleForm: 'padding:5px;',
        borderForm: true,
        frameForm: false,
        paddingForm: '5 5 5 5',
        constructor: function(config) {
            this.Atributos[this.getIndAtributo('implementar')].grid=false;
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            Phx.vista.AccionesPropuestaAuditor.superclass.constructor.call(this,config);
            this.init();
            this.store.baseParams.interfaz = this.nombreVista;
            this.load({params:{start:0, limit:50}});
        },
        onButtonEdit:function(){
            this.abrirVentana('edit');
        },
        abrirVentana: function(tipo){
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/listarNoConformidad',
                params:{
                    dir:'ASC',
                    sort:'id_nc',
                    limit:'100',
                    start:'0',
                    id_nc: this.sm.getSelected().data.id_nc
                },
                success: function (resp) {
                    Phx.CP.loadingHide();
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    this.onCrearFormulario(reg.datos[0]);
                    this.formularioVentana.show();
                    if(tipo ==='edit'){
                        this.cargaFormulario(this.sm.getSelected().data);
                        this.storeResponsable.baseParams.id_ap = this.sm.getSelected().data.id_ap;
                        this.storeResponsable.load();
                    }
                },
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });

        },
        onCrearFormulario:function(maestro){
            const me = this;
            if(this.formularioVentana){
                this.form.destroy();
                this.formularioVentana.destroy();
            }
            this.id_ap_master = null;
            this.storeResponsable = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/ReponAccion/listarReponAccion',
                id: 'id_repon_accion',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_repon_accion','id_ap','id_funcionario','desc_funcionario','estado_reg','usr_reg','fecha_reg'],
                remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_repon_accion',limit:'100',start:'0'}
            });
            const responsable = new Ext.grid.GridPanel({
                layout: 'fit',
                store:  this.storeResponsable,
                region: 'center',
                trackMouseOver: false,
                split: true,
                border: false,
                plain: true,
                stripeRows: true,
                loadMask: true,
                tbar: [

                ],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Funcionario',
                        dataIndex: 'id_funcionario',
                        width: 250,
                        sortable: false,
                        renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario']);},
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
            });
            const primero = new Ext.form.FieldSet({
                collapsible: false,
                border: true,
                layout: 'form',
                defaults: {width: 600},
                items: [
                    {
                        fieldLabel: 'Informe',
                        xtype: 'box',
                        autoEl: {
                            tag: 'a',
                            html:  maestro.auditoria,
                        },
                        style: 'cursor:pointer;',
                        listeners: {
                            render: function(component) {
                                component.getEl().on('click', function(e) {
                                    me.onCrearAuditoria(maestro);
                                    me.formularioVentana_aud.show();
                                });
                            }
                        }
                    },
                    {
                        xtype: 'field',
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_ap'
                    },
                    {
                        xtype: 'field',
                        fieldLabel: 'Area',
                        name: 'area',
                        anchor: '100%',
                        value: maestro.uo_aom,
                        readOnly :true,
                        style: 'background-image: none; border: 0; font-weight: bold;',
                    },
                    {
                        xtype: 'field',
                        fieldLabel: 'Auditor resp',
                        name: 'auditor_respo',
                        anchor: '100%',
                        value: maestro.aom_funcionario_resp,
                        readOnly :true,
                        style: 'background-image: none; border: 0; font-weight: bold;',
                    },
                    {
                        fieldLabel: 'No Conformidad',
                        xtype: 'box',
                        autoEl: {
                            tag: 'a',
                            html: maestro.codigo_nc,
                        },
                        style: 'cursor:pointer;',
                        listeners: {
                            render: function(component) {
                                component.getEl().on('click', function(e) {
                                    me.formularioNoConformidad(maestro);
                                    me.ventanaNoConformidad.show();
                                });
                            }
                        }
                    },
                    {
                        xtype: 'textarea',
                        name: 'descrip_causa_nc',
                        fieldLabel: 'Descripcion causa No conformidad',
                        allowBlank: true,
                        anchor: '100%',
                        gwidth: 210,
                        readOnly :true,

                    }
                ]
            });
            this.form = new Ext.form.FormPanel({
                items: [
                    {
                        xtype: 'tabpanel',
                        plain: true,
                        activeTab: 0,
                        height: 500,
                        // width: 590,
                        deferredRender: false,
                        items: [
                            {
                                title: 'Datos de la Accion a Seguir',
                                layout: 'form',
                                defaults: {width: 600},
                                autoScroll: true,
                                defaultType: 'textfield',
                                items: [
                                    primero,
                                    new Ext.form.FieldSet({
                                        collapsible: false,
                                        border: true,
                                        layout: 'form',
                                        defaults: {width: 600},
                                        items: [
                                            {
                                                xtype: 'combo',
                                                name: 'id_parametro',
                                                fieldLabel: 'Tipo de Accion',
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
                                                    baseParams: {par_filtro: 'prm.id_parametro#prm.valor_parametro',id_tipo_parametro:1}
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
                                                readOnly :true,

                                            },
                                            {
                                                xtype: 'textarea',
                                                name: 'descripcion_ap',
                                                fieldLabel: 'Descripcion accion propuesta',
                                                allowBlank: true,
                                                anchor: '100%',
                                                gwidth: 210,
                                                readOnly :true,

                                            },
                                            {
                                                xtype: 'textarea',
                                                name: 'efectividad_cumpl_ap',
                                                fieldLabel: 'Efectividad Cumplimiento ',
                                                allowBlank: true,
                                                anchor: '100%',
                                                gwidth: 210,
                                                readOnly :true,

                                            },
                                            {
                                                xtype: 'datefield',
                                                fieldLabel: 'Inicio',
                                                name: 'fecha_inicio_ap',
                                                disabled: false,
                                                anchor: '100%',
                                                readOnly :true,

                                            },
                                            {
                                                xtype: 'datefield',
                                                fieldLabel: 'Fin',
                                                name: 'fecha_fin_ap',
                                                disabled: false,
                                                anchor: '100%',
                                                readOnly :true,

                                            },
                                        ]
                                    })
                                ]
                            },
                            {
                                title: 'Responsable de la Accion',
                                layout: 'fit',
                                defaults: {width: 600},
                                autoScroll: true,
                                defaultType: 'textfield',
                                items: [
                                    responsable
                                ]
                            }
                        ]
                    }
                ],
                padding: this.paddingForm,
                bodyStyle: this.bodyStyleForm,
                border: this.borderForm,
                frame: this.frameForm,
                autoDestroy: true,
                autoScroll: true,
                region: 'center',
                layout: 'column'
            });
            this.formularioVentana = new Ext.Window({
                width: 620,
                height: 600,
                modal: true,
                closeAction: 'hide',
                labelAlign: 'bottom',
                title: 'ACCIÓN PROPUESTA POR NO CONFORMIDAD',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: [
                    this.form
                ],
                buttons: [{
                    text: 'Aprobar',
                    //handler: this.onSubmit,
                    handler: function() {
                        // this.formularioVentana.hide();
                        alert(1)
                    },
                    scope: this
                }, {
                    text: 'Rechazar',
                    handler: function() {
                        // this.formularioVentana.hide();
                        alert(2)

                    },
                    scope: this
                }]
            });
        },
        cargaFormulario: function(data){
            let obj;
            Ext.each(this.form.getForm().items.keys, function(element, index){
                obj = Ext.getCmp(element);
                if(obj){
                    if (obj.name !== 'area'){
                        if(obj.name !== 'auditor_respo'){
                            if((obj.getXType() === 'combo' && obj.mode === 'remote' && obj.store !== undefined) || obj.name ==='id_parametro'){
                                if (!obj.store.getById(data[obj.name])) {
                                    rec = new Ext.data.Record({[obj.displayField]: data[obj.gdisplayField], [obj.valueField]: data[obj.name] },data[obj.name]);
                                    obj.store.add(rec);
                                    obj.store.commitChanges();
                                    obj.modificado = true;
                                }

                            }
                            obj.setValue(data[obj.name]);
                        }
                    }

                }
            },this);
        },
        onButtonSiguiente:function () {
            Phx.CP.loadingShow();
            const rec = this.sm.getSelected();
            const id_estado_wf = rec.data.id_estado_wf;
            const id_proceso_wf = rec.data.id_proceso_wf;
            if(confirm('¿Verificar Acción?')){
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/AccionPropuesta/aprobarEstado',
                    params:{
                        id_proceso_wf:  id_proceso_wf,
                        id_estado_wf:   id_estado_wf
                    },
                    success:this.successWizard,
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
            }else {
                Phx.CP.loadingHide();
            }
        },
        successWizard:function(){
            Phx.CP.loadingHide();
            this.reload();
        },
        successNoConformidad: function(resp){
            Phx.CP.loadingHide();
            const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            this.maestro = reg.datos[0];
            // console.log(this.maestro)
        },
        obtenerDatosNC:  function (id_nc){
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/listarNoConformidad',
                params:{
                    dir:'ASC',
                    sort:'id_nc',
                    limit:'100',
                    start:'0',
                    id_nc: id_nc // this.sm.getSelected().data.id_nc
                },
                success:  function a(resp) {
                    Phx.CP.loadingHide();
                    const reg =  Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    console.log(reg.datos[0])
                },
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
        },
        formularioNoConformidad:function(data){
            const maestro = this.sm.getSelected().data;
            const me = this;
            let evento = 'NEW';
            let id_modificacion = null;
            if(data){
                evento  = 'EDIT';
                id_modificacion = data.id_nc
            }

            this.punto = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/PnormaNoconformidad/listarPnormaNoconformidad',
                id: 'id_pnnc',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_pnnc','id_nc','id_pn','id_norma','nombre_pn','desc_norma','nombre_pn','sigla_norma','codigo_pn','nombre_descrip'],
                remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_pnnc',limit:'100',start:'0'}
            });
            if(data){
                this.punto.baseParams.id_nc = data?data.id_nc:this.id_no_conformidad;
                this.punto.load();
            }
            this.documentos  = new Ext.data.JsonStore({
                url: '../../sis_workflow/control/DocumentoWf/listarDocumentoWf',
                id: 'id_documento_wf',
                root: 'datos',
                totalProperty: 'total',
                fields: [
                    {name:'id_documento_wf', type: 'numeric'},
                    {name:'url', type: 'string'},
                    {name:'num_tramite', type: 'string'},
                    {name:'id_tipo_documento', type: 'numeric'},
                    {name:'obs', type: 'string'},
                    {name:'id_proceso_wf', type: 'numeric'},
                    {name:'extension', type: 'string'},
                    {name:'chequeado', type: 'string'},
                    {name:'estado_reg', type: 'string'},
                    {name:'nombre_tipo_doc', type: 'string'},
                    {name:'nombre_doc', type: 'string'},
                    {name:'momento', type: 'string'},
                    {name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                    {name:'id_usuario_reg', type: 'numeric'},
                    {name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                    {name:'id_usuario_mod', type: 'numeric'},
                    {name:'priorizacion', type: 'numeric'},
                    {name:'usr_reg', type: 'string'},
                    {name:'usr_mod', type: 'string'},
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
                    'action','solo_lectura','id_documento_wf_ori','id_proceso_wf_ori','nro_tramite_ori',
                    {name:'fecha_upload', type: 'date',dateFormat:'Y-m-d H:i:s.u'},'modificar','insertar','eliminar','demanda',
                    'nombre_vista','esquema_vista','nombre_archivo_plantilla'
                ],
                remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_documento_wf',limit:'100',start:'0'}
            });
            if(data){
                this.documentos.baseParams.modoConsulta = 'no';
                this.documentos.baseParams.todos_documentos = 'no';
                this.documentos.baseParams.anulados = 'no';
                this.documentos.baseParams.id_proceso_wf = data.id_proceso_wf;
                this.documentos.load({params:{start: 0, limit: 50 }});
            }
            const table = new Ext.grid.GridPanel({
                store: this.punto,
                height: 120,
                layout: 'fit',
                region:'center',
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
                        renderer:function(value, p, record){return String.format('{0}', record.data['sigla_norma'])},
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
                        renderer:function(value, p, record){return String.format('{0}', record.data['nombre_pn'])},
                    },
                ]
            });
            const grilla =  new Ext.grid.GridPanel({
                layout: 'fit',
                store:  this.documentos,
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
                    handler: function() {
                        this.onFormularioDocumento(data);
                    }
                },
                    {
                        text: '<button class="btn">&nbsp;&nbsp;<b>Eliminar</b></button>',
                        scope: this,
                        width: '100',
                        handler: function() {
                            const record = grilla.getSelectionModel().getSelections();
                            Phx.CP.loadingShow();
                            Ext.Ajax.request({
                                url: '../../sis_workflow/control/DocumentoWf/eliminarDocumentoWf',
                                params: {
                                    id_documento_wf : record[0].data.id_documento_wf
                                },
                                isUpload: false,
                                success: function(a,b,c){
                                    Phx.CP.loadingHide();
                                    this.documentos.load({params:{ start: 0, limit: 50 }});
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
                        renderer:function (value, p, record, rowIndex, colIndex){

                            if(record.data['chequeado'] == 'si') {
                                return "<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Abrir Documento' src = '../../../lib/imagenes/icono_awesome/awe_print_good.png' align='center' width='30' height='30'></div>";
                            } else if(record.data.nombre_vista) {
                                return "<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Generar Plantilla' src = '../../../lib/imagenes/icono_awesome/awe_template.png' align='center' width='30' height='30'></div>";
                            }
                            else if (record.data['action'] != '') {
                                return "<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Vista Previa Documento Generado' src = '../../../lib/imagenes/icono_awesome/awe_print_good.png' align='center' width='30' height='30'></div>";
                            } else{
                                return  String.format('{0}',"<div style='text-align:center'><img title='Documento No Escaneado' src = '../../../lib/imagenes/icono_awesome/awe_wrong.png' align='center' width='30' height='30'/></div>");
                            }
                        },
                    },
                    {
                        header: 'Subir',
                        dataIndex: 'upload',
                        width: 100,
                        sortable: false,
                        renderer:function (value, p, record){
                            if (record.data['solo_lectura'] == 'no' && !record.data['id_proceso_wf_ori']) {
                                if(record.data['extension'].length!=0) {
                                    return  String.format('{0}',"<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Reemplazar Archivo' src = '../../../lib/imagenes/icono_awesome/awe_upload.png' align='center' width='30' height='30'></div>");
                                } else {
                                    return  String.format('{0}',"<div style='text-align:center'><img border='0' style='-webkit-user-select:auto;cursor:pointer;' title='Subir Archivo' src = '../../../lib/imagenes/icono_awesome/awe_upload.png' align='center' width='30' height='30'></div>");
                                }
                            }
                        }
                    },
                    {
                        header: 'Nombre Doc.',
                        dataIndex: 'nombre_tipo_documento',
                        width: 100,
                        sortable: false,
                        renderer:function(value,p,record){
                            if( record.data.priorizacion==0||record.data.priorizacion==9){
                                return String.format('<b><font color="red">{0}***</font></b>', value);
                            }
                            else{
                                return String.format('{0}', value);
                            }}
                    },
                    {
                        header: 'Descripcion Proceso',
                        dataIndex: 'descripcion_proceso_wf',
                        width: 200,
                        sortable: false,
                        renderer:function(value,p,record){
                            if( record.data.demanda == 'si'){
                                return String.format('<b><font color="green">{0}</font></b>', value);
                            }
                            else{
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
            const isForm = new Ext.form.FormPanel({
                items: [{
                    region: 'center',
                    layout: 'column',
                    border: false,
                    autoScroll: true,
                    items: [{
                        xtype: 'tabpanel',
                        plain: true,
                        activeTab: 0,
                        height: 550,
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
                                    border:false,
                                    items: [
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Nombre Auditoria',
                                            name: 'nombre_aom1',
                                            anchor: '100%',
                                            value: maestro.auditoria,
                                            readOnly :true,
                                            style: 'background-image: none; border: 0; font-weight: bold;',
                                        },
                                        {
                                            xtype: 'combo',
                                            name: 'id_uo',
                                            fieldLabel: 'Area',
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
                                            readOnly :true,
                                        },
                                        {
                                            xtype: 'field',
                                            fieldLabel: 'Resp. Area de NC',
                                            name: 'id_funcionario',
                                            anchor: '100%',
                                            readOnly :true,
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
                                                baseParams: {par_filtro: 'prm.id_parametro#prm.valor_parametro',tipo_no:'TIPO_NO_CONFORMIDAD'}
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
                                            readOnly :true,
                                        },
                                        new Ext.form.FieldSet({
                                            collapsible: false,
                                            layout:"column",
                                            border : false,
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
                                                    name : 'calidad',
                                                    fieldLabel : 'Calidad',
                                                    renderer : function(value, p, record) {
                                                        return record.data['calidad'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth : 50
                                                }, //
                                                new Ext.form.Label({
                                                    text: 'Medio Ambiente  :',
                                                    style: 'margin: 5px'
                                                }),
                                                {
                                                    xtype: 'checkbox',
                                                    name : 'medio_ambiente',
                                                    fieldLabel : 'Medio Ambiente',
                                                    renderer : function(value, p, record) {
                                                        return record.data['medio_ambiente'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth : 50
                                                },
                                                new Ext.form.Label({
                                                    text: 'Seguridad :',
                                                    style: 'margin: 5px'
                                                }),
                                                {
                                                    xtype: 'checkbox',
                                                    name : 'seguridad',
                                                    fieldLabel : 'Seguridad',
                                                    renderer : function(value, p, record) {
                                                        return record.data['seguridad'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth : 50
                                                }, //
                                                new Ext.form.Label({
                                                    text: 'Responsabilidad Social :',
                                                    style: 'margin: 5px'
                                                }),
                                                {
                                                    xtype: 'checkbox',
                                                    name : 'responsabilidad_social',
                                                    fieldLabel : 'Responsabilidad Social',
                                                    renderer : function(value, p, record) {
                                                        return record.data['responsabilidad_social'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth : 50
                                                },
                                                new Ext.form.Label({
                                                    text: 'Sistemas Integrados :',
                                                    style: 'margin: 5px'
                                                }),
                                                {
                                                    xtype: 'checkbox',
                                                    name : 'sistemas_integrados',
                                                    fieldLabel : 'Sistemas Integrados',
                                                    renderer : function(value, p, record) {
                                                        return record.data['sistemas_integrados'] === 'true' ? 'si' : 'no';
                                                    },
                                                    gwidth : 50
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
                                            readOnly :true,
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'evidencia',
                                            fieldLabel: 'Evidencia',
                                            allowBlank: true,
                                            anchor: '100%',
                                            gwidth: 280,
                                            readOnly :true,
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'obs_resp_area',
                                            fieldLabel: 'Observacion Resp.',
                                            allowBlank: true,
                                            anchor: '100%',
                                            gwidth: 150,
                                            readOnly :true,
                                        },
                                        {
                                            xtype: 'textarea',
                                            name: 'obs_consultor',
                                            fieldLabel: 'Observacion Consultor',
                                            allowBlank: true,
                                            anchor: '100%',
                                            gwidth: 150,
                                            readOnly :true,
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
            grilla.addListener('cellclick', this.oncellclick,this);
            if(data){
                console.log(data)
                isForm.getForm().findField('descrip_nc').setValue(data.descrip_nc);
                isForm.getForm().findField('evidencia').setValue(data.evidencia);
                isForm.getForm().findField('obs_consultor').setValue(data.obs_consultor);
                isForm.getForm().findField('obs_resp_area').setValue(data.obs_resp_area);
                setTimeout(() => {
                    isForm.getForm().findField('id_parametro').setValue(data.id_parametro);
                    isForm.getForm().findField('id_parametro').setRawValue(data.valor_parametro);
                }, 1000);
                isForm.getForm().findField('calidad').setValue(this.onBool(data.calidad));
                isForm.getForm().findField('medio_ambiente').setValue(this.onBool(data.medio_ambiente));
                isForm.getForm().findField('seguridad').setValue(this.onBool(data.seguridad));
                isForm.getForm().findField('responsabilidad_social').setValue(this.onBool(data.responsabilidad_social));
                isForm.getForm().findField('sistemas_integrados').setRawValue(this.onBool(data.sistemas_integrados));
            }
            let id_funcionario = null;
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/getUo',
                params:{ id_uo: data.id_uo },
                success:function(resp){
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    setTimeout(() => {
                        isForm.getForm().findField('id_uo').setValue(reg.ROOT.datos.id_uo);
                        isForm.getForm().findField('id_uo').setRawValue(reg.ROOT.datos.nombre_unidad);
                        isForm.getForm().findField('id_funcionario').setValue(reg.ROOT.datos.desc_funcionario1);
                        id_funcionario = reg.ROOT.datos.id_funcionario;
                    }, 1000);
                },
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });

            isForm.getForm().findField('id_uo').on('select', function(combo, record, index){
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/NoConformidad/getUo',
                    params:{ id_uo: record.data.id_uo },
                    success:function(resp) {
                        isForm.getForm().findField('id_funcionario').reset();
                        const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                        isForm.getForm().findField('id_funcionario').setValue(reg.ROOT.datos.desc_funcionario1);
                        id_funcionario = reg.ROOT.datos.id_funcionario;
                    },
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
            },this);

            this.ventanaNoConformidad = new Ext.Window({
                width: 650,
                height: 610,
                modal: false,
                minimizable: true,
                maximizable: true,
                closeAction: 'hide',
                labelAlign: 'bottom',
                title: 'Formulario',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: [isForm]
            });
        },
        onCrearAuditoria:function(record){
            if(this.formularioVentana_aud){
                this.formularioVentana_aud.destroy();
            }
            if(this.form_auditoria_audi){
                this.form_auditoria_audi.destroy();
            }
            Phx.CP.loadingShow();
            this.storeProceso = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/AuditoriaProceso/listarAuditoriaProceso',
                id: 'id_aproceso',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_aom','id_aproceso','proceso','desc_funcionario', 'estado_reg','usr_reg','fecha_reg'],
                remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_aom',limit:'100',start:'0'}
            });
            this.storeEquipo = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/EquipoResponsable/listarEquipoResponsable',
                id: 'id_equipo_responsable',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_aom','id_formula_detalle','id_parametro','valor_parametro', 'id_funcionario',
                    'desc_funcionario1', 'estado_reg','usr_reg','fecha_reg'
                ],remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_equipo_responsable',limit:'100',start:'0'}
            });
            this.storePuntoNorma = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/AuditoriaNpn/listarAuditoriaNpn',
                id: 'id_anpn',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_aom','id_anpn','id_norma','sigla_norma',
                    'id_pn','nombre_pn','codigo_pn','desc_punto_norma',
                    'usr_reg','estado_reg','fecha_reg','nombre_descrip'],
                remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_anpn',limit:'100',start:'0'}
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
                fields: ['id_anpnpg','descrip_pregunta','estado_reg','usr_reg','fecha_reg'
                ],remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_anpnpg',limit:'100',start:'0'}
            });
            this.storeCronograma = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/Cronograma/listarCronograma',
                id: 'id_cronograma',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_cronograma','id_aom','id_actividad',
                    'nueva_actividad','fecha_ini_activ','actividad',
                    'fecha_fin_activ','hora_ini_activ','hora_fin_activ','lista_funcionario',
                    'estado_reg','usr_reg','fecha_reg'],remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_cronograma',limit:'100',start:'0'}
            });

            Ext.Ajax.request({
                url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/listarAuditoriaOportunidadMejora',
                params:{
                    dir:'ASC',
                    sort:'id_aom',
                    limit:'100',
                    start:'0',
                    id_aom: record.id_aom
                },
                success:this.successRevision,
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
            const crorograma = new Ext.grid.GridPanel({
                layout: 'fit',
                store:  this.storeCronograma,
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
                        renderer:function(value, p, record){return String.format('{0}', record.data['actividad'])},
                    },
                    {
                        header: 'Funcionarios',
                        dataIndex: 'lista_funcionario',
                        width: 210,
                        renderer : function(value, p, record) {
                            return String.format('<div class="gridmultiline">{0}</div>', record.data['lista_funcionario']);
                        }
                    },
                    {
                        header: 'Fecha Inicio',
                        dataIndex: 'fecha_ini_activ',
                        align: 'center',
                        width: 100,
                        renderer:function (value,p,record){
                            if(value){
                                const fecha = value.split("-");
                                return  fecha[2]+'/'+fecha[1]+'/'+fecha[0];
                            }else{
                                return ''
                            }
                        }
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
            this.form_auditoria_audi = new Ext.form.FormPanel({
                id: this.idContenedor + '_formulario_audi',
                items: [{ region: 'center',
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
                                    border:false,
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
                                                    id: this.idContenedor+'_lugar',
                                                    readOnly: true,
                                                    style: 'background-image: none;',
                                                },
                                                {
                                                    xtype: 'combo',
                                                    fieldLabel: 'Tipo de Auditoria',
                                                    name: 'id_tnorma',
                                                    allowBlank: false,
                                                    id: this.idContenedor+'_id_tnorma',
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
                                                        baseParams:{
                                                            tipo_parametro:'TIPO_NORMA',
                                                            par_filtro:'prm.id_tipo_parametro'
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
                                                    id: this.idContenedor+'_id_tobjeto',
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
                                                        baseParams:{
                                                            tipo_parametro:'OBJETO_AUDITORIA',
                                                            par_filtro:'prm.id_parametro'
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
                                                    id: this.idContenedor+'_fecha_prev_inicio',
                                                    style: 'background-image: none;',
                                                    readOnly: true,
                                                },
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Fin Prev',
                                                    name: 'fecha_prev_fin',
                                                    disabled: false,
                                                    anchor: '100%',
                                                    id: this.idContenedor+'_fecha_prev_fin',
                                                    style: 'background-image: none;',
                                                    readOnly: true,
                                                },
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Inicio Real',
                                                    name: 'fecha_prog_inicio',
                                                    disabled: false,
                                                    anchor: '100%',
                                                    id: this.idContenedor+'_fecha_prog_inicio',
                                                    style: 'background-image: none;',
                                                    readOnly: true,
                                                },
                                                {
                                                    xtype: 'datefield',
                                                    fieldLabel: 'Fin Real',
                                                    name: 'fecha_prog_fin',
                                                    disabled: false,
                                                    anchor: '100%',
                                                    id: this.idContenedor+'_fecha_prog_fin',
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
                                        store:  this.storeProceso,
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
                                                renderer:function(value, p, record){return String.format('{0}', record.data['proceso']);},
                                            },
                                            {
                                                header: 'Responsable',
                                                dataIndex: 'desc_funcionario',
                                                width: 300,
                                                sortable: false,
                                                renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario']);},
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
                                region:'center',
                                items: [
                                    new Ext.grid.GridPanel({
                                        layout: 'fit',
                                        store:  this.storeEquipo,
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
                                                renderer:function(value, p, record){return String.format('{0}', record.data['valor_parametro'])},
                                            },
                                            {
                                                header: 'Funcionario',
                                                dataIndex: 'id_funcionario',
                                                width: 200,
                                                sortable: false,
                                                renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario1'])},
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
                                region:'center',
                                items: [
                                    new Ext.grid.GridPanel({
                                        layout: 'fit',
                                        store:  this.storePuntoNorma,
                                        region:  'center',
                                        margins: '3 3 3 0',
                                        trackMouseOver: false,
                                        columns: [
                                            new Ext.grid.RowNumberer(),
                                            {
                                                header: 'Norma',
                                                dataIndex: 'id_norma',
                                                width: 150,
                                                sortable: false,
                                                renderer:function(value, p, record){
                                                    let resultao = '';
                                                    if(this.sigla !== record.data['sigla_norma']){
                                                        resultao = String.format('<b>{0}</b>', record.data['sigla_norma']);
                                                        this.sigla =  record.data['sigla_norma']
                                                    }
                                                    return resultao
                                                }
                                            },
                                            {
                                                header: 'Codigo',
                                                dataIndex: 'codigo_pn',
                                                width: 100,
                                                sortable: false,
                                                renderer:function(value, p, record){
                                                    return String.format('<span>{0}</span>', record.data['codigo_pn'])
                                                },

                                            },
                                            {
                                                header: 'Punto de Norma',
                                                dataIndex: 'id_pn',
                                                width: 350,
                                                sortable: false,
                                                renderer:function(value, p, record){
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
                                region:'center',
                                items: [
                                    new Ext.grid.GridPanel({
                                        layout: 'fit',
                                        store:  this.storePregunta,
                                        region:  'center',
                                        margins: '3 3 3 0',
                                        trackMouseOver: false,
                                        columns: [
                                            new Ext.grid.RowNumberer(),
                                            {
                                                header: 'Norma',
                                                dataIndex: 'id_norma',
                                                width: 150,
                                                sortable: false,
                                                renderer:function(value, p, record){return String.format('{0}', record.data['sigla_norma'])},
                                            },
                                            {
                                                header: 'Punto de Norma',
                                                dataIndex: 'id_pn',
                                                width: 300,
                                                sortable: false,
                                                renderer:function(value, p, record){return String.format('{0}', record.data['nombre_pn'])},
                                            },
                                            {
                                                header: 'Pregunta',
                                                dataIndex: 'id_pregunta',
                                                width: 300,
                                                sortable: false,
                                                renderer:function(value, p, record){return String.format('{0}', record.data['descrip_pregunta'])},
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
                                region:'center',
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


            this.formularioVentana_aud = new Ext.Window({
                width: 750,
                height: 480,
                modal: true,
                closeAction: 'hide',
                labelAlign: 'top',
                title: 'Auditoria Planificacion',
                bodyStyle: 'padding:5px',
                layout: 'border',
                items: [this.form_auditoria_audi]
            });
        },
        onBool:function(valor){
            return valor === 't';
        },
        successRevision: function(resp){
            Phx.CP.loadingHide();
            const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            this.cargaFormularioAuditoria(reg.datos[0],this.form_auditoria_audi);
        },
        cargaFormularioAuditoria: function(data, formulario){
            var obj,key;
            Ext.each(formulario.getForm().items.keys, function(element, index){
                obj = Ext.getCmp(element);
                if(obj&&obj.items){
                    Ext.each(obj.items.items, function(elm, b, c){
                        if(elm.getXType()=='combo'&&elm.mode=='remote'&&elm.store!=undefined){
                            if (!elm.store.getById(data[elm.name])) {
                                rec = new Ext.data.Record({[elm.displayField]: data[elm.gdisplayField], [elm.valueField]: data[elm.name] },data[elm.name]);
                                elm.store.add(rec);
                                elm.store.commitChanges();
                                elm.modificado = true;
                            }
                        }
                        elm.setValue(data[elm.name]);
                    },this);
                } else {
                    key = element.replace(this.idContenedor+'_','');
                    if(obj){
                        if((obj.getXType()=='combo'&&obj.mode=='remote'&&obj.store!=undefined)||key=='id_centro_costo'){
                            if (!obj.store.getById(data[key])) {
                                rec = new Ext.data.Record({[obj.displayField]: data[obj.gdisplayField], [obj.valueField]: data[key] },data[key]);
                                obj.store.add(rec);
                                obj.store.commitChanges();
                                obj.modificado = true;
                            }
                        }
                        obj.setValue(data[key]);
                    }
                }
            },this);
        },
    }
</script>
