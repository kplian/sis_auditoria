<?php
/**
*@package pXP
*@file PlanificarAuditoria.php
*@author  Maximilimiano Camacho
*@date 24-07-2019
*@description Archivo con la interfaz de usuario que permite
*planificar Auditoria.
*
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PlanificarAuditoria = {
    require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
    requireclase:'Phx.vista.AuditoriaOportunidadMejora',
    title:'Formulario Planificacion de Auditoria',
    nombreVista: 'PlanificarAuditoria',
    bodyStyleForm: 'padding:5px;',
    borderForm: true,
    frameForm: false,
    paddingForm: '5 5 5 5',
    storeProceso:{},
    storeEquipo:{},
    storePuntoNorma:{},
    storeCronograma:{},
    storePregunta:{},
    sigla:'',
    constructor: function(config) {
        this.Atributos[this.getIndAtributo('id_destinatario')].grid=false;
        this.Atributos[this.getIndAtributo('recomendacion')].grid=false;
        this.Atributos[this.getIndAtributo('id_tipo_om')].grid=false;
        Phx.vista.PlanificarAuditoria.superclass.constructor.call(this,config);
        this.getBoton('ant_estado').setVisible(false);
        this.getBoton('btnChequeoDocumentosWf').setVisible(false);

        this.addButton('sig_estado',{
              text:'Ejecutar',
              iconCls: 'bok',
              disabled: true,
              handler: this.sigEstado,
              tooltip: '<b>Ejecutar la auditoria (AI)</b>'
          });
          this.store.baseParams.interfaz = this.nombreVista;
          this.iniciarEvento();
          this.desactivarInputs();
          this.load({params:{start:0, limit:this.tam_pag}});
    },
    EnableSelect: function(){
      Phx.vista.PlanificarAuditoria.superclass.EnableSelect.call(this);
    },
    sigEstado:function(){
        Phx.CP.loadingShow();
        const rec = this.sm.getSelected();
        const id_estado_wf = rec.data.id_estado_wf;
        const id_proceso_wf = rec.data.id_proceso_wf;
        if(confirm('¿Desea EJECUTAR esta auditoria? \n No se podra retornar al estao actual')) {
            if (confirm('La Auditoria se dara por EJECUTAR \n ¿Desea continuar?')) {
                Ext.Ajax.request({
                    url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/aprobarEstado',
                    params: {
                        id_proceso_wf: id_proceso_wf,
                        id_estado_wf: id_estado_wf
                    },
                    success: this.successWizard,
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            }
        }

        Phx.CP.loadingHide();
    },
    successWizard:function(){
        Phx.CP.loadingHide();
        alert('La auditoria esta en modo EJUCUCION');
        this.reload();
    },
    onButtonEdit:function(){
      this.onCrearFormulario();
      this.abrirVentana('edit');
    },
    abrirVentana: function(tipo){
      if(tipo === 'edit'){
          this.cargaFormulario(this.sm.getSelected().data);
          this.onEdit(this.sm.getSelected().data);
      }
      this.formularioVentana.show();
    },
    onCrearFormulario:function(){
        if(this.formularioVentana){
              this.form.destroy();
              this.formularioVentana.destroy();
        }
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

          const detalleCronograma = new Ext.ux.grid.RowEditor({
              saveText: 'Aceptar',
              name: 'btn_editor'
          });

          detalleCronograma.on('beforeedit', this.onInitAddCronograma, this);
          detalleCronograma.on('canceledit', this.onCancelAddCronograma, this);
          detalleCronograma.on('validateedit', this.onUpdateRegisterCronograma, this);
          detalleCronograma.on('afteredit', this.onAfterEditCronograma, this);
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
        const me = this;
        const crorograma = new Ext.grid.GridPanel({
                    layout: 'fit',
                    store:  this.storeCronograma,
                    region: 'center',
                    split: true,
                    border: false,
                    plain: true,
                    trackMouseOver: false,
                    stripeRows: true,
                    tbar: [{
                        text:'<button class="btn"><i class="fa fa-plus fa-lg"></i>&nbsp;&nbsp;<b>Asignar</b></button>',
                        scope: this,
                        width: '100',
                        handler: function() {
                           me.formularioCroronograma(null);
                           me.ventanaCroronograma.show();
                        },
                    },
                    {
                        text:'<button class="btn"><i class="fa fa-edit fa-lg"></i>&nbsp;&nbsp;<b>Editar</b></button>',
                        scope:this,
                        width: '100',
                        handler: function(){
                           const s = crorograma.getSelectionModel().getSelections();
                           if (s.length === 0) {
                             alert('Selection un registro')
                           }
                           me.formularioCroronograma(s[0].data);
                           me.ventanaCroronograma.show();
                        }
                    },
                    {
                        text: '<button class="btn"><i class="fa fa-trash fa-lg"></i>&nbsp;&nbsp;<b>Eliminar</b></button>',
                        scope:this,
                        width: '100',
                        handler: function(){
                          const  s = crorograma.getSelectionModel().getSelections();
                            Phx.CP.loadingShow();
                            Ext.Ajax.request({
                                url: '../../sis_auditoria/control/Cronograma/eliminarCronograma',
                                params: {
                                    id_cronograma : s[0].data.id_cronograma
                                },
                                isUpload: false,
                                success: function(a,b,c){
                                    Phx.CP.loadingHide();
                                    me.storeCronograma.load();
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
                                 const fecha = value.split("-");
                                 return  fecha[2]+'/'+fecha[1]+'/'+fecha[0];
                             }
                         },
                         {
                             header: 'Fecha Fin',
                             dataIndex: 'fecha_fin_activ',
                             align: 'center',
                             width: 100,
                             renderer:function (value,p,record){
                                 const fecha = value.split("-");
                                 return  fecha[2]+'/'+fecha[1]+'/'+fecha[0];
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
                             height: 500,
                             deferredRender: false,
                             items: [{
                                 title: 'Datos Principales',
                                 layout: 'form',
                                 defaults: {width: 750},
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
                                            defaults: {width: 550},
                                            items: [
                                                {
                                                    xtype: 'field',
                                                    fieldLabel: 'Código',
                                                    name: 'nro_tramite_wf',
                                                    anchor: '100%',
                                                    readOnly: true,
                                                    id: this.idContenedor + '_nro_tramite_wf',
                                                    style: 'background-image: none; background: #eeeeee;'
                                                },
                                                {
                                                    xtype: 'field',
                                                    fieldLabel: 'Area',
                                                    name: 'nombre_unidad',
                                                    anchor: '100%',
                                                    readOnly: true,
                                                    id: this.idContenedor + '_nombre_unidad',
                                                    style: 'background-image: none; background: #eeeeee;'
                                                },
                                                {
                                                    xtype: 'field',
                                                    fieldLabel: 'Nombre',
                                                    name: 'nombre_aom1',
                                                    anchor: '100%',
                                                    readOnly: true,
                                                    id: this.idContenedor + '_nombre_aom1',
                                                    style: 'background-image: none; background: #eeeeee;'
                                                },
                                            ]
                                            }),
                                            new Ext.form.FieldSet({
                                                collapsible: false,
                                                border: true,
                                                layout: 'form',
                                                defaults: {width: 750},
                                                items: [
                                                        {
                                                            xtype: 'field',
                                                            fieldLabel: '*Lugar',
                                                            name: 'lugar',
                                                            anchor: '100%',
                                                            allowBlank: false,
                                                            id: this.idContenedor+'_lugar'
                                                        },
                                                        {
                                                            xtype: 'combo',
                                                            fieldLabel: '*Tipo de Auditoria',
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
                                                            anchor: '100%'
                                                        },
                                                        {
                                                            xtype: 'combo',
                                                            fieldLabel: '*Objeto Auditoria',
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
                                                            anchor: '100%'
                                                        },
                                                    {
                                                            xtype: 'datefield',
                                                            fieldLabel: 'Inicio Prev',
                                                            name: 'fecha_prev_inicio',
                                                            disabled: false,
                                                            anchor: '100%',
                                                            id: this.idContenedor+'_fecha_prev_inicio'
                                                        },
                                                        {
                                                            xtype: 'datefield',
                                                            fieldLabel: 'Fin Prev',
                                                            name: 'fecha_prev_fin',
                                                            disabled: false,
                                                            anchor: '100%',
                                                            id: this.idContenedor+'_fecha_prev_fin'
                                                        },
                                                        {
                                                            xtype: 'datefield',
                                                            fieldLabel: '*Inicio Real',
                                                            name: 'fecha_prog_inicio',
                                                            disabled: false,
                                                            anchor: '100%',
                                                            id: this.idContenedor+'_fecha_prog_inicio'
                                                        },
                                                        {
                                                            xtype: 'datefield',
                                                            fieldLabel: '*Fin Real',
                                                            name: 'fecha_prog_fin',
                                                            disabled: false,
                                                            anchor: '100%',
                                                            id: this.idContenedor+'_fecha_prog_fin'
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
                                               tbar: [{
                                                 text: '<button class="btn"><i class="fa fa-edit fa-lg"></i>&nbsp;&nbsp;<b>Asignar / Designar Procesos Auditables</b></button>',
                                                   scope: this,
                                                   width: '100',
                                                   handler: function() {
                                                      me.formularioProceso();
                                                      me.procesoVentana.show();
                                                   }
                                               }],
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
                                               tbar: [{
                                                 text: '<button class="btn"><i class="fa fa-edit fa-lg"></i>&nbsp;&nbsp;<b>Asignar / Designar</b></button>',
                                                   scope: this,
                                                   width: '100',
                                                   handler: function() {
                                                      me.formularioEquipo();
                                                      me.ventanaEquipo.show();
                                                   }
                                               }],
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
                                               ],
                                                tbar: [{
                                                    text: '<button class="btn"><i class="fa fa-edit fa-lg"></i>&nbsp;&nbsp;<b>Asignar / Designar</b></button>',
                                                    scope: this,
                                                    width: '100',
                                                    handler: function() {
                                                        me.formularioPuntoNorma();
                                                        me.ventanaPuntoNorma.show();
                                                    }
                                                }]
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
                                             ],

                                             tbar: [{
                                                 text: '<button class="btn"><i class="fa fa-edit fa-lg"></i>&nbsp;&nbsp;<b>Asignar / Designar</b></button>',
                                                 scope: this,
                                                 width: '100',
                                                 handler: function() {
                                                     me.formularioPregunta();
                                                     me.ventanaPregunta.show();
                                                 }
                                             }]
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
        this.formularioVentana = new Ext.Window({
            width: 860,
            height: 580,
           modal: true,
           closeAction: 'hide',
           labelAlign: 'top',
           title: 'Auditoria Planificacion',
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
            arratFormulario.push(submit);
            const maestro = this.sm.getSelected().data;

            if (this.form.getForm().isValid()) {
                     Phx.CP.loadingShow();
                     Ext.Ajax.request({
                         url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/planifiacionAuditoria',
                         params: {
                             id_aom :maestro.id_aom,
                             arratFormulario: JSON.stringify(arratFormulario),
                             informe:'no'
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
    onEdit:function(record){
        this.accionFormulario = 'EDIT';
        this.storeProceso.baseParams.id_aom = record.id_aom;
        this.storeProceso.load();

        this.storeEquipo.baseParams.id_aom = record.id_aom;
        this.storeEquipo.load();

        this.storePuntoNorma.baseParams.id_aom = record.id_aom;
        this.storePuntoNorma.load();

        this.storeCronograma.baseParams.id_aom = record.id_aom;
        this.storeCronograma.load();
    },
    formularioProceso:function(){
        const maestro = this.sm.getSelected().data;
        const isForm = new Ext.form.FormPanel({
          id: this.idContenedor + '_formulario_proceso',
            items: [{
                        xtype: 'field',
                        fieldLabel: 'Código Auditoria',
                        name: 'nro_tramite_wf',
                        anchor: '100%',
                        value: maestro.nro_tramite_wf,
                        readOnly :true,
                        style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                          xtype: 'field',
                          fieldLabel: 'Nombre Auditoria',
                          name: 'nombre_aom1',
                          anchor: '100%',
                          value: maestro.nombre_aom1,
                          readOnly :true,
                          style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                            anchor: '100%',
                            bodyStyle: 'padding:10px;',
                            items:[{
                                xtype: 'itemselector',
                                name: 'id_proceso',
                                fieldLabel: 'id_proceso',
                                imagePath: '../../../pxp/lib/ux/images/',
                                drawUpIcon:false,
                                drawDownIcon:false,
                                drawTopIcon:false,
                                drawBotIcon:false,
                                multiselects: [{
                                  width: 300,
                                  height: 250,
                                    store: new Ext.data.JsonStore({
                                        url: '../../sis_auditoria/control/Proceso/listarProceso',
                                        id: 'id_proceso',
                                        root: 'datos',
                                        sortInfo: {
                                            field: 'proceso',
                                            direction: 'ASC'
                                        },
                                        totalProperty: 'total',
                                        fields: ['id_proceso', 'proceso'],
                                        remoteSort: true,
                                        autoLoad: true,
                                        baseParams: { dir:'ASC',
                                                      sort:'id_aom',
                                                      limit:'100',
                                                      start:'0',
                                                      item : maestro.id_aom
                                                    }
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
                                    displayField: 'proceso',
                                    valueField: 'id_proceso',
                                },{
                                    width: 300,
                                    height: 250,
                                    store: new Ext.data.JsonStore({
                                        url: '../../sis_auditoria/control/AuditoriaProceso/listarAuditoriaProceso',
                                        id: 'id_proceso',
                                        root: 'datos',
                                        totalProperty: 'total',
                                        fields: ['id_proceso', 'proceso'],
                                        remoteSort: true,
                                        autoLoad: true,
                                        baseParams: { dir:'ASC',
                                                      sort:'id_aom',
                                                      limit:'100',
                                                      start:'0',
                                                      id_aom: maestro.id_aom
                                                    }
                                    }),
                                    tbar:[{
                                        text: 'Limpiar',
                                        handler:function(){
                                            isForm.getForm().findField('id_proceso').reset();
                                        }
                                    }],
                                    displayField: 'proceso',
                                    valueField: 'id_proceso',
                                }]
                        }],
                        }
                    ],

          padding: this.paddingForm,
          bodyStyle: this.bodyStyleForm,
          border: this.borderForm,
          frame: this.frameForm,
          autoDestroy: false,
          autoScroll: true,
          region: 'center'
       });
        this.procesoVentana = new Ext.Window({
         width: 700,
         height: 400,
         modal: true,
         closeAction: 'hide',
         labelAlign: 'bottom',
         title: 'Selección de Procesos Auditables',
         bodyStyle: 'padding:5px',
         layout: 'form',
         items: [
            isForm  //   this.form_pro
         ],
         buttons: [{
             text: 'Guardar',
             handler: function(){
               const arratFormulario = [];
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
                       arratFormulario.push(submit);
                       Phx.CP.loadingShow();
                       Ext.Ajax.request({
                           url: '../../sis_auditoria/control/AuditoriaProceso/itemSelectionAuditoriaProceso',
                           params: {
                               id_aom :maestro.id_aom,
                               id_aproceso: arratFormulario[0].id_proceso
                           },
                           isUpload: false,
                           success: function(a,b,c){

                               // this.store.rejectChanges();
                               Phx.CP.loadingHide();
                               // isForm.getForm().findField('id_proceso').reset()
                               this.procesoVentana.hide();
                               this.storeProceso.load();
                            //   isForm.destroy();
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
                 this.procesoVentana.hide();
             },
             scope: this
         }]
      });
    },
    formularioEquipo:function(){
      const maestro = this.sm.getSelected().data;
      const me = this;
      var isForm = new Ext.form.FormPanel({
            id: this.idContenedor + '_formulario_proceso',
          //  baseCls: 'x-plain',
            items: [{
                        xtype: 'field',
                        fieldLabel: 'Código Auditoria',
                        name: 'nro_tramite_wf',
                        anchor: '100%',
                        value: maestro.nro_tramite_wf,
                        readOnly :true,
                        style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                          xtype: 'field',
                          fieldLabel: 'Nombre Auditoria',
                          name: 'nombre_aom1',
                          anchor: '100%',
                          value: maestro.nombre_aom1,
                          readOnly :true,
                          style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                               xtype: 'combo',
                               fieldLabel: 'Responsable',
                               name: 'id_responsable',
                               allowBlank: false,
                               emptyText: 'Elija una opción...',
                               store: new Ext.data.JsonStore({
                                       url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListAuditores',
                                       id: 'id_funcionario',
                                       root: 'datos',
                                       sortInfo: {
                                         field: 'desc_funcionario1',
                                         direction: 'DESC'
                                       },
                                       totalProperty: 'total',
                                       fields: ['id_funcionario', 'desc_funcionario1'],
                                       remoteSort: true,
                                       baseParams: {par_filtro: 'fu.desc_funcionario1',
                                       codigo:'RESP',
                                       id_uo: maestro.id_uo}
                               }),
                               valueField: 'id_funcionario',
                               displayField: 'desc_funcionario1',
                               gdisplayField: 'desc_funcionario1',
                               hiddenName: 'id_funcionario',
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
                            items:[{
                                xtype: 'itemselector',
                                name: 'id_equipo_auditor',
                                fieldLabel: 'ItemSelector',
                                imagePath: '../../../pxp/lib/ux/images/',
                                drawUpIcon:false,
                                drawDownIcon:false,
                                drawTopIcon:false,
                                drawBotIcon:false,
                                multiselects: [{
                                  width: 300,
                                  height: 250,
                                    store: new Ext.data.JsonStore({
                                        url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListAuditores',
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
                                        baseParams: { dir:'ASC', sort:'id_funcionario', limit:'100', start:'0', codigo:'MEQ', item: maestro.id_aom}
                                    }),
                                    tbar:[{
                                        text: 'Todo',
                                        handler:function(){
                                            const toStore  = isForm.getForm().findField('id_equipo_auditor').multiselects[0].store;
                                            const fromStore   = isForm.getForm().findField('id_equipo_auditor').multiselects[1].store;
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
                                    width: 300,
                                    height: 250,
                                    store: new Ext.data.JsonStore({
                                        url: '../../sis_auditoria/control/EquipoResponsable/listarEquipoResponsable',
                                        id: 'id_funcionario',
                                        root: 'datos',
                                        totalProperty: 'total',
                                        fields: ['id_funcionario', 'desc_funcionario1'],
                                        remoteSort: true,
                                        autoLoad: true,
                                        baseParams: { dir:'ASC', sort:'id_funcionario', limit:'100', start:'0', id_aom:maestro.id_aom, codigo_parametro : 'MEQ'}
                                    }),
                                    tbar:[{
                                        text: 'Limpiar',
                                        handler:function(){
                                            isForm.getForm().findField('id_equipo_auditor').reset();
                                        }
                                    }],
                                    displayField: 'desc_funcionario1',
                                    valueField: 'id_funcionario',
                                }]
                            }]
                        },
                        {
                                   xtype: 'combo',
                                   fieldLabel: 'Interno',
                                   name: 'id_interno',
                                   allowBlank: false,
                                   emptyText: 'Elija una opción...',
                                   store: new Ext.data.JsonStore({
                                           url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/getListAuditores',
                                           id: 'id_funcionario',
                                           root: 'datos',
                                           sortInfo: {
                                             field: 'desc_funcionario1',
                                             direction: 'DESC'
                                           },
                                           totalProperty: 'total',
                                           fields: ['id_funcionario', 'desc_funcionario1'],
                                           remoteSort: true,
                                           baseParams: {par_filtro: 'fu.desc_funcionario1',
                                           codigo:'ETI',
                                           id_uo: maestro.id_uo}
                                   }),
                                   valueField: 'id_funcionario',
                                   displayField: 'desc_funcionario1',
                                   gdisplayField: 'desc_funcionario1',
                                   hiddenName: 'id_funcionario',
                                   mode: 'remote',
                                   anchor: '100%',
                                   triggerAction: 'all',
                                   lazyRender: true,
                                   pageSize: 15,
                                   minChars: 2
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

       Ext.Ajax.request({
          url:'../../sis_auditoria/control/EquipoResponsable/listarEquipoResponsable',
          params:{  dir:'ASC',
                    sort:'id_aom',
                    limit:'100',
                    start:'0',
                    id_aom:maestro.id_aom,
                    codigo_parametro : 'RESP'
                   },
          success:function(resp){
              var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
              isForm.getForm().items.items[2].setValue(reg.datos[0].id_funcionario);
              isForm.getForm().items.items[2].setRawValue(reg.datos[0].desc_funcionario1);
          },
          failure: this.conexionFailure,
          timeout:this.timeout,
          scope:this
      });
      this.ventanaEquipo = new Ext.Window({
         width: 700,
         height: 500,
         modal: true,
         closeAction: 'hide',
         labelAlign: 'bottom',
         title: 'Asignación de Equipo de Auditores',
         bodyStyle: 'padding:5px',
         layout: 'form',
         items: [
          isForm  //   this.form_pro
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

                       Phx.CP.loadingShow();
                       Ext.Ajax.request({
                           url: '../../sis_auditoria/control/EquipoResponsable/insertarItemEquipoResponsable',
                           params: {
                               id_aom :maestro.id_aom,
                               id_equipo_auditor: submit.id_equipo_auditor,
                               id_interno: submit.id_interno,
                               id_responsable: submit.id_responsable
                           },
                           isUpload: false,
                           success: function(a,b,c){
                               Phx.CP.loadingHide();
                               me.ventanaEquipo.hide();
                               me.storeEquipo.load();
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
                 this.ventanaEquipo.hide();
             },
             scope: this
         }]
      });
    },
    formularioPuntoNorma:function(){
      const maestro = this.sm.getSelected().data;
      const me = this;
        const isForm = new Ext.form.FormPanel({
          id: this.idContenedor + '_formulario_punto_norm',
            items: [{
                        xtype: 'field',
                        fieldLabel: 'Código Auditoria',
                        name: 'nro_tramite_wf',
                        anchor: '100%',
                        value: maestro.nro_tramite_wf,
                        readOnly :true,
                        style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                          xtype: 'field',
                          fieldLabel: 'Nombre Auditoria',
                          name: 'nombre_aom1',
                          anchor: '100%',
                          value: maestro.nombre_aom1,
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
                                    tbar:[{
                                        text: 'Todo',
                                        handler:function(){
                                            const toStore  = isForm.getForm().findField('id_pn').multiselects[0].store;
                                            const fromStore   = isForm.getForm().findField('id_pn').multiselects[1].store;
                                            for(var i = toStore.getCount()-1; i >= 0; i--)
                                            {
                                                const record = toStore.getAt(i);
                                                toStore.remove(record);
                                                fromStore.add(record);
                                            }
                                        }
                                    }],
                                    displayField: 'nombre_descrip',
                                    valueField: 'id_pn',
                                },{
                                    width: 300,
                                    height: 250,
                                    store: new Ext.data.JsonStore({
                                        url: '../../sis_auditoria/control/AuditoriaNpn/listarAuditoriaNpn',
                                        id: 'id_pn',
                                        root: 'datos',
                                        totalProperty: 'total',
                                        fields: ['id_pn', 'nombre_pn','nombre_descrip'],
                                        remoteSort: true,
                                        baseParams: {dir:'ASC',sort:'id_aom',limit:'100',start:'0', id_aom: maestro.id_aom}
                                    }),
                                    tbar:[{
                                        text: 'Limpiar',
                                        handler:function(){
                                            isForm.getForm().findField('id_pn').reset();
                                        }
                                    }],
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
         isForm.getForm().items.items[2].on('select', function(combo, record, index){
               isForm.getForm().items.items[3].multiselects[0].store.baseParams = {dir: "ASC", sort: "id_aom", limit: "100", start: "0", id_norma: record.data.id_norma,item :maestro.id_aom};
               isForm.getForm().items.items[3].multiselects[1].store.baseParams = {dir: "ASC", sort: "id_aom", limit: "100", start: "0", id_aom: maestro.id_aom,id_norma: record.data.id_norma};
               isForm.getForm().items.items[3].multiselects[1].store.load();
               isForm.getForm().items.items[3].modificado = true;
               isForm.getForm().items.items[3].reset();
         },this);

      this.ventanaPuntoNorma = new Ext.Window({
         width: 700,
         height: 500,
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
                       Phx.CP.loadingShow();
                       Ext.Ajax.request({
                           url: '../../sis_auditoria/control/AuditoriaNpn/insertarItemAuditoriaNpn',
                           params: {
                               id_aom :maestro.id_aom,
                               id_norma:  submit.id_norma,
                               id_pn: submit.id_pn
                           },
                           isUpload: false,
                           success: function(a,b,c){
                               Phx.CP.loadingHide();
                               me.ventanaPuntoNorma.hide();
                               me.storePuntoNorma.load();

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
    formularioPregunta:function(){
      const maestro = this.sm.getSelected().data;
      const me = this;
        const isForm = new Ext.form.FormPanel({
          id: this.idContenedor + '_formulario_pregunta',
            items: [{
                        xtype: 'field',
                        fieldLabel: 'Código Auditoria',
                        name: 'nro_tramite_wf',
                        anchor: '100%',
                        value: maestro.nro_tramite_wf,
                        readOnly :true,
                        style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                          xtype: 'field',
                          fieldLabel: 'Nombre Auditoria',
                          name: 'nombre_aom1',
                          anchor: '100%',
                          value: maestro.nombre_aom1,
                          readOnly :true,
                          style: 'background-color: #F2F1F0; background-image: none;'
                    },
                    {
                               xtype: 'combo',
                               name: 'id_norma',
                               fieldLabel: 'Norma',
                               allowBlank: false,
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
                                name: 'id_pregunta',
                                fieldLabel: 'Pregunta',
                                imagePath: '../../../pxp/lib/ux/images/',
                                drawUpIcon:false,
                                drawDownIcon:false,
                                drawTopIcon:false,
                                drawBotIcon:false,
                                multiselects: [{
                                  width: 300,
                                  height: 250,
                                  store: new Ext.data.JsonStore({
                                      url: '../../sis_auditoria/control/Pregunta/listarPregunta',
                                      id: 'id_pregunta',
                                      root: 'datos',
                                      sortInfo: {
                                          field: 'nro_pregunta',
                                          direction: 'ASC'
                                      },
                                      totalProperty: 'total',
                                      fields: ['id_pregunta', 'nro_pregunta','descrip_pregunta'],
                                      remoteSort: true,
                                      baseParams: {dir:'ASC',sort:'id_pregunta',limit:'100',start:'0'}
                                  }),
                                    tbar:[{
                                        text: 'Todo',
                                        handler:function(){
                                            const toStore  = isForm.getForm().findField('id_pregunta').multiselects[0].store;
                                            const fromStore   = isForm.getForm().findField('id_pregunta').multiselects[1].store;
                                            for(var i = toStore.getCount()-1; i >= 0; i--)
                                            {
                                                const record = toStore.getAt(i);
                                                toStore.remove(record);
                                                fromStore.add(record);
                                            }
                                        }
                                    }],
                                    displayField: 'descrip_pregunta',
                                    valueField: 'id_pregunta',
                                },{
                                    width: 300,
                                    height: 250,
                                    store: new Ext.data.JsonStore({
                                        url: '../../sis_auditoria/control/AuditoriaNpnpg/listarAuditoriaNpnpg',
                                        id: 'id_pregunta',
                                        root: 'datos',
                                        totalProperty: 'total',
                                        fields: ['id_pregunta', 'descrip_pregunta'],
                                        remoteSort: true,
                                        baseParams: {dir:'ASC',sort:'id_aom',limit:'100',start:'0', id_aom: maestro.id_aom}
                                    }),
                                    tbar:[{
                                        text: 'Limpiar',
                                        handler:function(){
                                            isForm.getForm().findField('id_pregunta').reset();
                                        }
                                    }],
                                     displayField: 'descrip_pregunta',
                                     valueField: 'id_pregunta',
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
              // isForm.getForm().items.items[3].multiselects[0].store.baseParams = {dir: "ASC", sort: "id_aom", limit: "100", start: "0", id_norma: record.data.id_norma,item :maestro.id_aom};
              // isForm.getForm().items.items[3].multiselects[1].store.baseParams = {dir: "ASC", sort: "id_aom", limit: "100", start: "0", id_aom: maestro.id_aom,id_norma: record.data.id_norma};
              // isForm.getForm().items.items[3].multiselects[1].store.load();
               isForm.getForm().findField('id_pregunta').modificado = true;
               isForm.getForm().findField('id_pregunta').reset();
         },this);

      this.ventanaPregunta = new Ext.Window({
         width: 700,
         height: 500,
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
                 /* Phx.CP.loadingShow();
                Ext.Ajax.request({
                     url: '../../sis_auditoria/control/AuditoriaNpn/insertarItemAuditoriaNpn',
                     params: {
                         id_aom :maestro.id_aom,
                         id_norma:  submit.id_norma,
                         id_pn: submit.id_pn
                     },
                     isUpload: false,
                     success: function(a,b,c){
                         Phx.CP.loadingHide();
                         me.ventanaPregunta.hide();
                         me.storePuntoNorma.load();

                     },
                     argument: this.argumentSave,
                     failure: this.conexionFailure,
                     timeout: this.timeout,
                     scope: this
                 });*/
                 me.ventanaPregunta.hide();
             },
             scope: this
             },
             {
             text: 'Declinar',
             handler: function() {
                 this.ventanaPregunta.hide();
             },
             scope: this
         }]
      });
    },
    formularioCroronograma:function(data){
        const maestro = this.sm.getSelected().data;
        const me = this;
        let id_modificacion = null;
        if(data){
          id_modificacion = data.id_cronograma
        }
        const tienda = new Ext.data.JsonStore({
             url: '../../sis_auditoria/control/Cronograma/listarCronograma',
             id: 'id_cronograma',
             root: 'datos',
             totalProperty: 'total',
             fields: ['id_cronograma','id_aom','id_actividad',
                     'nueva_actividad','fecha_ini_activ','actividad',
                         'fecha_fin_activ','hora_ini_activ','hora_fin_activ','lista_funcionario','actividad'],
                         remoteSort: true,
             baseParams: {dir:'ASC',sort:'id_cronograma',limit:'100',start:'0'}
         });
          tienda.baseParams.id_aom = maestro.id_aom;
          tienda.load();
            const table = new Ext.grid.GridPanel({
                layout: 'fit',
                store: tienda,
                region: 'center',
                height: 180,
                title:'Actividades Programadas',
                anchor: '100%',
                split: true,
                border: true,
                plain: true,
                stripeRows: true,
                trackMouseOver: false,
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Actividad',
                        dataIndex: 'id_actividad',
                        width: 100,
                        renderer:function(value, p, record){return String.format('{0}', record.data['actividad']);},
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
                        width: 110,
                        renderer:function (value,p,record){
                            const fecha = value.split("-");
                            return  fecha[2]+'/'+fecha[1]+'/'+fecha[0];
                        }
                    },
                    {
                        header: 'Fecha Fin',
                        dataIndex: 'fecha_fin_activ',
                        align: 'center',
                        width: 110,
                        renderer:function (value,p,record){
                            const fecha = value.split("-");
                            return  fecha[2]+'/'+fecha[1]+'/'+fecha[0];
                        }
                    },
                    {
                        header: 'Hora Inicio',
                        dataIndex: 'hora_ini_activ',
                        align: 'center',
                        width: 110,
                    },
                    {
                        header: 'Hora Fin',
                        dataIndex: 'hora_fin_activ',
                        align: 'center',
                        width: 110,
                    }
                ],
                tbar: [
                    {
                        text: '<button class="btn"><i class="fa fa-trash fa-lg"></i>&nbsp;&nbsp;<b>Eliminar</b></button>',
                        scope:this,
                        width: '100',
                        handler: function(){
                            const  s =  table.getSelectionModel().getSelections();
                            // console.log(s[0].data)
                            Phx.CP.loadingShow();
                            Ext.Ajax.request({
                                url: '../../sis_auditoria/control/Cronograma/eliminarCronograma',
                                params: {
                                    id_cronograma : s[0].data.id_cronograma
                                },
                                isUpload: false,
                                success: function(a,b,c){
                                    Phx.CP.loadingHide();
                                    tienda.load();
                                },
                                argument: this.argumentSave,
                                failure: this.conexionFailure,
                                timeout: this.timeout,
                                scope: this
                            })
                        }
                    }
                ],
            });
            const isForm = new Ext.form.FormPanel({
                id: this.idContenedor + '_formulario_crorogrma',
                items: [
                    new Ext.form.FieldSet({
                            collapsible: false,
                            title:'Datos Generales',
                            border: true,
                            layout: 'form',
                                items: [
                                    new Ext.form.FieldSet({
                                    collapsible: false,
                                    border: false,
                                    layout: 'column',
                                    defaults: { width: 600},
                                        items: [
                                            new Ext.form.FieldSet({
                                            collapsible: false,
                                            border: false,
                                            layout: 'form',
                                            columnWidth: .50,
                                                items: [
                                                    {
                                                        xtype: 'datefield',
                                                        anchor: '85%',
                                                        name: 'fecha_ini_activ',
                                                        fieldLabel: '*Fecha Inicio',
                                                        allowBlank: false,
                                                        format: 'd/m/Y'
                                                    },
                                                    {
                                                        xtype: 'datefield',
                                                        anchor: '85%',
                                                        name: 'fecha_fin_activ',
                                                        fieldLabel: '*Fecha Fin',
                                                        allowBlank: false,
                                                        format: 'd/m/Y',
                                                    },
                                                ]
                                            }),
                                            new Ext.form.FieldSet({
                                            collapsible: false,
                                            border: false,
                                            layout: 'form',
                                            columnWidth: .50,
                                                items: [
                                                    {
                                                        xtype: 'timefield',
                                                        anchor: '85%',
                                                        name: 'hora_ini_activ',
                                                        fieldLabel: '*Hora Inicio',
                                                        allowBlank: false,
                                                        format: 'H:i',
                                                    },
                                                    {
                                                        xtype: 'timefield',
                                                        anchor: '85%',
                                                        name: 'hora_fin_activ',
                                                        fieldLabel: '*Hora Fin',
                                                        allowBlank: false,
                                                        format: 'H:i',
                                                    },
                                                ]
                                            })
                                        ]
                                    }),
                                    {
                                        xtype: 'combo',
                                        name: 'id_actividad',
                                        fieldLabel: '*Actividad',
                                        allowBlank: false,
                                        emptyText: 'Elija una opción...',
                                        store: new Ext.data.JsonStore({
                                            url: '../../sis_auditoria/control/Actividad/listarActividad',
                                            id: 'id_actividad',
                                            root: 'datos',
                                            sortInfo: {
                                                field: 'actividad',
                                                direction: 'ASC'
                                            },
                                            totalProperty: 'total',
                                            fields: ['id_actividad', 'actividad','codigo_actividad'],
                                            remoteSort: true,
                                            baseParams: {par_filtro: 'atv.actividad'}
                                        }),
                                        valueField: 'id_actividad',
                                        displayField: 'actividad',
                                        gdisplayField: 'actividad',
                                        hiddenName: 'id_actividad',
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
                                        title: 'Equipo Responsable',
                                        items:[{
                                            xtype: 'itemselector',
                                            name: 'itemselector',
                                            fieldLabel: 'Equipo',
                                            imagePath: '../../../pxp/lib/ux/images/',
                                            drawUpIcon:false,
                                            drawDownIcon:false,
                                            drawTopIcon:false,
                                            drawBotIcon:false,
                                            multiselects: [{
                                                width: 370,
                                                height: 180,
                                                store: new Ext.data.JsonStore({
                                                    url: '../../sis_auditoria/control/EquipoResponsable/listarEquipoResponsable',
                                                    id: 'id_funcionario',
                                                    root: 'datos',
                                                    sortInfo: {
                                                        field: 'desc_funcionario1',
                                                        direction: 'ASC'
                                                    },
                                                    totalProperty: 'total',
                                                    fields: ['id_funcionario', 'desc_funcionario1'],
                                                    remoteSort: true,
                                                    autoLoad: true,
                                                    baseParams: { dir:'ASC', sort:'id_aom', limit:'100', start:'0', id_aom: maestro.id_aom}
                                                }),
                                                tbar:[{
                                                    text: 'Todo',
                                                    handler:function(){
                                                        const toStore  = isForm.getForm().findField('itemselector').multiselects[0].store;
                                                        const fromStore   = isForm.getForm().findField('itemselector').multiselects[1].store;
                                                        for(var i = toStore.getCount()-1; i >= 0; i--)
                                                        {
                                                            const record = toStore.getAt(i);
                                                            toStore.remove(record);
                                                            fromStore.add(record);
                                                        }
                                                    }
                                                }],
                                                valueField: 'id_funcionario',
                                                displayField: 'desc_funcionario1',
                                            },
                                            {
                                                width: 370,
                                                height: 180,
                                                store: new Ext.data.JsonStore({
                                                    url: '../../sis_auditoria/control/CronogramaEquipoResponsable/listarCronogramaEquipoResponsable',
                                                    id: 'id_funcionario',
                                                    root: 'datos',
                                                    totalProperty: 'total',
                                                    fields: ['id_funcionario', 'desc_funcionario1'],
                                                    remoteSort: true,
                                                    baseParams: { dir:'ASC', sort:'id_funcionario', limit:'100', start:'0'}
                                                }),
                                                tbar:[{
                                                    text: 'Limpiar',
                                                    handler:function(){
                                                        isForm.getForm().findField('itemselector').reset();
                                                    }
                                                }],
                                                valueField: 'id_funcionario',
                                                displayField: 'desc_funcionario1',
                                            }]
                                        }],
                                        buttons: [{
                                            text: 'Asignar',
                                            handler: function() {
                                                if(isForm.getForm().isValid()){
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
                                                    Phx.CP.loadingShow();
                                                    Ext.Ajax.request({
                                                        url: '../../sis_auditoria/control/Cronograma/itemCronograma',
                                                        params: {
                                                            id_aom :maestro.id_aom,
                                                            id_cronograma: id_modificacion,
                                                            fecha_ini_activ: submit.fecha_ini_activ,
                                                            fecha_fin_activ: submit.fecha_fin_activ,
                                                            hora_ini_activ: submit.hora_ini_activ,
                                                            hora_fin_activ: submit.hora_fin_activ,
                                                            id_actividad: submit.id_actividad,
                                                            funcionarios: submit.itemselector
                                                        },
                                                        isUpload: false,
                                                        success: function(a,b,c){
                                                            Phx.CP.loadingHide();
                                                            if(id_modificacion){
                                                                me.ventanaCroronograma.hide();
                                                                me.storeCronograma.load();

                                                            }else {
                                                                isForm.getForm().reset();
                                                                tienda.load();
                                                            }

                                                        },
                                                        argument: this.argumentSave,
                                                        failure: this.conexionFailure,
                                                        timeout: this.timeout,
                                                        scope: this
                                                    });
                                                }
                                            }
                                        }]
                                    },
                                    table
                                ]})
                ],
                padding: this.paddingForm,
                bodyStyle: this.bodyStyleForm,
                border: this.borderForm,
                frame: this.frameForm,
                autoDestroy: true,
                autoScroll: true,
                region: 'center'
            });

            if(data) {
                isForm.getForm().findField('fecha_ini_activ').setValue(data.fecha_ini_activ);
                isForm.getForm().findField('fecha_fin_activ').setValue(data.fecha_fin_activ);
                isForm.getForm().findField('hora_ini_activ').setValue(new Date(data.fecha_ini_activ+' '+data.hora_ini_activ));
                isForm.getForm().findField('hora_fin_activ').setValue(new Date(data.fecha_fin_activ+' '+data.hora_fin_activ));

                setTimeout(() => {
                    isForm.getForm().findField('id_actividad').setValue(data.id_actividad);
                    isForm.getForm().findField('id_actividad').setRawValue(data.actividad);
                }, 1000);


                isForm.getForm().findField('itemselector').multiselects[0].store.baseParams = {
                                dir:'ASC',
                                sort:'id_aom',
                                limit:'100',
                                start:'0',
                                id_aom: maestro.id_aom,
                                item :data.id_cronograma
                            };
                isForm.getForm().findField('itemselector').multiselects[1].store.baseParams = {
                                dir:'ASC',
                                sort:'id_aom',
                                limit:'100',
                                start:'0',
                                id_cronograma: data.id_cronograma
                };
                isForm.getForm().findField('itemselector').multiselects[1].store.load();
            }
      const auditoria = maestro.nro_tramite_wf + ' '+maestro.nombre_aom1;
      this.ventanaCroronograma = new Ext.Window({
         width: 850,
         height: 680,
         modal: true,
         closeAction: 'hide',
         labelAlign: 'bottom',
         title: 'Cronograma de Actividades de la Auditoria '+ auditoria,
         bodyStyle: 'padding:5px',
          layout: 'border',
         items: [
            isForm,
         ],
         buttons: [{
             text: 'Cerrar',
             handler: function(){
               this.ventanaCroronograma.hide();
               this.storeCronograma.load();
             },
             scope: this
         }]
      });
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
    desactivarInputs:function () {
      this.Cmp.nombre_aom1.disable(true);
      this.Cmp.fecha_prog_inicio.disable(true);
      this.Cmp.fecha_prog_fin.disable(true);
      this.Cmp.id_uo.disable(true);
      this.Cmp.id_funcionario.disable(true);
    },
    preparaMenu:function(n){
        const data = this.sm.getSelected().data;
        const tb = this.tbar;
        Phx.vista.AuditoriaOportunidadMejora.superclass.preparaMenu.call(this,n);
        if(data['estado_wf'] === 'aprobado_responsable'){
            this.getBoton('sig_estado').disable();
        }
        if(data['estado_wf'] === 'planificacion'){
            this.getBoton('sig_estado').enable();
        }
        // this.getBoton('btnChequeoDocumentosWf').enable();
        this.getBoton('diagrama_gantt').enable();
        this.getBoton('ant_estado').enable();
        return tb
    },
    liberaMenu:function(){
        const tb = Phx.vista.AuditoriaOportunidadMejora.superclass.liberaMenu.call(this);
        if(tb){
              this.getBoton('sig_estado').disable();
              // this.getBoton('btnChequeoDocumentosWf').disable();
              this.getBoton('diagrama_gantt').disable();
              this.getBoton('ant_estado').disable();
        }
        return tb
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
            interfaz:'PlanificarAuditoria',
            contenedor: this.idContenedor
          };
          this.store.reload({ params: this.store.baseParams});
    },
    bnew:true,
    bdel:false,
    bedit:true,
    arrayDefaultColumHidden:['nombre_aom1','nombre_unidad','desc_funcionario_resp','nro_tramite','descrip_nc','lugar','desc_tipo_norma','desc_tipo_objeto'],
    rowExpander: new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<br>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Nombre Auditoria:&nbsp;&nbsp;</b> {nombre_aom1}</p>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Area:&nbsp;&nbsp;</b> {nombre_unidad}</p>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Responsable Auditoria:&nbsp;&nbsp;</b> {desc_funcionario2}</p>',
            '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Codigo:&nbsp;&nbsp;</b> {nro_tramite_wf}</p>',

        )
    }),
    tabsouth:[
      {
          url:'../../../sis_auditoria/vista/auditoria_proceso/AuditoriaProceso.php',
          title:'Procesos',
          height : '50%',
          cls:'AuditoriaProceso'
      },
      {
          url:'../../../sis_auditoria/vista/equipo_responsable/EquipoResponsable.php',
          title:'Responsables',
          height : '50%',
          cls:'EquipoResponsable',
      },
      {
          url:'../../../sis_auditoria/vista/auditoria_npn/AuditoriaNpn.php',
          title:'Puntos de Norma',
          height : '50%',
          cls:'AuditoriaNpn',
      },
      {
          url:'../../../sis_auditoria/vista/cronograma/Cronograma.php',
          title:'Cronograma',
          height : '50%',
          cls:'Cronograma',
      }
]};
</script>
