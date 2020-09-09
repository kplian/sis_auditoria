<?php
/**
 *@package pXP
 *@file InformeAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.InformeAuditoria = {
    bedit:true,
    bnew:false,
    bsave:false,
    bdel:false,
    bodyStyleForm: 'padding:5px;',
    borderForm: true,
    frameForm: false,
    paddingForm: '5 5 5 5',
    require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
    requireclase:'Phx.vista.AuditoriaOportunidadMejora',
    title:'AuditoriaOportunidadMejora',
    nombreVista: 'InformeAuditoria',
    storePunto: {},
    tienda:{},
    punto:{},
    constructor: function(config) {
        this.Atributos[this.getIndAtributo('id_tipo_om')].grid=false;
        this.Atributos[this.getIndAtributo('fecha_eje_inicio')].grid=false;
        this.Atributos[this.getIndAtributo('fecha_eje_fin')].grid=false;
        this.idContenedor = config.idContenedor;
        Phx.vista.InformeAuditoria.superclass.constructor.call(this,config);
        this.getBoton('sig_estado').setVisible(false);

        this.recomendacionForm();
        this.store.baseParams.interfaz = this.nombreVista;
        this.init();
        this.addButton('notifcar_respo',{
            text:'Notificar Resp. Area',
            grupo:[0],
            iconCls: 'bok',
            disabled: true,
            handler: this.sigEstado,
            tooltip: '<b>Pasar al Siguiente Estado</b>'
        });
        this.load({params:{start:0, limit:this.tam_pag}});
    },
    EnableSelect: function(){
      Phx.vista.InformeAuditoria.superclass.EnableSelect.call(this);
    },
    onButtonEdit:function(){
      this.onCrearFormulario();
      this.abrirVentana('edit');
    },
    abrirVentana: function(tipo){
      if(tipo === 'edit'){
          this.cargaFormulario(this.sm.getSelected().data);
          // this.onEdit(this.sm.getSelected().data);
      }
      this.formularioVentana.show();
    },
    onCrearFormulario:function() {
      if(this.formularioVentana) {
            this.form.destroy();
            this.formularioVentana.destroy();
      }
      const me = this;
      const maestro = this.sm.getSelected().data;

        console.log(maestro)
       this.tienda = new Ext.data.JsonStore({
           url: '../../sis_auditoria/control/NoConformidad/listarNoConformidad',
           id: 'id_nc',
           root: 'datos',
           totalProperty: 'total',
           fields: ['id_aom','id_nc','valor_parametro','estado_wf','descrip_nc',
               'calidad',
               'medio_ambiente',
               'seguridad',
               'responsabilidad_social',
               'sistemas_integrados',
               'obs_resp_area',
               'obs_consultor',
               'evidencia',
               'id_parametro',
               'id_pnnc'
           ],
           remoteSort: true,
           baseParams: {dir:'ASC',sort:'id_nc',limit:'100',start:'0'}
       });
        this.tienda.baseParams.id_aom = maestro.id_aom;
        this.tienda.load();
        const noConformidad = new Ext.grid.GridPanel({
                  layout: 'fit',
                  store: this.tienda,
                  region: 'center',
                  trackMouseOver: false,
                  split: true,
                  border: true,
                  plain: true,
                  stripeRows: true,
                  tbar: [{
                      text:'<button class="btn"><i class="fa fa-plus fa-lg"></i>&nbsp;&nbsp;<b>Asignar</b></button>',
                      scope: this,
                      width: '100',
                      handler: function() {
                         me.formularioNoConformidad(null);
                         me.ventanaNoConformidad.show();
                      },
                  },
                  {
                      text:'<button class="btn"><i class="fa fa-edit fa-lg"></i>&nbsp;&nbsp;<b>Editar</b></button>',
                      scope:this,
                      width: '100',
                      handler: function(){
                          const  s =  noConformidad.getSelectionModel().getSelections();
                           me.formularioNoConformidad(s[0].data);
                           me.ventanaNoConformidad.show();
                      }
                  },
                  {
                      text: '<button class="btn"><i class="fa fa-trash fa-lg"></i>&nbsp;&nbsp;<b>Eliminar</b></button>',
                      scope:this,
                      width: '100',
                      handler: function(){
                          const  s =  noConformidad.getSelectionModel().getSelections();
                          Phx.CP.loadingShow();
                          Ext.Ajax.request({
                              url: '../../sis_auditoria/control/NoConformidad/eliminarNoConformidad',
                              params: {
                                  id_nc : s[0].data.id_nc
                              },
                              isUpload: false,
                              success: function(a,b,c){
                                  Phx.CP.loadingHide();
                                  me.tienda.load();
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
                           header: 'Tipo',
                           dataIndex: 'valor_parametro',
                           align: 'center',
                           width: 100,
                          renderer : function(value, p, record) {
                              return String.format('<div class="gridmultiline" style=" font-size: 10px; ">{0}</div>', record.data['valor_parametro']);
                          }
                       },
                       {
                           header: 'Descripcion',
                           dataIndex: 'descrip_nc',
                           align: 'justify',
                           width: 400,
                           renderer : function(value, p, record) {
                               return String.format('<div class="gridmultiline" style=" font-size: 10px; ">{0}</div>', record.data['descrip_nc']);
                           }
                       },
                       {
                           header: 'Estado',
                           dataIndex: 'estado_wf',
                           align: 'center',
                           width: 150,
                           renderer : function(value, p, record) {
                               return String.format('<div class="gridmultiline" style=" font-size: 10px; ">{0}</div>', record.data['estado_wf']);
                           }
                       }
                  ]
              });
        this.form = new Ext.form.FormPanel({
           id: this.idContenedor + '_formulario_aud',
           items: [{ region: 'center',
                    layout: 'column',
                    border: false,
                    autoScroll: true,
                    items: [{
                           xtype: 'tabpanel',
                           plain: true,
                           activeTab: 0,
                           height: 600,
                           deferredRender: false,
                           items: [{
                               title: 'Datos Principales',
                               layout: 'form',
                               defaults: {
                                 width: 600,
                               },
                               autoScroll: true,
                               defaultType: 'textfield',
                               items: [
                                 new Ext.form.FieldSet({
                                         collapsible: false,
                                         border : false,
                                          items: [
                                              new Ext.form.FieldSet({
                                                  collapsible: false,
                                                  border: true,
                                                  layout: 'form',
                                                  defaults: {width: 750},
                                                  items: [
                                              {
                                                  xtype: 'field',
                                                  name: 'nro_tramite_wf',
                                                  fieldLabel: 'Codigo',
                                                  anchor: '100%',
                                                  readOnly :true,
                                                  id: this.idContenedor+'_nro_tramite_wf',
                                                  style: 'background-image: none; background: #eeeeee;'
                                              },
                                              {
                                                 xtype: 'field',
                                                 name: 'estado_wf',
                                                 fieldLabel: 'Estado',
                                                 anchor: '100%',
                                                 readOnly :true,
                                                 id: this.idContenedor+'_estado_wf',
                                                  style: 'background-image: none; background: #eeeeee;'

                                              },
                                              {
                                                  xtype: 'field',
                                                  fieldLabel: 'Area',
                                                  name: 'nombre_unidad',
                                                  anchor: '100%',
                                                  readOnly :true,
                                                  id: this.idContenedor+'_nombre_unidad',
                                                  style: 'background-image: none; background: #eeeeee;'

                                              },
                                              {
                                                 xtype: 'field',
                                                 fieldLabel: 'Nombre',
                                                 name: 'nombre_aom1',
                                                 anchor: '100%',
                                                 readOnly :true,
                                                 id: this.idContenedor+'_nombre_aom1',
                                                  style: 'background-image: none; background: #eeeeee;'

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
                                                   readOnly :true,
                                                   anchor: '100%',
                                                   style: 'background-image: none; background: #eeeeee;'
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
                                                    readOnly :true,
                                                     anchor: '100%',
                                                    style: 'background-image: none; background: #eeeeee;'
                                                   },
                                                  {
                                                      xtype: 'datefield',
                                                      fieldLabel: 'Inicio Real',
                                                      name: 'fecha_prog_inicio',
                                                      disabled: false,
                                                      id: this.idContenedor+'_fecha_prog_inicio',
                                                      readOnly :true,
                                                      anchor: '100%',
                                                      style: 'background-image: none; background: #eeeeee;'
                                                  },
                                                   {
                                                     xtype: 'datefield',
                                                     fieldLabel: 'Fin Real',
                                                     name: 'fecha_prog_fin',
                                                     disabled: false,
                                                     id: this.idContenedor+'_fecha_prog_fin',
                                                     readOnly :true,
                                                      anchor: '100%',
                                                       style: 'background-image: none; background: #eeeeee;'
                                                  },
                                                  {
                                                   xtype: 'combo',
                                                   name: 'id_funcionario',
                                                   fieldLabel: 'Auditor Reponsable',
                                                   allowBlank: false,
                                                   emptyText: 'Elija una opción...',
                                                   id: this.idContenedor+'_id_funcionario',
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
                                                       fields: ['id_funcionario','desc_funcionario1','descripcion_cargo','cargo_equipo'],
                                                       remoteSort: true,
                                                       baseParams: {par_filtro: 'fu.desc_funcionario1'}
                                                   }),
                                                   valueField: 'id_funcionario',
                                                   displayField: 'desc_funcionario1',
                                                   gdisplayField: 'desc_funcionario2',
                                                   hiddenName: 'id_funcionario',
                                                   mode: 'remote',
                                                   anchor: '100%',
                                                   triggerAction: 'all',
                                                   lazyRender: true,
                                                   pageSize: 15,
                                                   minChars: 2,
                                                   readOnly :true,
                                                      style: 'background-image: none; background: #eeeeee;'
                                                 },
                                                      ]}),
                                              new Ext.form.FieldSet({
                                                  collapsible: false,
                                                  border: true,
                                                  layout: 'form',
                                                  defaults: {width: 750},
                                                  items: [
                                                 {
                                                  xtype: 'combo',
                                                  name: 'id_destinatario',
                                                  fieldLabel: 'Destinatario',
                                                  allowBlank: false,
                                                  emptyText: 'Elija una opción...',
                                                  id: this.idContenedor+'_id_destinatario',
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
                                                      fields: ['id_funcionario','desc_funcionario1','descripcion_cargo'],
                                                      remoteSort: true,
                                                      baseParams: {par_filtro: 'fc.desc_funcionario1'}
                                                  }),
                                                  valueField: 'id_funcionario',
                                                  displayField: 'desc_funcionario1',
                                                  gdisplayField: 'desc_funcionario_destinatario',
                                                  hiddenName: 'id_destinatario',
                                                  mode: 'remote',
                                                  anchor: '100%',
                                                  triggerAction: 'all',
                                                  lazyRender: true,
                                                  pageSize: 15,
                                                  minChars: 2,
                                                },
                                                {
                                                      anchor: '100%',
                                                      bodyStyle: 'padding:10px;',
                                                      title: 'Destinatarios Adicionales',
                                                      items:[{
                                                          xtype: 'itemselector',
                                                          name: 'id_destinatarios',
                                                          fieldLabel: 'Destinatarios',
                                                         imagePath: '../../../pxp/lib/ux/images/',
                                                          drawUpIcon:false,
                                                          drawDownIcon:false,
                                                          drawTopIcon:false,
                                                          drawBotIcon:false,
                                                          multiselects: [{
                                                            width: 250,
                                                            height: 200,
                                                              store: new Ext.data.JsonStore({
                                                                  url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarFuncionarioVigentes',
                                                                  id: 'id_funcionario',
                                                                  root: 'datos',
                                                                  sortInfo: {
                                                                    field: 'desc_funcionario1',
                                                                    direction: 'DESC'
                                                                  },
                                                                  totalProperty: 'total',
                                                                  fields: ['id_funcionario', 'desc_funcionario1'],
                                                                  remoteSort: true,
                                                                  autoLoad: true,
                                                                  baseParams: { dir:'ASC', sort:'id_funcionario', limit:'100', start:'0'}
                                                              }),
                                                              tbar:[{
                                                                  text: 'Todo',
                                                                  handler:function(){
                                                                      const toStore  = isForm.getForm().findField('id_proceso').multiselects[0].store;
                                                                      const fromStore   = isForm.getForm().findField('id_proceso').multiselects[1].store;
                                                                      for(var i = toStore.getCount()-1; i >= 0; i--)
                                                                      {
                                                                          const record = toStore.getAt(i);
                                                                          toStore.remove(record);
                                                                          fromStore.add(record);
                                                                      }
                                                                  }
                                                              }],
                                                              displayField: 'desc_funcionario1',
                                                              valueField: 'id_funcionario',
                                                          },
                                                          {
                                                              width: 250,
                                                              height: 200,
                                                              store: new Ext.data.JsonStore({
                                                                  url: '../../sis_auditoria/control/Destinatario/listarDestinatario',
                                                                  id: 'id_funcionario',
                                                                  root: 'datos',
                                                                  totalProperty: 'total',
                                                                  fields: ['id_funcionario', 'desc_funcionario1'],
                                                                  remoteSort: true,
                                                                  autoLoad: true,
                                                                  baseParams: { dir:'ASC',
                                                                                sort:'id_aom',
                                                                                limit:'100',
                                                                                start:'0',
                                                                                id_aom:maestro.id_aom,
                                                                              }
                                                              }),
                                                              tbar:[{
                                                                  text: 'Limpiar',
                                                                  handler:function(){
                                                                      isForm.getForm().findField('id_proceso').reset();
                                                                  }
                                                              }],
                                                              displayField: 'desc_funcionario1',
                                                              valueField: 'id_funcionario',
                                                          }]
                                                      }]
                                                  },
                                                  ]})
                                         ]
                                 }),

                                ]
                          },
                          {
                               title: 'Resumen (4-R-27)',
                               layout: 'column',
                               defaults: {width: 600},
                               autoScroll: true,
                               defaultType: 'textfield',
                               items: [
                                       {
                                          xtype: 'htmleditor',
                                          name: 'resumen',
                                          width:600,
                                          height:459,
                                          id: this.idContenedor+'_resumen',
                                      },
                                   ]
                           },
                           {
                               title: 'Recomendacion',
                               layout: 'column',
                               defaults: {width: 600},
                               autoScroll: true,
                               defaultType: 'textfield',
                               items: [
                                       {
                                          xtype: 'textarea',
                                          name: 'Recomendaciones',
                                          width:600,
                                          height:459,
                                          id: this.idContenedor+'_recomendacion',
                                      },
                                   ]
                           },
                           {
                               title: 'No Conformidades (4-R-10)',
                               layout: 'fit',
                               region:'center',
                               items: [
                                    noConformidad
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
        this.formularioVentana = new Ext.Window({
           width: 700,
           height: 600,
           modal: true,
           closeAction: 'hide',
           labelAlign: 'top',
           title: 'Informe Auditoria',
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
      const arratFormulario = [];
            const submit={};
            Ext.each(this.form.getForm().items.keys, function(element, index){
                obj = Ext.getCmp(element);
                if(obj.items){
                    Ext.each(obj.items.items, function(elm, ind){
                        submit[elm.name]=elm.getValue();
                    },this)
                } else {
                    submit[obj.name]=obj.getValue();
                    if(obj.name == 'id_tnorma' || obj.name == 'id_tobjeto'){
                        if(obj.selectedIndex!=-1){
                            submit[obj.name]=obj.store.getAt(obj.selectedIndex).id;
                        }
                    }
                }
            },this);
         const { id_destinatario, id_destinatarios, recomendacion, resumen  } = submit;
         const v3g = { id_destinatario, id_destinatarios, recomendacion };
         arratFormulario.push(v3g);
         const maestro = this.sm.getSelected().data;

            if (this.form.getForm().isValid()) {
                     Phx.CP.loadingShow();
                     Ext.Ajax.request({
                         url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/planifiacionAuditoria',
                         params: {
                             id_aom :maestro.id_aom,
                             arratFormulario: JSON.stringify(arratFormulario),
                             resumen : resumen,
                             informe :'si'
                         },
                         isUpload: false,
                         success: function(a,b,c){
                             this.store.rejectChanges();
                             Phx.CP.loadingHide();
                             this.formularioVentana.hide();
                             this.reload();
                         },
                         argument: this.argumentSave,
                         failure: this.conexionFailure,
                         timeout: this.timeout,
                         scope: this
                     });
                } else {
                    Ext.MessageBox.alert('Validación', 'Existen datos inválidos en el formulario. Corrija y vuelva a intentarlo');
                }
    },
    cargaFormulario: function(data){
      var obj,key;
      Ext.each(this.form.getForm().items.keys, function(element, index){
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
    preparaMenu:function(n){
        var tb =this.tbar;
        Phx.vista.InformeAuditoria.superclass.preparaMenu.call(this,n);
        this.getBoton('notifcar_respo').enable();
        this.getBoton('btnChequeoDocumentosWf').enable();
        this.getBoton('diagrama_gantt').enable();
        this.getBoton('ant_estado').enable();
        return tb
    },
    liberaMenu:function(){
        var tb = Phx.vista.InformeAuditoria.superclass.liberaMenu.call(this);
        if(tb){
            this.getBoton('notifcar_respo').disable();
            this.getBoton('btnChequeoDocumentosWf').disable();
            this.getBoton('diagrama_gantt').disable();
            this.getBoton('ant_estado').disable();
        }
        return tb
    },
    onReporte:function () {
        var rec=this.sm.getSelected();
        Ext.Ajax.request({
            url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/reporteResumen',
            params:{'id_aom':rec.data.id_aom},
            success: this.successExport,
            failure: this.conexionFailure,
            timeout:this.timeout,
            scope:this
        });
    },
    onRecomendacion:function () {
        var data = this.getSelectedData();
        if(data){
            this.cmpRecomendacion.setValue(data.recomendacion);
            this.ventanaRecomendacion.show();
        }
    },
    recomendacionForm:function () {
        var recomendacion = new Ext.form.TextArea({
            name: 'recomendacion',
            msgTarget: 'title',
            fieldLabel: 'Recomendacion',
            allowBlank: true,
            width:400,
            height:100
        });
        this.formRecomendacion = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            autoDestroy: true,
            border: false,
            layout: 'form',
            autoHeight: true,
            items: [recomendacion]
        });
        this.ventanaRecomendacion = new Ext.Window({
            title: 'Recomendacion de Auditoria',
            collapsible: true,
            maximizable: true,
            autoDestroy: true,
            width: 550,
            height: 200,
            layout: 'fit',
            plain: true,
            bodyStyle: 'padding:5px;',
            buttonAlign: 'center',
            items: this.formRecomendacion,
            modal:true,
            closeAction: 'hide',
            buttons: [{
                text: 'Guardar',
                handler: this.saveRecomendacion,
                scope: this},
                {
                    text: 'Cancelar',
                    handler: function(){ this.ventanaRecomendacion.hide() },
                    scope: this
                }]
        });
        this.cmpRecomendacion = this.formRecomendacion.getForm().findField('recomendacion');
    },
    saveRecomendacion:function () {
        var d = this.getSelectedData();
        Phx.CP.loadingShow();
        Ext.Ajax.request({
            url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/insertSummary',
            params: {
                id_aom: d.id_aom,
                recomendacion: this.cmpRecomendacion.getValue()
            },
            success: this.successSincExtra,
            failure: this.conexionFailure,
            timeout: this.timeout,
            scope: this
        });
    },
    successSincExtra:function(resp){
        Phx.CP.loadingHide();
        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
        if(!reg.ROOT.error){
            if(this.ventanaRecomendacion){
                this.ventanaRecomendacion.hide();
            }
            this.load({params: {start: 0, limit: this.tam_pag}});
        }else{
            alert('ocurrio un error durante el proceso')
        }
    },
    onNoConformidades:function () {
        var rec = this.sm.getSelected();
        Phx.CP.loadWindows('../../../sis_auditoria/vista/no_conformidad/NoConformidadGestion.php', 'Gestion No conformidades',{
            //modal : true,
            width:'90%',
            height:'90%'
        }, rec.data,this.idContenedor, 'NoConformidadGestion');
    },
    onReloadPage : function(m){
          this.maestro = m;
          console.log('=22222>',this);
          this.store.baseParams = {
            id_gestion:  this.maestro.id_gestion,
            desde:  this.maestro.desde,
            hasta:  this.maestro.hasta,
            start:0,
            limit:50,
            sort:'id_aom',
            dir:'DESC',
            interfaz: this.nombreVista,
            contenedor: this.idContenedor
          };
          this.store.reload({ params: this.store.baseParams});
    },
    formularioNoConformidad:function(data){
        const maestro = this.sm.getSelected().data;
        const me = this;
        let id_modificacion = null;
        if(data){
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
            this.punto.baseParams.id_nc = data.id_nc;
            this.punto.load();
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
                    width: 150,
                    sortable: false,
                    renderer:function(value, p, record){return String.format('{0}', record.data['sigla_norma'])},
                },
                {
                    header: 'Codigo',
                    dataIndex: 'codigo_pn',
                    width: 150,
                    sortable: false,
                },
                {
                    header: 'Punto de Norma',
                    dataIndex: 'id_pn',
                    width: 300,
                    sortable: false,
                    renderer:function(value, p, record){return String.format('{0}', record.data['nombre_pn'])},
                },
            ],
            tbar: [{
                text: '<button class="btn"><i class="fa fa-edit fa-lg"></i>&nbsp;&nbsp;<b>Asignar / Designar Punto de Norma</b></button>',
                scope: this,
                width: '100',
                handler: function() {
                    if(data){
                        me.formularioPuntoNorma(data);
                        me.ventanaPuntoNorma.show();
                    }else {
                        alert('Debe almacenar los datos generales de la NO Conformidad')
                    }

                }
            }]
        });
        const isForm = new Ext.form.FormPanel({
            items: [new Ext.form.FieldSet({
                // title:'Datos Generales',
                collapsible: false,
                border: true,
                layout: 'form',
                defaults: { width: 600},
                items: [
                    {
                        xtype: 'field',
                        fieldLabel: 'Código Auditoria',
                        name: 'nro_tramite_wf',
                        anchor: '100%',
                        value: maestro.nro_tramite_wf,
                        readOnly :true,
                        style: 'background-image: none; background: #eeeeee;'

                    },
                    {
                        xtype: 'field',
                        fieldLabel: 'Nombre Auditoria',
                        name: 'nombre_aom1',
                        anchor: '100%',
                        value: maestro.nombre_aom1,
                        readOnly :true,
                        style: 'background-image: none; background: #eeeeee;'

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
                        style: 'background-image: none; background: #eeeeee;'
                    },
                    {
                        xtype: 'combo',
                        name: 'id_funcionario',
                        fieldLabel: 'Resp. Area de NC',
                        allowBlank: false,
                        resizable:true,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_auditoria/control/NoConformidad/listarSomUsuario',
                            id: 'id_funcionario',
                            root: 'datos',
                            sortInfo: {
                                field: 'id_funcionario',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_funcionario', 'desc_funcionario1'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'ofunc.id_funcionario#ofunc.desc_funcionario1'}
                        }),
                        valueField: 'id_funcionario',
                        displayField: 'desc_funcionario1',
                        gdisplayField: 'desc_funcionario1',
                        hiddenName: 'id_funcionario',
                        mode: 'remote',
                        triggerAction: 'all',
                        lazyRender: true,
                        pageSize: 15,
                        minChars: 2,
                        anchor: '100%',
                        readOnly :true,
                        style: 'background-image: none; background: #eeeeee;'
                    },
                    {
                        xtype: 'combo',
                        name: 'id_parametro',
                        fieldLabel: 'Tipo',
                        allowBlank: true,
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
                                    return record.data['calidad'] == 'true' ? 'si' : 'no';
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
                                    return record.data['medio_ambiente'] == 'true' ? 'si' : 'no';
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
                                    return record.data['seguridad'] == 'true' ? 'si' : 'no';
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
                                    return record.data['responsabilidad_social'] == 'true' ? 'si' : 'no';
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
                                    return record.data['sistemas_integrados'] == 'true' ? 'si' : 'no';
                                },
                                gwidth : 50
                            }
                        ]
                    }),
                    {
                        xtype: 'textarea',
                        name: 'descrip_nc',
                        fieldLabel: 'Descripcion',
                        allowBlank: true,
                        anchor: '100%',
                        gwidth: 280
                    },
                    {
                        xtype: 'textarea',
                        name: 'evidencia',
                        fieldLabel: 'Evidencia',
                        allowBlank: true,
                        anchor: '100%',
                        gwidth: 280
                    },
                    /*{
                        xtype: 'field',
                        name: 'obs_resp_area',
                        fieldLabel: 'Observacion responsable de Area',
                        allowBlank: true,
                        anchor: '100%',
                        gwidth: 150
                    },*/
                    {
                        xtype: 'textarea',
                        name: 'obs_consultor',
                        fieldLabel: 'Observacion Consultor',
                        allowBlank: true,
                        anchor: '100%',
                        gwidth: 150
                    },
                    table
                ]
            })],
            padding: this.paddingForm,
            bodyStyle: this.bodyStyleForm,
            border: this.borderForm,
            frame: this.frameForm,
            autoScroll: false,
            autoDestroy: true,
            autoScroll: true,
            region: 'center'
        });
        if(data){
            isForm.getForm().findField('calidad').setValue(this.onBool(data.calidad));
            isForm.getForm().findField('medio_ambiente').setValue(this.onBool(data.medio_ambiente));
            isForm.getForm().findField('seguridad').setValue(this.onBool(data.seguridad));
            isForm.getForm().findField('responsabilidad_social').setValue(this.onBool(data.responsabilidad_social));
            isForm.getForm().findField('sistemas_integrados').setValue(this.onBool(data.sistemas_integrados));
            isForm.getForm().findField('descrip_nc').setValue(data.descrip_nc);
            isForm.getForm().findField('evidencia').setValue(data.evidencia);
            isForm.getForm().findField('obs_consultor').setValue(data.obs_consultor);
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/getNoConformidad',
                params:{ id_nc: data.id_nc },
                success:function(resp){
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    isForm.getForm().findField('id_parametro').setValue(reg.ROOT.datos.id_parametro);
                    isForm.getForm().findField('id_parametro').setRawValue(reg.ROOT.datos.valor_parametro);
                },
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
        }
        Ext.Ajax.request({
            url:'../../sis_auditoria/control/NoConformidad/getUo',
            params:{ id_uo: maestro.id_uo },
            success:function(resp){
                const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                isForm.getForm().findField('id_uo').setValue(reg.ROOT.datos.id_uo);
                isForm.getForm().findField('id_uo').setRawValue(reg.ROOT.datos.nombre_unidad);
                isForm.getForm().findField('id_funcionario').setValue(reg.ROOT.datos.id_funcionario);
                isForm.getForm().findField('id_funcionario').setRawValue(reg.ROOT.datos.desc_funcionario1);
            },
            failure: this.conexionFailure,
            timeout:this.timeout,
            scope:this
        });

        this.ventanaNoConformidad = new Ext.Window({
            width: 710,
            height: 600,
            modal: true,
            closeAction: 'hide',
            labelAlign: 'bottom',
            title: 'No conformidades',
            bodyStyle: 'padding:5px',
            layout: 'border',
            items: [isForm],
            buttons: [{
                text: 'Guardar',
                handler: function () {
                    let submit={};
                    Ext.each(isForm.getForm().items.keys, function(element, index){
                        obj = Ext.getCmp(element);
                        if(obj.items){
                            Ext.each(obj.items.items, function(elm, ind){
                                submit[elm.name]=elm.getValue();
                            },this)
                        } else {
                            submit[obj.name]=obj.getValue();
                        }
                    },this);
                    console.log(submit);
                    Phx.CP.loadingShow();
                    Ext.Ajax.request({
                        url: '../../sis_auditoria/control/NoConformidad/insertarItemNoConformidad',
                        params: {
                            id_aom  : maestro.id_aom,
                            nro_tramite_padre : maestro.nro_tramite_wf,
                            id_parametro : submit.id_parametro,
                            id_uo : submit.id_uo,
                            id_funcionario : submit.id_funcionario,
                            calidad : submit.calidad,
                            medio_ambiente : submit.medio_ambiente,
                            responsabilidad_social : submit.responsabilidad_social,
                            seguridad : submit.seguridad,
                            sistemas_integrados : submit.sistemas_integrados,
                            descrip_nc : submit.descrip_nc,
                            evidencia : submit.evidencia,
                            obs_resp_area : '',// submit.obs_resp_area,
                            obs_consultor : submit.obs_consultor,
                            id_norma : submit.id_norma,
                            // id_pn : submit.id_pn,
                            id_nc : id_modificacion
                        },
                        isUpload: false,
                        success: function(a,b,c){
                            Phx.CP.loadingHide();
                            me.ventanaNoConformidad.hide();
                            me.tienda.load();
                            // this.storeProceso.load();
                        },
                        argument: this.argumentSave,
                        failure: this.conexionFailure,
                        timeout: this.timeout,
                        scope: this
                    });
                },
                scope: this
            }, {
                text: 'Declinar',
                handler: function() {
                    me.ventanaNoConformidad.hide();
                },
                scope: this
            }]
        });
    },
    onBool:function(valor){
        if(valor === 't'){
            return true;
        }
        return  false;
    },
    sigEstado:function(){
        Phx.CP.loadingShow();
        const rec = this.sm.getSelected();
        const id_estado_wf = rec.data.id_estado_wf;
        const id_proceso_wf = rec.data.id_proceso_wf;
        if(confirm('¿Desea Notificar al Responsable la Auditoria')){
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/aprobarEstado',
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
    formularioPuntoNorma:function(data){
            const maestro = this.sm.getSelected().data;
            const me = this;
            const isForm = new Ext.form.FormPanel({
                // id: this.idContenedor + '_formulario_punto_norm',
                items: [{
                    xtype: 'field',
                    fieldLabel: 'Auditoria',
                    name: 'nro_tramite_wf',
                    anchor: '100%',
                    value: '('+maestro.nro_tramite_wf+') '+maestro.nombre_aom1,
                    readOnly :true,
                    style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                        xtype: 'field',
                        fieldLabel: 'Tipo',
                        name: 'desc_tipo_norma',
                        anchor: '100%',
                        value: maestro.desc_tipo_norma,
                        readOnly :true,
                        style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                        xtype: 'textarea',
                        name: 'descrip_nc',
                        fieldLabel: 'Descripcion',
                        allowBlank: true,
                        anchor: '100%',
                        gwidth: 280,
                        value: data.descrip_nc,
                        readOnly :true,
                        style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                        xtype: 'combo',
                        name: 'id_norma',
                        fieldLabel: 'Norma',
                        allowBlank: false,
                        // id: this.idContenedor+'_id_norma',
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_auditoria/control/Norma/listarNorma',
                            id: 'id_norma',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre_norma',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_norma', 'id_tipo_norma','nombre_norma','sigla_norma','descrip_norma'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'nor.sigla_norma'}
                        }),
                        valueField: 'id_norma',
                        displayField: 'sigla_norma',
                        gdisplayField: 'sigla_norma',
                        tpl:'<tpl for="."><div class="x-combo-list-item"><p style="color:#01010a">{sigla_norma} - {nombre_norma}</p></div></tpl>',
                        hiddenName: 'id_norma',
                        mode: 'remote',
                        anchor: '100%',
                        triggerAction: 'all',
                        lazyRender: true,
                        pageSize: 15,
                        minChars: 2
                    },
                    {
                        anchor: '100%',
                        bodyStyle: 'padding:10px;',
                        items:[{
                            xtype: 'itemselector',
                            name: 'id_pn',
                            //  id: this.idContenedor+'id_pn',
                            fieldLabel: 'Punto Noma',
                            imagePath: '../../../pxp/lib/ux/images/',
                            drawUpIcon:false,
                            drawDownIcon:false,
                            drawTopIcon:false,
                            drawBotIcon:false,
                            multiselects: [{
                                width: 300,
                                height: 250,
                                store: new Ext.data.JsonStore({
                                    url: '../../sis_auditoria/control/PuntoNorma/listarPuntoNormaMulti',
                                    id: 'id_pn',
                                    root: 'datos',
                                    sortInfo: {
                                        field: 'nombre_descrip',
                                        direction: 'ASC'
                                    },
                                    totalProperty: 'total',
                                    fields: ['id_pn', 'nombre_pn','nombre_descrip'],
                                    remoteSort: true,
                                    baseParams: {dir:'ASC',sort:'id_pn',limit:'100',start:'0'}
                                }),
                                displayField: 'nombre_descrip',
                                valueField: 'id_pn',
                            },{
                                width: 300,
                                height: 250,
                                store: new Ext.data.JsonStore({
                                    url: '../../sis_auditoria/control/PnormaNoconformidad/listarPnormaNoconformidad',
                                    id: 'id_pn',
                                    root: 'datos',
                                    totalProperty: 'total',
                                    fields: ['id_pn', 'nombre_pn','nombre_descrip'],
                                    remoteSort: true,
                                    baseParams: {dir:'ASC',sort:'id_pn',limit:'100',start:'0', id_nc: data.id_nc}
                                }),
                                displayField: 'nombre_descrip',
                                valueField: 'id_pn',
                            }]
                        }]
                    }
                ],
                padding: this.paddingForm,
                bodyStyle: this.bodyStyleForm,
                border: this.borderForm,
                frame: this.frameForm,
                autoDestroy: true,
                autoScroll: true,
                region: 'center'
            });
           isForm.getForm().findField('id_norma').on('select', function(combo, record, index){
                isForm.getForm().findField('id_pn').multiselects[0].store.baseParams = {dir: "ASC", sort: "id_aom", limit: "100", start: "0", id_norma: record.data.id_norma,item :maestro.id_aom};
                isForm.getForm().findField('id_pn').multiselects[1].store.baseParams = {dir: "ASC", sort: "id_aom", limit: "100", start: "0", id_nc: data.id_nc,id_norma: record.data.id_norma};
                isForm.getForm().findField('id_pn').multiselects[1].store.load();
                isForm.getForm().findField('id_pn').modificado = true;
                isForm.getForm().findField('id_pn').reset();
            },this);

            this.ventanaPuntoNorma = new Ext.Window({
                width: 700,
                height: 480,
                modal: true,
                closeAction: 'hide',
                labelAlign: 'bottom',
                title: 'Selección de punto de norma',
                bodyStyle: 'padding:5px',
                layout: 'form',
                items: [
                    isForm
                ],
                buttons: [{
                    text: 'Guardar',
                    handler: function(){
                        const submit={};
                        Ext.each(isForm.getForm().items.keys, function(element, index){
                            obj = Ext.getCmp(element);
                            if(obj.items){
                                Ext.each(obj.items.items, function(elm, ind){
                                    submit[elm.name]=elm.getValue();
                                },this)
                            } else {
                                submit[obj.name]=obj.getValue();
                            }
                        },this);
                        console.log(submit)
                        Phx.CP.loadingShow();
                        Ext.Ajax.request({
                            url: '../../sis_auditoria/control/PnormaNoconformidad/insertarItemAuditoriaNpn',
                            params: {
                                id_nc :data.id_nc,
                                id_norma:  submit.id_norma,
                                id_pn: submit.id_pn
                            },
                            isUpload: false,
                            success: function(a,b,c){
                                Phx.CP.loadingHide();
                                me.ventanaPuntoNorma.hide();
                                me.punto.load();

                            },
                            argument: this.argumentSave,
                            failure: this.conexionFailure,
                            timeout: this.timeout,
                            scope: this
                        });
                    },
                    scope: this
                },
                    {
                        text: 'Declinar',
                        handler: function() {
                            this.ventanaPuntoNorma.hide();
                        },
                        scope: this
                    }]
            });
        },

        arrayDefaultColumHidden:['nombre_aom1','nombre_unidad','desc_funcionario_resp',
        'nro_tramite','descrip_nc','lugar','desc_tipo_norma','desc_tipo_objeto',
    'desc_funcionario_destinatario','resumen','recomendacion'],
    rowExpander: new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<br>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Nombre Auditoria:&nbsp;&nbsp;</b> {nombre_aom1}</p>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Area:&nbsp;&nbsp;</b> {nombre_unidad}</p>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Responsable Auditoria:&nbsp;&nbsp;</b> {desc_funcionario2}</p>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Tipo Norma:&nbsp;&nbsp;</b> {desc_tipo_norma}</p>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Lugar:&nbsp;&nbsp;</b> {lugar}</p>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Objeto Auditoria:&nbsp;&nbsp;</b> {desc_tipo_objeto}</p>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Destinatario:&nbsp;&nbsp;</b> {desc_funcionario_destinatario}</p>',
        )
    }),
    tabsouth:[
        {
            url:'../../../sis_auditoria/vista/destinatario/Destinatario.php',
            title:'Destinatarios',
            height:'50%',
            cls:'Destinatario'
        },
        {
            url:'../../../sis_auditoria/vista/no_conformidad/NoConformidadGestion.php',
            title:'No Conformidad',
            height:'50%',
            cls:'NoConformidadGestion'
        }
    ]
    };
</script>
