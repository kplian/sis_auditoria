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
    let siglass = '';
    let pnNorma = '';
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
    storeRiesgo:{},
    constructor: function(config) {
        this.Atributos[this.getIndAtributo('id_destinatario')].grid=false;
        this.Atributos[this.getIndAtributo('recomendacion')].grid=false;
        this.Atributos[this.getIndAtributo('id_tipo_om')].grid=false;
        Phx.vista.PlanificarAuditoria.superclass.constructor.call(this,config);
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
                  field: 'nombre_pn',
                  direction: 'ASC'
              },
              totalProperty: 'total',
              fields: ['id_anpnpg','nombre_pn','estado_reg','usr_reg','fecha_reg','descrip_pregunta'
              ],remoteSort: true,
              baseParams: {dir:'ASC',sort:'id_aom',limit:'100',start:'0'}
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
        this.storeRiesgo = new Ext.data.JsonStore({
            url: '../../sis_auditoria/control/AomRiesgoOportunidad/listarAomRiesgoOportunidad',
            id: 'id_aom_ro',
            root: 'datos',
            totalProperty: 'total',
            fields: ['id_aom_ro','id_impacto','id_probabilidad','id_tipo_ro','id_ro',
                'otro_nombre_ro','id_aom','criticidad','nombre_ro','desc_tipo_ro',
                'nombre_prob','nombre_imp','estado_reg','usr_reg','fecha_reg'],remoteSort: true,
            baseParams: {dir:'ASC',sort:'id_aom_ro',limit:'100',start:'0'}
          });

          const me = this;
          const procesos = new Ext.grid.GridPanel({
            store:  this.storeProceso,
            layout: 'fit',
            region:'center',
            anchor: '100%',
            split: true,
            border: false,
            plain: true,
            stripeRows: true,
            trackMouseOver: false,
            tbar: [
                {
                    xtype: 'box',
                    autoEl: {
                        tag: 'a',
                        html: 'Asignar Procesos'
                    },
                    style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                    listeners: {
                        render: function(component) {
                            component.getEl().on('click', function(e) {
                                me.formularioProceso();
                                me.procesoVentana.show();
                            });
                        }
                    }
                }
            ],
            columns: [
                new Ext.grid.RowNumberer(),
                {
                    header: 'Proceso',
                    dataIndex: 'id_proceso',
                    width: 300,
                    sortable: false,
                    renderer:function(value, p, record){return String.format('<a style="cursor:pointer;">{0}</a>', record.data['proceso']);},
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
          });
          const responsable = new Ext.grid.GridPanel({
            store:  this.storeEquipo,
            layout: 'fit',
            region:'center',
            anchor: '100%',
            split: true,
            border: false,
            plain: true,
            stripeRows: true,
            trackMouseOver: false,
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
                                me.formularioEquipo();
                                me.ventanaEquipo.show();
                            });
                        }
                    }
                }],
            columns: [
                new Ext.grid.RowNumberer(),
                {
                    header: 'Funcionario',
                    dataIndex: 'id_funcionario',
                    width: 280,
                    sortable: false,
                    renderer:function(value, p, record){return String.format('<a style="cursor:pointer;">{0}</a>', record.data['desc_funcionario1'])},
                },
                {
                    header: 'Tipo Auditor',
                    dataIndex: 'id_parametro',
                    width: 200,
                    sortable: false,
                    renderer:function(value, p, record){return String.format('{0}', record.data['valor_parametro'])},
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
          const puntoNorma =  new Ext.grid.GridPanel({
            store:  this.storePuntoNorma,
            layout: 'fit',
            region:'center',
            anchor: '100%',
            split: true,
            border: false,
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
                    renderer:function(value, p, record){
                        if( siglass !== record.data['sigla_norma'] ){
                            siglass =  record.data['sigla_norma'];
                            return  String.format('<b>{0}</b>', siglass);
                        }

                    }
                },
                {
                    header: 'Codigo',
                    dataIndex: 'codigo_pn',
                    width: 100,
                    sortable: false,
                    renderer:function(value, p, record){
                        return String.format('<a style="cursor:pointer;" >{0}</a>', record.data['codigo_pn'])
                    },

                },
                {
                    header: 'Punto de Norma',
                    dataIndex: 'id_pn',
                    width: 350,
                    sortable: false,
                    renderer:function(value, p, record){
                        return String.format('<a style="cursor:pointer;">{0}</a>', record.data['nombre_pn'])
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
            tbar: [
                {
                    xtype: 'box',
                    autoEl: {
                        tag: 'a',
                        html: 'Asignar Puntos de Norma'
                    },
                    style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                    listeners: {
                        render: function(component) {
                            component.getEl().on('click', function(e) {
                                me.formularioPuntoNorma();
                                me.ventanaPuntoNorma.show();
                            });
                        }
                    }
                }]
           });
          const pregunta = new Ext.grid.GridPanel({
            store:  this.storePregunta,
            layout: 'fit',
            region:'center',
            anchor: '100%',
            split: true,
            border: false,
            plain: true,
            stripeRows: true,
            trackMouseOver: false,
            columns: [
                new Ext.grid.RowNumberer(),
                {
                    header: 'Punto de Norma',
                    dataIndex: 'id_pn',
                    width: 300,
                    sortable: false,
                    // renderer:function(value, p, record){return String.format('<b>{0}</b>', record.data['nombre_pn'])},
                    renderer:function(value, p, record){
                        if( pnNorma !== record.data['nombre_pn'] ){
                            pnNorma =  record.data['nombre_pn'];
                            return  String.format('<b>{0}</b>', pnNorma);
                        }

                    }
                },
                {
                    header: 'Pregunta',
                    dataIndex: 'id_pregunta',
                    width: 300,
                    sortable: false,
                    renderer:function(value, p, record){return String.format('<a>{0}</a>', record.data['descrip_pregunta'])},
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
            tbar: [
                {
                    xtype: 'box',
                    autoEl: {
                        tag: 'a',
                        html: 'Asignar Preguntas'
                    },
                    style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                    listeners: {
                        render: function(component) {
                            component.getEl().on('click', function(e) {
                                me.formularioPregunta();
                                me.ventanaPregunta.show();
                            });
                        }
                    }
                }]
          });
          const crorograma = new Ext.grid.GridPanel({
            store:  this.storeCronograma,
            trackMouseOver: false,
            layout: 'fit',
            region:'center',
            anchor: '100%',
            split: true,
            border: false,
            plain: true,
            stripeRows: true,
            tbar: [
                {
                    xtype: 'box',
                    autoEl: {
                        tag: 'a',
                        html: 'Nueva Actividad'
                    },
                    style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                    listeners: {
                        render: function(component) {
                            component.getEl().on('click', function(e) {
                                me.formularioCroronograma(null);
                                me.ventanaCroronograma.show();
                            });
                        }
                    }
                }
            ],
            columns: [
                new Ext.grid.RowNumberer(),
                {
                    header: 'Actividad',
                    dataIndex: 'id_actividad',
                    width: 140,
                    renderer:function(value, p, record){
                        return String.format('<a class="gridmultiline" style="cursor:pointer;">{0}</a>', record.data['actividad'])
                    },
                },
                {
                    header: 'Fecha',
                    dataIndex: 'fecha_ini_activ',
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
                    width: 80,
                },
                {
                    header: 'Hora Fin',
                    dataIndex: 'hora_fin_activ',
                    align: 'center',
                    width: 80,
                },
                {
                    header: 'Funcionarios',
                    dataIndex: 'lista_funcionario',
                    width: 220,
                    renderer : function(value, p, record) {
                        return String.format('<div class="gridmultiline">{0}</div>', record.data['lista_funcionario']);
                    }
                },
                {
                    header: 'Eliminar',
                    dataIndex: 'eliminar',
                    width: 50,
                    renderer : function(value, p, record) {
                        return String.format('<a style="display: flex; justify-content: center; align-items: center"><i class="fa fa-trash fa-lg" style="cursor:pointer;"></i></a>', record.data['lista_funcionario']);
                    }
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
          const riesgo = new Ext.grid.GridPanel({
            store:  this.storeRiesgo,
            trackMouseOver: false,
            layout: 'fit',
            region:'center',
            anchor: '100%',
            split: true,
            border: false,
            plain: true,
            stripeRows: true,
            tbar: [
                {
                    xtype: 'box',
                    autoEl: {
                        tag: 'a',
                        html: 'Nueva Riesgo Oportunidad'
                    },
                    style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                    listeners: {
                        render: function(component) {
                            component.getEl().on('click', function(e) {
                                me.formularioRiego(null);
                                me.ventanaRiesgo.show();
                            });
                        }
                    }
                }
            ],
            columns: [
                new Ext.grid.RowNumberer(),
                {
                    header: 'Tipo RO',
                    dataIndex: 'id_tipo_ro',
                    width: 200,
                    renderer:function(value, p, record){
                        return String.format('<a class="gridmultiline" style="cursor:pointer;">{0}</a>', record.data['desc_tipo_ro'])
                    },
                },
                {
                    header: 'Riesgo Oportunidad',
                    dataIndex: 'id_ro',
                    align: 'center',
                    width: 100,
                    renderer:function(value, p, record){
                        return String.format('<a class="gridmultiline" style="cursor:pointer;">{0}</a>', record.data['nombre_ro'])
                    },
                },
                {
                    header: 'Probabilidad',
                    dataIndex: 'id_probabilidad',
                    align: 'center',
                    width: 80,
                    renderer:function(value, p, record){
                        return String.format('<a class="gridmultiline" style="cursor:pointer;">{0}</a>', record.data['nombre_prob'])
                    },
                },
                {
                    header: 'Impacto',
                    dataIndex: 'id_impacto',
                    align: 'center',
                    width: 80,
                    renderer : function(value, p, record) {
                        return String.format('{0}', record.data['nombre_imp']);
                    }
                },
                {
                    header: 'Criticidad',
                    dataIndex: 'criticidad',
                    width: 50
                },
                {
                    header: 'Eliminar',
                    dataIndex: 'eliminar_riesgo',
                    width: 50,
                    renderer : function(value, p, record) {
                        return String.format('<a style="display: flex; justify-content: center; align-items: center"><i class="fa fa-trash fa-lg" style="cursor:pointer;"></i></a>', record.data['lista_funcionario']);
                    }
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

          procesos.addListener('cellclick', this.oncellclick,this);
          responsable.addListener('cellclick', this.oncellclick,this);
          puntoNorma.addListener('cellclick', this.oncellclick,this);
          pregunta.addListener('cellclick', this.oncellclick,this);
          crorograma.addListener('cellclick', this.oncellclick,this);
          riesgo.addListener('cellclick', this.oncellclick,this);

          this.form = new Ext.form.FormPanel({
             id: this.idContenedor + '_formulario_aud',
             items: [{ region: 'center',
                      layout: 'column',
                      border: false,
                      items: [{
                             xtype: 'tabpanel',
                             plain: true,
                             activeTab: 0,
                             height: 500,
                             width: 700,
                             deferredRender: false,
                             autoScroll: false,
                             items: [
                                 {
                                     title: 'Datos Principales',
                                     layout: 'fit',
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
                                                     width: 500,
                                                     autoScroll: true,
                                                     // defaults: {width: 550},
                                                     items: [
                                                         new Ext.form.FieldSet({
                                                             collapsible: false,
                                                             layout: "column",
                                                             border: true,

                                                             defaults: {
                                                                 flex: 1
                                                             },
                                                             items: [
                                                                 new Ext.form.Label({
                                                                     text: 'Código :',
                                                                     style: 'margin: 4px; font-size: 12px'
                                                                 }),
                                                                 {
                                                                     xtype: 'field',
                                                                     fieldLabel: 'Código',
                                                                     name: 'nro_tramite',
                                                                     anchor: '100%',
                                                                     readOnly: true,
                                                                     id: this.idContenedor + '_nro_tramite',
                                                                     style: 'background-image: none; border: 0;',

                                                                 },
                                                                 new Ext.form.Label({
                                                                     text: 'Estado :',
                                                                     style: 'margin: 4px; font-size: 12px'
                                                                 }),
                                                                 {
                                                                     xtype: 'field',
                                                                     fieldLabel: 'Estado',
                                                                     name: 'nombre_estado',
                                                                     anchor: '100%',
                                                                     readOnly: true,
                                                                     id: this.idContenedor + '_nombre_estado',
                                                                     style: 'background-image: none; border: 0; color: #0C07F1; font-weight: bold;',
                                                                 }
                                                             ]
                                                            }),
                                                             {
                                                                 xtype: 'field',
                                                                 fieldLabel: 'Area',
                                                                 name: 'nombre_unidad',
                                                                 anchor: '100%',
                                                                 readOnly: true,
                                                                 id: this.idContenedor + '_nombre_unidad',
                                                                 style: 'background-image: none; border: 0;',
                                                             },
                                                             {
                                                                 xtype: 'field',
                                                                 fieldLabel: 'Nombre',
                                                                 name: 'nombre_aom1',
                                                                 anchor: '100%',
                                                                 readOnly: true,
                                                                 id: this.idContenedor + '_nombre_aom1',
                                                                 style: 'background-image: none; border: 0;',

                                                             }
                                                         ]
                                                 }),
                                                 new Ext.form.FieldSet({
                                                     collapsible: false,
                                                     border: true,
                                                     layout: 'form',
                                                     width: 500,
                                                     // defaults: {width: 550},
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
                                                             readOnly: true,
                                                             anchor: '100%',
                                                             id: this.idContenedor+'_fecha_prev_inicio',
                                                             style: 'background-image: none; border: 0;'
                                                         },
                                                         {
                                                             xtype: 'datefield',
                                                             fieldLabel: 'Fin Prev',
                                                             name: 'fecha_prev_fin',
                                                             readOnly: true,
                                                             anchor: '100%',
                                                             id: this.idContenedor+'_fecha_prev_fin',
                                                             style: 'background-image: none; border: 0;'
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
                                     items: [
                                         procesos
                                     ]
                                 },
                                 {
                                     title: 'Responsables',
                                     layout: 'fit',
                                     region:'center',
                                     items: [
                                         responsable
                                     ]
                                 },
                                 {
                                     title: 'Punto de Norma',
                                     layout: 'fit',
                                     region:'center',
                                     items: [
                                         puntoNorma
                                     ]
                                 },
                                 {
                                     title: 'Lista de Verificación',
                                     layout: 'fit',
                                     region:'center',
                                     items: [
                                         pregunta
                                     ]
                                 },
                                 {
                                     title: 'Cronograma',
                                     layout: 'fit',
                                     region:'center',
                                     items: [
                                         crorograma
                                     ]
                                 },
                                 {
                                     title: 'Riesgo Oportunidad',
                                     layout: 'fit',
                                     region:'center',
                                     items: [
                                         riesgo
                                     ]
                                 }
                           ]
                         }]
                     }],
             autoDestroy: true,
             autoScroll: true,
             region: 'center'
        });
          this.formularioVentana = new Ext.Window({
           width: 730,
           height: 590,
           modal: true,
           autoScroll: true,
           closeAction: 'hide',
           labelAlign: 'top',
           title: 'AUDITORIA PLANIFICADA',
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
                    if(obj.name === 'id_tnorma' || obj.name === 'id_tobjeto'){
                        if(obj.selectedIndex!==-1){
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

        this.storePregunta.baseParams.id_aom = record.id_aom;
        this.storePregunta.load();

        this.storeCronograma.baseParams.id_aom = record.id_aom;
        this.storeCronograma.load();

        this.storeRiesgo.baseParams.id_aom = record.id_aom;
        this.storeRiesgo.load();
    },
    formularioProceso:function(){
        const maestro = this.sm.getSelected().data;
        const isForm = new Ext.form.FormPanel({
            items: [
                new Ext.form.FieldSet({
                    collapsible: false,
                    border: true,
                    layout: 'form',
                    autoScroll: true,
                    items: [
                    {
                        xtype: 'field',
                        fieldLabel: 'Código Auditoria',
                        name: 'nro_tramite',
                        anchor: '100%',
                        value: maestro.nro_tramite,
                        readOnly :true,
                        style: 'background-image: none; border: 0; font-weight: bold;',
                    },
                    {
                          xtype: 'field',
                          fieldLabel: 'Nombre Auditoria',
                          name: 'nombre_aom1',
                          anchor: '100%',
                          value: maestro.nombre_aom1,
                          readOnly :true,
                          style: 'background-image: none; border: 0; font-weight: bold;',
                    },
                        ]
                }),
                    {
                            anchor: '100%',
                            bodyStyle: 'padding:10px;',
                            title: 'PROCESOS ASIGNADOS A ESTA AUDITORIA',
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
                                        totalProperty: 'total',
                                        fields: ['id_proceso', 'proceso'],
                                        remoteSort: true,
                                        autoLoad: true,
                                        baseParams: { dir:'ASC',
                                                      sort:'id_proceso',
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
                                                      sort:'id_proceso',
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
         height: 480,
         modal: true,
         autoScroll:true,
         closeAction: 'hide',
         labelAlign: 'bottom',
         title: 'SELECCIÓN DE PROCESOS AUDITABLES',
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
                               Phx.CP.loadingHide();
                               this.storeProceso.load();
                               isForm.getForm().findField('id_proceso').multiselects[0].store.load();
                               isForm.getForm().findField('id_proceso').multiselects[1].store.load();
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
             text: 'Cerrar',
             handler: function() {
                 this.procesoVentana.hide();
                 this.storeProceso.load();
             },
             scope: this
         }]
      });
    },
    formularioEquipo:function(){
        Phx.CP.loadingShow();
        const maestro = this.sm.getSelected().data;
        const me = this;
        const isForm = new Ext.form.FormPanel({
            items: [
                new Ext.form.FieldSet({
                    collapsible: false,
                    border: true,
                    layout: 'form',
                    autoScroll: true,
                    items: [
                {
                        xtype: 'field',
                        fieldLabel: 'Código Auditoria',
                        name: 'nro_tramite',
                        anchor: '100%',
                        value: maestro.nro_tramite,
                        readOnly :true,
                        style: 'background-image: none; border: 0;font-weight: bold;',
                    },
                    {
                          xtype: 'field',
                          fieldLabel: 'Nombre Auditoria',
                          name: 'nombre_aom1',
                          anchor: '100%',
                          value: maestro.nombre_aom1,
                          readOnly :true,
                          style: 'background-image: none; border: 0; font-weight: bold;',
                    },
                    {
                               xtype: 'combo',
                               fieldLabel: 'Auditor Responsable',
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
                                       baseParams: {par_filtro: 'fun.desc_funcionario1', codigo:'RESP', id_uo: maestro.id_uo}
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
                        ]}),
                    {
                            anchor: '100%',
                            bodyStyle: 'padding:10px;',
                            title: 'EQUIPO DE AUDITORES',
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
                                        /*sortInfo: {
                                          field: 'desc_funcionario1',
                                          direction: 'DESC'
                                        },*/
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
                            xtype: 'radiogroup',
                            name : 'tecnico',
                            fieldLabel : 'Experto Técnico',
                            itemCls: 'x-check-group-alt',
                            items: [
                                {boxLabel: 'Interno', name: 'tecnico', inputValue: 'interno', checked: true},
                                {boxLabel: 'Externo', name: 'tecnico', inputValue: 'externo'}
                            ]
                        },
                    {
                           xtype: 'combo',
                           name: 'id_interno',
                           fieldLabel: 'Interno',
                           allowBlank: true,
                           emptyText: 'Elija una opción...',
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
                                   baseParams: {par_filtro: 'fc.desc_funcionario1'}
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
                           disabled : false
                    },
                    {
                            xtype: 'field',
                            fieldLabel: 'Externo',
                            name: 'externo',
                            anchor: '100%',
                            disabled : true
                    },
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
                    id_aom:maestro.id_aom
                   },
          success:function(resp){
              const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
              const  record = reg.datos;
              for (const value  of record) {
                  if (value.codigo_parametro === 'RESP'){
                     isForm.getForm().items.items[2].setValue(value.id_funcionario);
                     isForm.getForm().items.items[2].setRawValue(value.desc_funcionario1);
                  }
                  if (value.codigo_parametro === 'ETI'){
                      isForm.getForm().items.items[5].setValue(value.id_funcionario);
                      isForm.getForm().items.items[5].setRawValue(value.desc_funcionario1);
                  }
                  if (value.codigo_parametro === 'EXT'){
                      isForm.getForm().items.items[4].items.items[1].setValue(true);
                      setTimeout(() => {
                          isForm.getForm().items.items[6].setValue(value.exp_tec_externo);
                      }, 1000)
                  }
              }
              Phx.CP.loadingHide();
          },
          failure: this.conexionFailure,
          timeout:this.timeout,
          scope:this
        });
        isForm.getForm().findField('tecnico').on('change', function(cmp, check){
              if(check.getRawValue() === 'interno'){
                  isForm.getForm().items.items[5].reset();
                  isForm.getForm().findField('externo').reset();
                  isForm.getForm().items.items[5].enable(true);
                  isForm.getForm().findField('externo').disable(true);
              }else{
                  isForm.getForm().items.items[5].reset();
                  isForm.getForm().findField('externo').reset();
                  isForm.getForm().items.items[5].disable(true);
                  isForm.getForm().findField('externo').enable(true);
              }
        },this);


      this.ventanaEquipo = new Ext.Window({
         width: 700,
         height: 580,
         modal: true,
         closeAction: 'hide',
         autoScroll:true,
         labelAlign: 'bottom',
         title: 'ASIGNACIÓN DE EQUIPO DE AUDITORES',
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
                               id_responsable: submit.id_responsable,
                               externo: submit.externo
                           },
                           isUpload: false,
                           success: function(a,b,c){
                               Phx.CP.loadingHide();
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
             text: 'Cerrar',
             handler: function() {
                 this.ventanaEquipo.hide();
                 this.storeEquipo.load();
             },
             scope: this
         }]
      });
    },
    formularioPuntoNorma:function(record){
      const maestro = this.sm.getSelected().data;
      siglass = '';
      const me = this;
        const isForm = new Ext.form.FormPanel({
          id: this.idContenedor + '_formulario_punto_norm',
            items: [
                new Ext.form.FieldSet({
                    collapsible: false,
                    border: true,
                    layout: 'form',
                    autoScroll: true,
                    items: [
                    {
                        xtype: 'field',
                        fieldLabel: 'Código Auditoria',
                        name: 'nro_tramite',
                        anchor: '100%',
                        value: maestro.nro_tramite,
                        readOnly :true,
                        style: 'background-image: none; border: 0;font-weight: bold;',
                    },
                    {
                          xtype: 'field',
                          fieldLabel: 'Nombre Auditoria',
                          name: 'nombre_aom1',
                          anchor: '100%',
                          value: maestro.nombre_aom1,
                          readOnly :true,
                          style: 'background-image: none; border: 0;font-weight: bold;',
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
                    ]
                }),
                      {
                          anchor: '100%',
                          bodyStyle: 'padding:10px;',
                          title: 'PUNTOS DE NORMA ASOCIADOS A ESTA AUDITORIA',
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
                                        baseParams: {dir:'ASC',sort:'id_pn',limit:'100',start:'0', id_aom: maestro.id_aom}
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
        if(record){
            Phx.CP.loadingShow();

            setTimeout(() => {
                isForm.getForm().items.items[2].setValue(record.json.id_norma);
                isForm.getForm().items.items[2].setRawValue(record.json.sigla_norma);
                isForm.getForm().items.items[3].multiselects[0].store.baseParams = {
                    dir: "ASC",
                    sort: "id_pn",
                    limit: "100",
                    start: "0",
                    id_norma: record.json.id_norma,
                    item :maestro.id_aom
                };
                isForm.getForm().items.items[3].multiselects[0].store.load();
                isForm.getForm().items.items[3].multiselects[1].store.baseParams = {
                    dir: "ASC",
                    sort: "id_pn",
                    limit: "100",
                    start: "0",
                    id_aom: maestro.id_aom,
                    id_norma: record.json.id_norma
                };
                isForm.getForm().items.items[3].multiselects[1].store.load();
                Phx.CP.loadingHide();

            },1000)
        }
         isForm.getForm().items.items[2].on('select', function(combo, record, index){
               isForm.getForm().items.items[3].multiselects[0].store.baseParams = {dir: "ASC", sort: "id_pn", limit: "100", start: "0", id_norma: record.data.id_norma,item :maestro.id_aom};
               isForm.getForm().items.items[3].multiselects[1].store.baseParams = {dir: "ASC", sort: "id_pn", limit: "100", start: "0", id_aom: maestro.id_aom,id_norma: record.data.id_norma};
               isForm.getForm().items.items[3].multiselects[0].store.load();
               isForm.getForm().items.items[3].multiselects[1].store.load();
               isForm.getForm().items.items[3].modificado = true;
               isForm.getForm().items.items[3].reset();
         },this);



      this.ventanaPuntoNorma = new Ext.Window({
         width: 700,
         height: 500,
         modal: true,
         autoScroll:true,
         closeAction: 'hide',
         labelAlign: 'bottom',
         title: 'SELECCIÓN DE PUNTOS DE NORMA',
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
                              // me.ventanaPuntoNorma.hide();
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
                 //this.storePuntoNorma.load();
             },
             scope: this
         }]
      });
    },
    formularioPregunta:function(record){
      const maestro = this.sm.getSelected().data;
        pnNorma = '';
      const me = this;
        this.isFormp = new Ext.form.FormPanel({
          id: this.idContenedor + '_formulario_pregunta',
            items: [
                new Ext.form.FieldSet({
                    collapsible: false,
                    border: true,
                    layout: 'form',
                    autoScroll: true,
                    items: [
                    {
                        xtype: 'field',
                        fieldLabel: 'Código Auditoria',
                        name: 'nro_tramite',
                        anchor: '100%',
                        value: maestro.nro_tramite,
                        readOnly :true,
                        style: 'background-image: none; border: 0;font-weight: bold;',
                    },
                    {
                          xtype: 'field',
                          fieldLabel: 'Nombre Auditoria',
                          name: 'nombre_aom1',
                          anchor: '100%',
                          value: maestro.nombre_aom1,
                          readOnly :true,
                          style: 'background-image: none; border: 0;font-weight: bold;',
                    },
                        new Ext.form.FieldSet({
                            collapsible: false,
                            layout: "column",
                            border: true,
                            defaults: {
                                flex: 1
                            },
                            items: [
                                new Ext.form.Label({
                                    text: 'Punto Norma :',
                                    style: 'margin: 5px; font-size: 12px;'
                                }),
                                {
                                   xtype: 'combo',
                                   name: 'id_pn',
                                   fieldLabel: 'Punto Norma',
                                   allowBlank: false,
                                   emptyText: 'Elija una opción...',
                                    store: new Ext.data.JsonStore({
                                        url: '../../sis_auditoria/control/PuntoNorma/listarPuntoNorma',
                                        id: 'id_pn',
                                        root: 'datos',
                                        sortInfo: {
                                            field: 'sigla_norma',
                                            direction: 'ASC'
                                        },
                                        totalProperty: 'total',
                                        fields: ['id_pn', 'nombre_pn','sigla_norma','codigo_pn'],
                                        remoteSort: true,
                                        baseParams: {par_filtro: 'ptonor.nombre_pn#ptonor.codigo_pn',dir:'ASC',sort:'id_pn',limit:'100',start:'0'}

                                    }),
                                    displayField: 'nombre_pn',
                                    valueField: 'id_pn',
                                    tpl:'<tpl for="."><div class="x-combo-list-item"><p>{sigla_norma} - {codigo_pn} - {nombre_pn}</p></div></tpl>',
                                    hiddenName: 'id_pn',
                                    forceSelection: true,
                                    typeAhead: false,
                                    mode: 'remote',
                                    width: 400,
                                    triggerAction: 'all',
                                    lazyRender: true,
                                    pageSize: 200,
                                    minChars: 2
                                },
                                {
                                    xtype: 'box',
                                    autoEl: {
                                        tag: 'button',
                                        html: 'Sugerir Pregunta'
                                },
                                 style: 'cursor:pointer; margin-left: 8px',
                                listeners: {
                                    render: function(component) {
                                        component.getEl().on('click', function(e) {
                                            me.asignarPregunta({
                                                id : me.isFormp.getForm().findField('id_pn').getValue(),
                                                name : me.isFormp.getForm().findField('id_pn').getRawValue()
                                            });
                                            me.preguntaPnVentana.show();
                                        });
                                    }
                                }
                        }
                        ]})
                     ]
                     }),
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
                                      totalProperty: 'total',
                                      fields: ['id_pregunta', 'nro_pregunta','descrip_pregunta'],
                                      remoteSort: true,
                                      baseParams: {dir:'ASC',sort:'id_pregunta',limit:'100',start:'0'}
                                  }),
                                    tbar:[{
                                        text: 'Todo',
                                        handler:function(){
                                            const toStore  = me.isFormp.getForm().findField('id_pregunta').multiselects[0].store;
                                            const fromStore   = me.isFormp.getForm().findField('id_pregunta').multiselects[1].store;
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
                                    },
                                    {
                                    width: 300,
                                    height: 250,
                                    store: new Ext.data.JsonStore({
                                        url: '../../sis_auditoria/control/AuditoriaNpnpg/listarAuditoriaNpnpg',
                                        id: 'id_pregunta',
                                        root: 'datos',
                                        totalProperty: 'total',
                                        fields: ['id_pregunta', 'descrip_pregunta'],
                                        remoteSort: true,
                                        baseParams: {dir:'ASC',sort:'id_pregunta',limit:'100',start:'0'}
                                    }),
                                    tbar:[{
                                        text: 'Limpiar',
                                        handler:function(){
                                            me.isFormp.getForm().findField('id_pregunta').reset();
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
        if(record){
            Phx.CP.loadingShow();
            setTimeout(() => {
                this.isFormp.getForm().items.items[2].setValue(record.json.id_pn);
                this.isFormp.getForm().items.items[2].setRawValue(record.json.nombre_pn);

                this.isFormp.getForm().items.items[3].multiselects[0].store.baseParams = {
                    dir: "ASC",
                    sort: "id_pregunta",
                    limit: "100",
                    start: "0",
                    id_pn: record.json.id_pn,
                    item :maestro.id_aom
                };
                this.isFormp.getForm().items.items[3].multiselects[0].store.load();
                this.isFormp.getForm().items.items[3].multiselects[1].store.baseParams = {
                    dir: "ASC",
                    sort: "id_pregunta",
                    limit: "100",
                    start: "0",
                    id_pn: record.json.id_pn,
                    id_aom: maestro.id_aom
                };
                this.isFormp.getForm().items.items[3].multiselects[1].store.load();
                this.isFormp.getForm().findField('id_pregunta').modificado = true;
                Phx.CP.loadingHide();
            },2000)
        }
        this.isFormp.getForm().findField('id_pn').on('select', function(combo, record){
            this.isFormp.getForm().items.items[3].multiselects[0].store.baseParams = {
                    dir: "ASC",
                    sort: "id_pregunta",
                    limit: "100",
                    start: "0",
                    id_pn: record.data.id_pn,
                    item :maestro.id_aom
                };
            this.isFormp.getForm().items.items[3].multiselects[0].store.load();
             // console.log(record.data.id_pn);
            this.isFormp.getForm().items.items[3].multiselects[1].store.baseParams = {
                    dir: "ASC",
                    sort: "id_pregunta",
                    limit: "100",
                    start: "0",
                    id_pn: record.data.id_pn,
                    id_aom: maestro.id_aom
                };
            this.isFormp.getForm().items.items[3].multiselects[1].store.load();

            this.isFormp.getForm().findField('id_pregunta').modificado = true;
            this.isFormp.getForm().findField('id_pregunta').reset();

         },this);

      this.ventanaPregunta = new Ext.Window({
         width: 700,
         height: 500,
         modal: true,
         closeAction: 'hide',
         labelAlign: 'bottom',
         title: 'LISTA DE VERIFICACION DE LA AUDITORIA',
         bodyStyle: 'padding:5px',
         layout: 'form',
         items: [
             this.isFormp
         ],
         buttons: [{
             text: 'Guardar',
             handler: function(){
                       const submit={};
                       Ext.each(this.isFormp.getForm().items.keys, function(element, index){
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
                     url: '../../sis_auditoria/control/AuditoriaNpnpg/insertarAuditoriaNpnpg',
                     params: {

                         id_pregunta: submit.id_pregunta,
                         id_anpn : submit.id_pn,
                         id_aom :maestro.id_aom
                     },
                     isUpload: false,
                     success: function(a,b,c){
                         Phx.CP.loadingHide();
                         me.storePregunta.load();
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
          id_modificacion = data.json.id_cronograma
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
                        width: 150,
                        renderer:function(value, p, record){return String.format('{0}', record.data['actividad']);},
                    },
                    {
                        header: 'Fecha Inicio',
                        dataIndex: 'fecha_ini_activ',
                        align: 'center',
                        width: 80,
                        renderer:function (value,p,record){
                            const fecha = value.split("-");
                            return  fecha[2]+'/'+fecha[1]+'/'+fecha[0];
                        }
                    },
                    {
                        header: 'Hora Inicio',
                        dataIndex: 'hora_ini_activ',
                        align: 'center',
                        width: 80,
                    },
                    {
                        header: 'Hora Fin',
                        dataIndex: 'hora_fin_activ',
                        align: 'center',
                        width: 80,
                    },
                    {
                        header: 'Funcionarios',
                        dataIndex: 'lista_funcionario',
                        width: 210,
                        renderer : function(value, p, record) {
                            return String.format('<div class="gridmultiline">{0}</div>', record.data['lista_funcionario']);
                        }
                    }
                ],
                tbar: [

                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'a',
                            html: 'Eliminar Actividad'
                        },
                        style: 'cursor:pointer; font-size: 13px; margin: 10px;',
                        listeners: {
                            render: function(component) {
                                component.getEl().on('click', function(e) {
                                    const  s =  table.getSelectionModel().getSelections();
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
                                });
                            }
                        }
                    }
                ],
            });
          const desde = this.formatoFecha(maestro.fecha_prev_inicio);
          const hasta = this.formatoFecha(maestro.fecha_prev_fin);

        const isForm = new Ext.form.FormPanel({
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
                                                        fieldLabel: '*Fecha',
                                                        allowBlank: false,
                                                        format: 'd/m/Y'
                                                    },
                                                    new Ext.form.Label({
                                                        text: 'Del :',
                                                        style: 'margin: 10px'
                                                    }),
                                                    new Ext.form.Label({
                                                        text: desde,
                                                        style: 'margin: 10px'
                                                    }),
                                                    new Ext.form.Label({
                                                        text: 'Al :',
                                                        style: 'margin: 10px'
                                                    }),
                                                    new Ext.form.Label({
                                                        text: hasta,
                                                        style: 'margin: 10px'
                                                    })
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
                                        // autoScroll: true,
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
                                                width: 300,
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
                                                    fields: ['id_funcionario', 'desc_funcionario1','id_equipo_responsable'],
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
                                                valueField: 'id_equipo_responsable',
                                                displayField: 'desc_funcionario1',
                                            },
                                            {
                                                width: 300,
                                                height: 180,
                                                store: new Ext.data.JsonStore({
                                                    url: '../../sis_auditoria/control/CronogramaEquipoResponsable/listarCronogramaEquipoResponsable',
                                                    id: 'id_funcionario',
                                                    root: 'datos',
                                                    totalProperty: 'total',
                                                    fields: ['id_funcionario', 'desc_funcionario1','id_equipo_responsable'],
                                                    remoteSort: true,
                                                    baseParams: { dir:'ASC', sort:'id_funcionario', limit:'100', start:'0'}
                                                }),
                                                tbar:[{
                                                    text: 'Limpiar',
                                                    handler:function(){
                                                        isForm.getForm().findField('itemselector').reset();
                                                    }
                                                }],
                                                valueField: 'id_equipo_responsable',
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
                                    new Ext.form.Label({
                                        text: 'Cronograma de Actividades de la Auditoria: '+ maestro.nombre_aom1,
                                        style: 'font-size: 14px; margin-bottom: 10px;'
                                    }),
                                    {
                                        xtype: 'field',
                                        fieldLabel: '',
                                        style: 'background-image: none; border: 0;',
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
                console.log(data)
                isForm.getForm().findField('fecha_ini_activ').setValue(data.json.fecha_ini_activ);
                isForm.getForm().findField('hora_ini_activ').setValue(new Date(data.json.fecha_ini_activ+' '+data.json.hora_ini_activ));
                isForm.getForm().findField('hora_fin_activ').setValue(new Date(data.json.fecha_ini_activ+' '+data.json.hora_fin_activ));

                setTimeout(() => {
                    isForm.getForm().findField('id_actividad').setValue(data.json.id_actividad);
                    isForm.getForm().findField('id_actividad').setRawValue(data.json.actividad);
                }, 1000);


                isForm.getForm().findField('itemselector').multiselects[0].store.baseParams = {
                                dir:'ASC',
                                sort:'id_aom',
                                limit:'100',
                                start:'0',
                                id_aom: maestro.id_aom,
                                item :data.json.id_cronograma
                            };
                isForm.getForm().findField('itemselector').multiselects[1].store.baseParams = {
                                dir:'ASC',
                                sort:'id_aom',
                                limit:'100',
                                start:'0',
                                id_cronograma: data.json.id_cronograma
                };
                isForm.getForm().findField('itemselector').multiselects[1].store.load();
            }
      this.ventanaCroronograma = new Ext.Window({
         width: 700,
         height: 680,
         modal: true,
          autoScroll: true,
         closeAction: 'hide',
         labelAlign: 'bottom',
         title: 'CRONOGRAMA DE ACTIVIDADES POR AUDITORIA',
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
    formularioRiego:function(record){
        const maestro = this.sm.getSelected().data;
        const isForm = new Ext.form.FormPanel({
            items: [
                new Ext.form.FieldSet({
                    collapsible: false,
                    border: true,
                    layout: 'form',
                    items: [
                        {
                            xtype: 'combo',
                            name: 'id_tipo_ro',
                            fieldLabel: 'Tipo RO',
                            allowBlank: false,
                            emptyText: 'Elija una opción...',
                            store: new Ext.data.JsonStore({
                                url: '../../sis_auditoria/control/TipoRo/listarTipoRo',
                                id: 'id_tipo_ro',
                                root: 'datos',
                                sortInfo: {
                                    field: 'desc_tipo_ro',
                                    direction: 'ASC'
                                },
                                totalProperty: 'total',
                                fields: ['id_tipo_ro', 'tipo_ro','desc_tipo_ro'],
                                remoteSort: true,
                                baseParams: {par_filtro: 'tro.desc_tipo_ro'/*,p_tipo_ro:"''RIESGO_PLANIFICACION'',''OPORT_PLANIFICACION''"*/}
                            }),
                            valueField: 'id_tipo_ro',
                            displayField: 'desc_tipo_ro',
                            gdisplayField: 'desc_tipo_ro',
                            hiddenName: 'id_tipo_ro',
                            mode: 'remote',
                            anchor: '100%',
                            triggerAction: 'all',
                            lazyRender: true,
                            pageSize: 15,
                            minChars: 2
                        },
                        {
                            xtype: 'combo',
                            name: 'id_ro',
                            fieldLabel: 'Riesgo Oportunidad',
                            allowBlank: false,
                            emptyText: 'Elija una opción...',
                            store: new Ext.data.JsonStore({
                                url: '../../sis_auditoria/control/RiesgoOportunidad/listarRiesgoOportunidad',
                                id: 'id_ro',
                                root: 'datos',
                                sortInfo: {
                                    field: 'nombre_ro',
                                    direction: 'DESC'
                                },
                                totalProperty: 'total',
                                fields: ['id_ro', 'nombre_ro','codigo_ro'],
                                remoteSort: true,
                                baseParams: {par_filtro: 'rop.nombre_ro'}
                            }),
                            valueField: 'id_ro',
                            displayField: 'nombre_ro',
                            gdisplayField: 'nombre_ro',
                            hiddenName: 'id_ro',
                            mode: 'remote',
                            anchor: '100%',
                            triggerAction: 'all',
                            lazyRender: true,
                            pageSize: 15,
                            minChars: 2
                        },
                        {
                            xtype: 'combo',
                            name: 'id_probabilidad',
                            fieldLabel: 'Probabilidad',
                            allowBlank: false,
                            emptyText: 'Elija una opción...',
                            store: new Ext.data.JsonStore({
                                url: '../../sis_auditoria/control/Probabilidad/listarProbabilidad',
                                id: 'id_probabilidad',
                                root: 'datos',
                                sortInfo: {
                                    field: 'nombre_prob',
                                    direction: 'ASC'
                                },
                                totalProperty: 'total',
                                fields: ['id_probabilidad', 'nombre_prob'],
                                remoteSort: true,
                                baseParams: {par_filtro: 'prob.nombre_prob'}
                            }),
                            valueField: 'id_probabilidad',
                            displayField: 'nombre_prob',
                            gdisplayField: 'nombre_prob',
                            hiddenName: 'id_probabilidad',
                            mode: 'remote',
                            anchor: '100%',
                            triggerAction: 'all',
                            lazyRender: true,
                            pageSize: 15,
                            minChars: 2
                        },
                        {
                            xtype: 'combo',
                            name: 'id_impacto',
                            fieldLabel: 'Impacto',
                            allowBlank: false,
                            emptyText: 'Elija una opción...',
                            store: new Ext.data.JsonStore({
                                url: '../../sis_auditoria/control/Impacto/listarImpacto',
                                id: 'id_impacto',
                                root: 'datos',
                                sortInfo: {
                                    field: 'nombre_imp',
                                    direction: 'ASC'
                                },
                                totalProperty: 'total',
                                fields: ['id_impacto', 'nombre_imp'],
                                remoteSort: true,
                                baseParams: {par_filtro: 'imp.nombre_imp'}
                            }),
                            valueField: 'id_impacto',
                            displayField: 'nombre_imp',
                            gdisplayField: 'nombre_imp',
                            hiddenName: 'id_impacto',
                            mode: 'remote',
                            anchor: '100%',
                            triggerAction: 'all',
                            lazyRender: true,
                            pageSize: 15,
                            minChars: 2
                        },
                        {
                            xtype: 'field',
                            fieldLabel: 'Criticidad',
                            name: 'criticidad',
                            anchor: '100%',
                        },
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
        if (record){
            Phx.CP.loadingShow();
            setTimeout(() => {
                isForm.getForm().findField('id_tipo_ro').setValue(record.id_tipo_ro);
                isForm.getForm().findField('id_tipo_ro').setRawValue(record.desc_tipo_ro);

                isForm.getForm().findField('id_ro').setValue(record.id_ro);
                isForm.getForm().findField('id_ro').setRawValue(record.nombre_ro);

                isForm.getForm().findField('id_probabilidad').setValue(record.id_probabilidad);
                isForm.getForm().findField('id_probabilidad').setRawValue(record.nombre_prob);

                isForm.getForm().findField('id_impacto').setValue(record.id_impacto);
                isForm.getForm().findField('id_impacto').setRawValue(record.nombre_imp);
                isForm.getForm().findField('criticidad').setValue(record.criticidad);

                Phx.CP.loadingHide();

            }, 1000);
        }
        this.ventanaRiesgo= new Ext.Window({
            width: 500,
            height: 300,
            modal: true,
            autoScroll: true,
            closeAction: 'hide',
            labelAlign: 'bottom',
            title: 'RIESGO OPORTUNIDAD',
            bodyStyle: 'padding:5px',
            layout: 'border',
            items: [
                isForm,
            ],
            buttons: [
                {
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

                        if (record){
                            Ext.Ajax.request({
                                url: '../../sis_auditoria/control/AomRiesgoOportunidad/insertarAomRiesgoOportunidad',
                                params: {
                                    id_aom_ro : record.id_aom_ro,
                                    id_impacto : submit.id_impacto,
                                    id_probabilidad : submit.id_probabilidad,
                                    id_tipo_ro : submit.id_tipo_ro,
                                    id_ro : submit.id_ro,
                                    otro_nombre_ro : null,
                                    id_aom : maestro.id_aom,
                                    criticidad : submit.criticidad
                                },
                                isUpload: false,
                                success: function(a,b,c){
                                    this.storeRiesgo.load();
                                    isForm.getForm().reset();
                                    this.ventanaRiesgo.hide();
                                    Phx.CP.loadingHide();

                                },
                                argument: this.argumentSave,
                                failure: this.conexionFailure,
                                timeout: this.timeout,
                                scope: this
                            });
                        }else{
                            Ext.Ajax.request({
                                url: '../../sis_auditoria/control/AomRiesgoOportunidad/insertarAomRiesgoOportunidad',
                                params: {
                                    id_impacto : submit.id_impacto,
                                    id_probabilidad : submit.id_probabilidad,
                                    id_tipo_ro : submit.id_tipo_ro,
                                    id_ro : submit.id_ro,
                                    otro_nombre_ro : null,
                                    id_aom : maestro.id_aom,
                                    criticidad : submit.criticidad
                                },
                                isUpload: false,
                                success: function(a,b,c){
                                    this.storeRiesgo.load();
                                    isForm.getForm().reset();
                                    Phx.CP.loadingHide();

                                },
                                argument: this.argumentSave,
                                failure: this.conexionFailure,
                                timeout: this.timeout,
                                scope: this
                            });
                        }

                    },
                    scope: this
                },
                {
                text: 'Cerrar',
                handler: function(){
                    this.ventanaRiesgo.hide();
                    this.storeRiesgo.load();
                },
                scope: this
            }]
        });
    },
    asignarPregunta:function (formulario){
        const isForm = new Ext.form.FormPanel({
            items: [
                new Ext.form.FieldSet({
                    collapsible: false,
                    border: true,
                    layout: 'form',
                    autoScroll: true,
                    items: [
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
                            xtype: 'combo',
                            name: 'id_pn',
                            fieldLabel: 'Punto Norma',
                            allowBlank: false,
                            emptyText: 'Elija una opción...',
                            store: new Ext.data.JsonStore({
                                url: '../../sis_auditoria/control/PuntoNorma/listarPuntoNorma',
                                id: 'id_pn',
                                root: 'datos',
                                sortInfo: {
                                    field: 'codigo_pn',
                                    direction: 'ASC'
                                },
                                totalProperty: 'total',
                                fields: ['id_pn', 'nombre_pn','nombre_pn','sigla_norma','codigo_pn'],
                                remoteSort: true,
                                baseParams: {dir:'ASC',sort:'id_pn',limit:'100',start:'0'}
                            }),
                            displayField: 'nombre_pn',
                            valueField: 'id_pn',
                            tpl:'<tpl for="."><div class="x-combo-list-item"><p style="color:#01010a">{codigo_pn} - {nombre_pn}</p></div></tpl>',
                            hiddenName: 'id_pn',
                            mode: 'remote',
                            anchor: '100%',
                            triggerAction: 'all',
                            lazyRender: true,
                            pageSize: 50,
                            minChars: 2
                        },
                        {
                            xtype: 'textarea',
                            fieldLabel: 'Pregunta',
                            name: 'descrip_pregunta',
                            anchor: '100%'
                        },
                    ]
                })
            ],
            padding: this.paddingForm,
            bodyStyle: this.bodyStyleForm,
            border: this.borderForm,
            frame: this.frameForm,
            autoDestroy: false,
            autoScroll: true,
            region: 'center'
        });
        if (formulario){
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/Norma/listarNorma',
                params:{
                    dir : 'ASC',
                    sort :'id_norma',
                    limit : '1',
                    start : '0',
                    id_pn : formulario.id
                },
                success:function(resp){
                    const reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    const  record = reg.datos;
                    setTimeout(()=> {
                        isForm.getForm().items.items[0].setValue(record[0].id_norma);
                        isForm.getForm().items.items[0].setRawValue(record[0].sigla_norma);
                        Phx.CP.loadingHide();
                    },1000);
                },
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
            setTimeout(()=> {
                isForm.getForm().items.items[1].setValue(formulario.id);
                isForm.getForm().items.items[1].setRawValue(formulario.name);
            },1000);
        }
        isForm.getForm().items.items[0].on('select', function(combo, record, index){
            isForm.getForm().items.items[1].store.baseParams = {dir:'ASC',sort:'id_pn',limit:'100',start:'0',id_norma: record.data.id_norma}
            isForm.getForm().items.items[1].store.load();
            isForm.getForm().items.items[1].modificado = true;
            isForm.getForm().items.items[1].reset();
        },this);
        this.preguntaPnVentana = new Ext.Window({
            width: 600,
            height: 240,
            modal: true,
            autoScroll:true,
            closeAction: 'hide',
            labelAlign: 'bottom',
            title: 'PREGUNTA - PUNTO DE NORMA',
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
                        url: '../../sis_auditoria/control/Pregunta/insertarPregunta',
                        params: {
                            nro_pregunta: '0',
                            descrip_pregunta : submit.descrip_pregunta,
                            id_pn: submit.id_pn
                        },
                        isUpload: false,
                        success: function(a,b,c){
                            isForm.getForm().items.items[2].reset();
                            this.isFormp.getForm().items.items[3].multiselects[0].store.load();
                            Phx.CP.loadingHide();

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
                    text: 'Cerrar',
                    handler: function() {
                        this.preguntaPnVentana.hide();
                        // this.storeProceso.load();
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
                  if(elm.getXType()==='combo'&&elm.mode==='remote'&&elm.store!==undefined){
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
                  if((obj.getXType()==='combo'&&obj.mode==='remote'&&obj.store!==undefined)||key==='id_centro_costo'){
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
        this.getBoton('ant_estado').disable();

        if(data['estado_wf'] === 'aprobado_responsable'){
            this.getBoton('ant_estado').enable();
        }
        this.getBoton('diagrama_gantt').enable();
        return tb
    },
    liberaMenu:function(){
        const tb = Phx.vista.AuditoriaOportunidadMejora.superclass.liberaMenu.call(this);
        if(tb){
              this.getBoton('sig_estado').disable();
              this.getBoton('diagrama_gantt').disable();
              this.getBoton('ant_estado').disable();
        }
        return tb
    },
    onReloadPage : function(m){
          this.maestro = m;
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
    oncellclick : function(grid, rowIndex, columnIndex, e) {
        const fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name
        if (fieldName === 'id_proceso') {
            this.formularioProceso();
            this.procesoVentana.show();
        }
        if (fieldName === 'id_funcionario') {
            this.formularioEquipo();
            this.ventanaEquipo.show();
        }
        if (fieldName === 'id_pregunta') {
            const record = this.storePregunta.getAt(rowIndex);
            this.formularioPregunta(record);
            this.ventanaPregunta.show();
        }
        if (fieldName === 'codigo_pn' || fieldName === 'id_pn') {
            const record = this.storePuntoNorma.getAt(rowIndex);
            this.formularioPuntoNorma(record);
            this.ventanaPuntoNorma.show();
        }
        if (fieldName === 'id_actividad') {
            const record = this.storeCronograma.getAt(rowIndex);
            this.formularioCroronograma(record);
            this.ventanaCroronograma.show();
        }
        if (fieldName === 'id_tipo_ro' || fieldName === 'id_ro' || fieldName === 'id_probabilidad') {
            const record = this.storeRiesgo.getAt(rowIndex);
            this.formularioRiego(record.json);
            this.ventanaRiesgo.show();
        }
        if (fieldName === 'eliminar') {
            const record = this.storeCronograma.getAt(rowIndex);
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/Cronograma/eliminarCronograma',
                params: {
                    id_cronograma : record.json.id_cronograma
                },
                isUpload: false,
                success: function(a,b,c){
                    setTimeout(() => {
                        Phx.CP.loadingHide();
                        this.storeCronograma.load();
                    },1000)
                },
                argument: this.argumentSave,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            })
        }
        if (fieldName === 'eliminar_riesgo') {
            const record = this.storeRiesgo.getAt(rowIndex);
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/AomRiesgoOportunidad/eliminarAomRiesgoOportunidad',
                params: {
                    id_aom_ro : record.json.id_aom_ro
                },
                isUpload: false,
                success: function(a,b,c){
                    setTimeout(() => {
                        Phx.CP.loadingHide();
                        this.storeRiesgo.load();
                    },1000)
                },
                argument: this.argumentSave,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            })
        }
    },
    formatoFecha:function (date){
        let day = date.getDate()
        let month = date.getMonth() + 1
        let year = date.getFullYear()

        if(month < 10){
            return  `${day}/0${month}/${year}`
        }else{
            return  `${day}/${month}/${year}`
        }
    },
    bnew:false,
    bdel:false,
    bedit:true,
        west: {
            url: '../../../sis_auditoria/vista/auditoria_oportunidad_mejora/filter/FormFiltroPlan.php',
            width: '30%',
            title:'Filtros',
            collapsed: true,
            cls: 'FormFiltroPlan'
        }
    };
</script>
