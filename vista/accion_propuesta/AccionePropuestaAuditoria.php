<?php
/**
 *@package pXP
 *@file AccionePropuestaAuditoria.php
 *@author  MMV
 *@date 18-09-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AccionePropuestaAuditoria = {
        require:'../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php',
        requireclase:'Phx.vista.AccionPropuesta',
        nombreVista: 'AccionePropuestaAuditoria',
        bnew: true,
        bdel:true,
        bedit:true,
        storeResponsable: {},
        id_ap_master : null,
        constructor: function(config) {
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            this.Atributos[this.getIndAtributo('implementar')].grid=false;

            Phx.vista.AccionePropuestaAuditoria.superclass.constructor.call(this,config);
            this.getBoton('atras').setVisible(false);
            this.getBoton('siguiente').setVisible(false);
            this.getBoton('diagrama_gantt').setVisible(false);
            this.getBoton('btnChequeoDocumentosWf').setVisible(false);
            this.init();
        },
        onReloadPage:function(m){
            this.maestro=m;
            this.store.baseParams = {id_nc: this.maestro.id_nc,interfaz : this.nombreVista};
            this.load({params:{start:0, limit:50}});
        },
        loadValoresIniciales: function () {
            this.Cmp.id_nc.setValue(this.maestro.id_nc);
            Phx.vista.AccionePropuestaAuditoria.superclass.loadValoresIniciales.call(this);
        },
        onButtonNew:function() {
            this.onCrearFormulario();
            this.abrirVentana('new');
        },
        onButtonEdit: function() {
            this.onCrearFormulario();
            this.abrirVentana('edit');
        },

        abrirVentana: function(tipo){
            if(tipo ==='edit'){
                 this.cargaFormulario(this.sm.getSelected().data);
                 this.storeResponsable.baseParams.id_ap = this.sm.getSelected().data.id_ap;
                 this.storeResponsable.load();
            }
            this.formularioVentana.show();
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
        onCrearFormulario:function(){

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
                plugins: [],
                stripeRows: true,
                loadMask: true,
                tbar: [
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'a',
                            html: 'Asignar Responsables'
                        },
                        style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                        listeners: {
                            render: function(component) {
                                component.getEl().on('click', function(e) {
                                    let id_ap
                                    if (me.sm.getSelected()){
                                        id_ap =  me.sm.getSelected().data.id_ap;    
                                    }else{
                                        id_ap = me.id_ap_master 
                                    }
                                    console.log(id_ap);
                                    me.onResponsable(id_ap);
                                    me.ventanaResponsable.show();
                                });
                        }
                    }
                    },
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'a',
                            html: 'Eliminar'
                        },
                        style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                        listeners: {
                            render: function(component) {
                                component.getEl().on('click', function(e) {
                                    const  record =  responsable.getSelectionModel().getSelections();
                                    Phx.CP.loadingShow();
                                    Ext.Ajax.request({
                                        url: '../../sis_auditoria/control/ReponAccion/eliminarReponAccion',
                                        params: {
                                            id_repon_accion : record[0].data.id_repon_accion
                                        },
                                        isUpload: false,
                                        success: function(a,b,c){
                                            Phx.CP.loadingHide();
                                            this.storeResponsable.load();
                                        },
                                        argument: this.argumentSave,
                                        failure: this.conexionFailure,
                                        timeout: this.timeout,
                                        scope: this
                                    })
                                });
                        }
                    }
                    }
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
                                    new Ext.form.FieldSet({
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
                                                        html: this.maestro.auditoria,
                                                    },
                                                    style: 'cursor:pointer;',
                                                    listeners: {
                                                        render: function(component) {
                                                            component.getEl().on('click', function(e) {
                                                                alert('test');
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
                                                    value: this.maestro.uo_aom,
                                                    readOnly :true,
                                                    style: 'background-image: none; border: 0; font-weight: bold;',
                                                },
                                                {
                                                    xtype: 'field',
                                                    fieldLabel: 'Auditor resp',
                                                    name: 'auditor_respo',
                                                    anchor: '100%',
                                                    value: this.maestro.aom_funcionario_resp,
                                                    readOnly :true,
                                                    style: 'background-image: none; border: 0; font-weight: bold;',
                                                },
                                                {
                                                    fieldLabel: 'No Conformidad',
                                                    xtype: 'box',
                                                    autoEl: {
                                                        tag: 'a',
                                                        html: this.maestro.codigo_nc,
                                                    },
                                                    style: 'cursor:pointer;',
                                                    listeners: {
                                                        render: function(component) {
                                                            component.getEl().on('click', function(e) {
                                                                alert('test');
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
                                                }
                                            ]
                                    }),
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
                                                anchor: '100%'
                                            },
                                            {
                                                xtype: 'textarea',
                                                name: 'descripcion_ap',
                                                fieldLabel: 'Descripcion accion propuesta',
                                                allowBlank: true,
                                                anchor: '100%',
                                                gwidth: 210,
                                            },
                                            {
                                                xtype: 'textarea',
                                                name: 'efectividad_cumpl_ap',
                                                fieldLabel: 'Efectividad Cumplimiento ',
                                                allowBlank: true,
                                                anchor: '100%',
                                                gwidth: 210,
                                            },
                                            {
                                                xtype: 'datefield',
                                                fieldLabel: 'Inicio',
                                                name: 'fecha_inicio_ap',
                                                disabled: false,
                                                anchor: '100%',
                                            },
                                            {
                                                xtype: 'datefield',
                                                fieldLabel: 'Fin',
                                                name: 'fecha_fin_ap',
                                                disabled: false,
                                                anchor: '100%',
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
                    text: 'Guardar',
                    handler: this.onSubmit,
                    scope: this
                }, {
                    text: 'Declinar',
                    handler: function() {
                        this.formularioVentana.hide();
                    },
                    scope: this
                }]
            });
        },
        onSubmit:function(){
            const submit={};
            Ext.each(this.form.getForm().items.keys, function(element, index){
                obj = Ext.getCmp(element);
                if(obj.items){
                    Ext.each(obj.items.items, function(elm, ind){
                        submit[elm.name]=elm.getValue();
                    },this)
                } else {
                    submit[obj.name]=obj.getValue();
                    if(obj.name === 'id_parametro'){
                        if(obj.selectedIndex!==-1){
                            submit[obj.name]=obj.store.getAt(obj.selectedIndex).id;
                        }
                    }
                }
            },this);
           if (this.form.getForm().isValid()) {
               if(!this.id_ap_master) {
                   Phx.CP.loadingShow();
                   Ext.Ajax.request({
                       url: '../../sis_auditoria/control/AccionPropuesta/insertarAccionPropuesta',
                       params: {
                           obs_resp_area: null,
                           descripcion_ap: submit.descripcion_ap,
                           id_parametro: submit.id_parametro,
                           descrip_causa_nc: submit.descrip_causa_nc,
                           efectividad_cumpl_ap: submit.efectividad_cumpl_ap,
                           fecha_fin_ap: submit.fecha_fin_ap,
                           obs_auditor_consultor: null,
                           id_nc: this.maestro.id_nc,
                           fecha_inicio_ap: submit.fecha_inicio_ap,
                           codigo_ap: null,
                           nro_tramite_padre: this.maestro.nro_tramite_padre,
                       },
                       isUpload: false,
                       success: function (resp) {
                           this.store.rejectChanges();
                           Phx.CP.loadingHide();
                           const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                           this.id_ap_master = reg.ROOT.datos.id_ap;
                           console.log(this.id_ap_master);
                           this.reload();
                       },
                       argument: this.argumentSave,
                       failure: this.conexionFailure,
                       timeout: this.timeout,
                       scope: this
                   });
               }else{
                   this.formularioVentana.hide();
               }
            } else {
                Ext.MessageBox.alert('Validación', 'Existen datos inválidos en el formulario. Corrija y vuelva a intentarlo');
            }
        },
        onResponsable: function(id_ap){
            const storeCombo = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/NoConformidad/listarFuncionariosUO',
                id: 'id_funcionario',
                root: 'datos',
                sortInfo:{
                    field: 'desc_funcionario',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_funcionario','desc_funcionario','desc_funcionario_cargo'],
                remoteSort: true,
                baseParams: {par_filtro: 'vfc.desc_funcionario1 '}
            });

            const combo = new Ext.form.ComboBox({
                name:'id_funcionario',
                fieldLabel:'Responsable Accion',
                allowBlank : false,
                typeAhead: true,
                store: storeCombo,
                mode: 'remote',
                pageSize: 15,
                triggerAction: 'all',
                valueField : 'id_funcionario',
                displayField : 'desc_funcionario',
                forceSelection: true,
                anchor: '100%',
                resizable : true,
                enableMultiSelect: false
            });
            this.formAuto = new Ext.form.FormPanel({
                baseCls: 'x-plain',
                autoDestroy: true,
                border: false,
                layout: 'form',
                autoHeight: true,
                items: [combo]
            });
            this.ventanaResponsable = new Ext.Window({
                title: 'Asignar Responsables de esta Accion',
                collapsible: true,
                maximizable: true,
                autoDestroy: true,
                width: 500,
                height: 150,
                layout: 'fit',
                plain: true,
                bodyStyle: 'padding:5px;',
                buttonAlign: 'center',
                items: this.formAuto,
                modal:true,
                closeAction: 'hide',
                buttons: [{
                    text: 'Guardar',
                    handler: this.saveResponsable,
                    scope: this},
                    {
                        text: 'Cancelar',
                        handler: function(){ this.ventanaResponsable.hide() },
                        scope: this
                    }]
            });
            this.cmpResponsable = this.formAuto.getForm().findField('id_funcionario');
            this.cmpAp = id_ap;
        },
        saveResponsable:function () {
          Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/ReponAccion/insertarReponAccion',
                params: {
                    obs_dba  : '',
                    id_ap :  this.cmpAp,
                    id_funcionario : this.cmpResponsable.getValue(),
                },
                isUpload: false,
                success: function(a,b,c){
                    Phx.CP.loadingHide();
                    this.ventanaResponsable.hide();
                    this.storeResponsable.baseParams.id_ap = this.cmpAp ;
                    this.storeResponsable.load();
                    this.cmpAp  = null;
                },
                argument: this.argumentSave,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        }
    }
</script>
