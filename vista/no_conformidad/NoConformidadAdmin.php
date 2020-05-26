<?php
/**
 *@package pXP
 *@file NoConformidadAdmin.php
 *@author  (szambrana)
 *@date 04-07-2019 19:53:16
 *@Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadAdmin = {

        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'No Conformidad Detalle ',
        nombreVista: 'Administracion de No conformidades',
		//añadimos 2 variables
        obj:{},
		bdel:false,
		bsave:false,
		bnew:false,
		bedit:false,

        constructor: function(config) {

			this.idContenedor = config.idContenedor;
			this.maestro = config;
			this.obj = {
			    id_aom : this.maestro.id_aom,
                id_uo : this.maestro.id_uo,
                nombre_unidad : this.maestro.nombre_unidad,
				bandera : this.maestro.bandera,
				id_uo_adicional : this.maestro.id_uo_adicional,
				nro_tramite : this.maestro.nro_tramite_wf
            };
			this.initButtons=[this.cmbTipoAuditoria, this.cmbAuditorias];
			Phx.vista.NoConformidadAdmin.superclass.constructor.call(this,config);

            this.crearFormResponsableNC();

            this.cmbTipoAuditoria.on('select', function(combo, record, index){
                console.log(record.data);
			    this.cmbTipoAuditoria = record.data.id_tipo_auditoria;
                this.cmbAuditorias.enable();
                this.cmbAuditorias.reset();
                this.store.removeAll();
                this.cmbAuditorias.store.baseParams = Ext.apply(this.cmbAuditorias.store.baseParams, {v_tipo_auditoria_nc: record.data.id_tipo_auditoria});
                this.cmbAuditorias.modificado = true;
			},this);

            this.cmbAuditorias.on('select', function(combo, record, index){
					this.capturaFiltros();
					this.Cmp.id_uo.setValue(record.data.uo);
					this.Cmp.id_uo.setValue(record.data.id_uo);
                    this.Cmp.id_uo.setRawValue(record.data.nombre_unidad);
					this.Cmp.id_uo.setValue(record.data.nombre_unidad);
                    this.uo = record.data.id_uo;
                    this.nombre_unidad = record.data.nombre_unidad;
					
            },this);

			this.addButton('atras',{argument: { estado: 'anterior'},
				text:'Anterior',
				iconCls: 'batras',
				disabled:true,
				handler:this.onButtonAtras,
				tooltip: '<b>Pasar al anterior Estado</b>'});
			
			this.addButton('siguiente',
				{	text:'Siguiente',
					iconCls: 'badelante',
					disabled:false,
					handler:this.onButtonSiguiente,   //creamos esta funcion para disparar el evento al presionar siguiente
					tooltip: '<b>Siguiente</b><p>Pasar al siguiente Estado</p>'
				}
			);
			
			//insertamos y habilitamos el boton Gantt
			this.addBotonesGantt();
			this.addButton('btnChequeoDocumentosWf',
				{	text: 'Documentos',
					iconCls: 'bchecklist',
					disabled: true,
					handler: this.loadCheckDocumentosPlanWf,
					tooltip: '<b>Documentos de la No conformidad</b><br/>Subir los documentos de evidencia.'
				}
			);		
			
			//insertamos y habilitamos el boton de observaciones						
			this.addButton('btnObs', {
					text :'Obs Wf',
					iconCls : 'bchecklist',
					disabled: true,
					handler : this.onOpenObs,
					tooltip : '<b>Observaciones</b><br/><b>Observaciones del WF</b>'
			}
			);
			
			//insertamos y habilitamos el boton reportes						
			this.addButton('btnReporte',
				{
					text :'Reporte',
					iconCls : 'bpdf32',
					disabled: true,
					handler : this.onButtonReporte,
					tooltip : '<b>Reporte</b><br/><b>No conformidades</b>'
			}
			);			
			
			//insertamos y habilitamos el boton  para asignar responsables						
			this.addButton('btnAddResp',
				{
					text :'Responsable',
					iconCls : 'bcargo',
					disabled: true,
					handler : this.onButtonMostrarFormRespNC,
					tooltip : '<b>Responsable de</b><br/><b>No conformidad</b>'
			}
			);				
			//ponemos el nombre de la auditoria en un label en las NC
			this.nombre = new Ext.form.Label({
				name: 'nombre_auditoria',
				fieldLabel: 'Nombre',
				readOnly:true,
				anchor: '150%',
				gwidth: 150,
				hidden : false,
				//style: 'font-size: 125%; font-weight: bold; background-image: none; text-align: right;'
				style: 'font-size: 150%; font-weight: bold; color: red; background-image: none; text-align: right;'
			});
			this.tbar.addField(this.nombre);
			//this.nombre.setText(this.maestro.nombre_aom1);
			this.nombre.setText(this.obj.nombre_aom1);
			this.init();
			
            this.ocultarComponente(this.Cmp.id_uo_adicional); //corregido

			
        },
		
		tabsouth:[
        {
            url:'../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php',
            title:'Acciones Propuestas para la no conformidad',
            height:'50%',
            cls:'AccionPropuesta'
        }
		],		

        //los botones se preparan al inicar la vista
        preparaMenu:function(n){
            Phx.vista.NoConformidad.superclass.preparaMenu.call(this, n);
            this.getBoton('siguiente').enable();
            this.getBoton('atras').enable(); 	//se habilita para el boton para atras
			this.getBoton('diagrama_gantt').enable();
			this.getBoton('btnChequeoDocumentosWf').enable();
			this.getBoton('btnObs').enable();			
			this.getBoton('btnReporte').enable();
			this.getBoton('btnAddResp').enable();
			
        },

        // al seleccionar un resgistro el boton se activa o desactiva
        liberaMenu:function() {
            var tb = Phx.vista.NoConformidad.superclass.liberaMenu.call(this);
            if (tb) {
                this.getBoton('siguiente').disable();
                this.getBoton('atras').disable();	//se habilita para el boton para atras
				this.getBoton('diagrama_gantt').disable();
				this.getBoton('btnChequeoDocumentosWf').disable();
				this.getBoton('btnObs').disable();
				this.getBoton('btnReporte').disable();	
				this.getBoton('btnAddResp').disable();				
            }
        },

        onButtonSigGrupo:function (){
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/sigueienteGrupo',
                params:{ id_aom : this.cmbAuditorias.getValue()},
                success: this.success,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
            this.reload();
        },
        success: function(resp){
            Phx.CP.loadingHide();
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            console.log(reg);
        },
		//Boton Siguiente
        onButtonSiguiente : function() {
            var rec = this.sm.getSelected();
            this.objWizard = Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/FormEstadoWf.php',
                'Estado de Wf',
                {
                    modal: true,
                    width: 700,
                    height: 450
                },
                {
                    data: {
                        id_estado_wf: rec.data.id_estado_wf,
                        id_proceso_wf: rec.data.id_proceso_wf
                    }
                }, this.idContenedor, 'FormEstadoWf',
                {
                    config: [{
                        event: 'beforesave',
                        delegate: this.onSaveWizard
                    }],
                    scope: this
                }
            );
        },

        onSaveWizard:function(wizard,resp){
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/siguienteEstado',
                params:{
                    id_proceso_wf_act:  resp.id_proceso_wf_act,
                    id_estado_wf_act:   resp.id_estado_wf_act,
                    id_tipo_estado:     resp.id_tipo_estado,
                    id_funcionario_wf:  resp.id_funcionario_wf,
                    id_depto_wf:        resp.id_depto_wf,
                    obs:                resp.obs,
                    json_procesos:      Ext.util.JSON.encode(resp.procesos)
                },
                success:this.successEstadoSinc,
                failure: this.conexionFailure,
                argument:{wizard:wizard},
                timeout:this.timeout,
                scope:this
            });
        },
        successWizardS:function(resp){
            console.log(1)
            Phx.CP.loadingHide();
            resp.argument.wizard.panel.destroy();
            this.reload();
        },

		onButtonAtras : function(res){
			var rec=this.sm.getSelected();
			Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/AntFormEstadoWf.php',
				'Estado de Wf',
				{
					modal:true,
					width:450,
					height:250
				}, { data:rec.data, estado_destino: res.argument.estado}, this.idContenedor,'AntFormEstadoWf',
				{
					config:[{
						event:'beforesave',
						delegate: this.onAntEstado
					}
					],
					scope:this
				});			
		},
		onAntEstado: function(wizard,resp){
			Phx.CP.loadingShow();
			Ext.Ajax.request({
				url:'../../sis_auditoria/control/NoConformidad/anteriorEstado',
				params:{
					id_proceso_wf: resp.id_proceso_wf,
					id_estado_wf:  resp.id_estado_wf,
					obs: resp.obs,
					estado_destino: resp.estado_destino
				},
				argument:{wizard:wizard},
				success:this.successEstadoSinc,
				failure: this.conexionFailure,
				timeout:this.timeout,
				scope:this
			});
		},
		successEstadoSinc:function(resp){
			Phx.CP.loadingHide();
			resp.argument.wizard.panel.destroy();
			this.reload();
		},
        loadValoresIniciales: function () {
			this.Cmp.id_aom.setValue(this.cmbAuditorias.getValue());
            Phx.vista.NoConformidadAdmin.superclass.loadValoresIniciales.call(this);
             this.Cmp.id_aom.setValue(this.obj.id_aom);
             this.Cmp.id_uo.setValue(this.obj.id_uo);
             this.Cmp.id_uo.setRawValue(this.obj.nombre_unidad);


        },
        onButtonNew:function(){
            Phx.vista.NoConformidadAdmin.superclass.onButtonNew.call(this);
            this.Cmp.id_uo.setValue(this.obj.id_uo);
            this.Cmp.id_uo.setRawValue(this.obj.nombre_unidad);
        },

        capturaFiltros:function(combo, record, index){
            // this.desbloquearOrdenamientoGrid();
            if(this.validarFiltros()){
                this.store.baseParams.id_aom = this.cmbAuditorias.getValue();
                this.load();
            }
        },

        validarFiltros:function(){
            if(this.cmbAuditorias.validate()){
                return true;
            } else{
                return false;
            }
        },

		//implementamos el Gantt
		diagramGanttDinamico : function(){
        var data=this.sm.getSelected().data.id_proceso_wf;
        window.open('../../../sis_workflow/reportes/gantt/gantt_dinamico.html?id_proceso_wf='+data)
		},

		addBotonesGantt: function() {
			this.menuAdqGantt = new Ext.Toolbar.SplitButton({
				id: 'b-diagrama_gantt-' + this.idContenedor,
				text: 'Gantt',
				disabled: true,
				//grupo:[0,1,2,3,4],
				iconCls : 'bgantt',
				handler:this.diagramGanttDinamico,
				scope: this,
				menu:{
					items: [{
						id:'b-gantti-' + this.idContenedor,
						text: 'Gantt Imagen',
						tooltip: '<b>Muestra un reporte gantt en formato de imagen</b>',
						handler:this.diagramGantt,
						scope: this
					}, {
						id:'b-ganttd-' + this.idContenedor,
						text: 'Gantt Dinámico',
						tooltip: '<b>Muestra el reporte gantt facil de entender</b>',
						handler:this.diagramGanttDinamico,
						scope: this
					}
					]}
			});
			this.tbar.add(this.menuAdqGantt);
		},

		diagramGantt : function (){
			var data=this.sm.getSelected().data.id_proceso_wf;
			Phx.CP.loadingShow();
			Ext.Ajax.request({
				url: '../../sis_workflow/control/ProcesoWf/diagramaGanttTramite',
				params: { 'id_proceso_wf': data },
				success: this.successExport,
				failure: this.conexionFailure,
				timeout: this.timeout,
				scope: this
			});
		},
		
		
        onButtonAcciones:function(){
            var rec = this.sm.getSelected();  //los valores del registro seleccionado
            if (rec.data === undefined){
                alert('Selecciones un registro');
            } else if (rec.data.estado_wf == "propuesta") {
				alert('La No Conformidad debe ser aprobada');
			} else {
				console.log ('Data',rec.data);
				Phx.CP.loadWindows('../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php', // direciones de la vista
				'Acciones', // titulos de la ventana
                {
                    width:'80%',
                    height:'60%'
                },  /// dimensiones
				rec.data, // record dara padres para filtrado de datos padre e hijo
                this.idContenedor, /// los datos de padre
                'AccionPropuesta'); // clase de la viste hijo
			}
        },
		
		loadCheckDocumentosPlanWf:function(){
			var rec=this.sm.getSelected();
			rec.data.nombreVista = this.nombreVista;
			Phx.CP.loadWindows('../../../sis_workflow/vista/documento_wf/DocumentoWf.php',
				'Chequear documento del WF',
				{
					width:'90%',
					height:500
				},
				rec.data,
				this.idContenedor,
				'DocumentoWf'
			)
		},		
		
		onOpenObs:function() {
			var rec=this.sm.getSelected();            
			var data = {
				id_proceso_wf: rec.data.id_proceso_wf,
				id_estado_wf: rec.data.id_estado_wf,
				num_tramite: rec.data.num_tramite
			}
			
			Phx.CP.loadWindows('../../../sis_workflow/vista/obs/Obs.php',
				'Observaciones del WF',
				{
					width: '80%',
					height: '70%'
				},
				data,
				this.idContenedor,
				'Obs');
		},

		onButtonReporte :function () {
			var rec = this.sm.getSelected();
			Ext.Ajax.request({
				//url:'../../sis_asistencia/control/MesTrabajo/reporteHojaTiempo',
				url:'../../sis_auditoria/control/NoConformidad/reporteNoConforPDF',

				params:{    id_aom : rec.data.id_aom
				},
				success: this.successExport,
				failure: this.conexionFailure,
				timeout:this.timeout,
				scope:this
			});
		},
        //*****************************************************
		//Generamos el formulario para seleccionar y registrar a los responsables de no conformidad
        onButtonMostrarFormRespNC:function(){
            var uoID = null;
            var data = this.getSelectedData();
             if(data.id_uo_adicional != null){
                  uoID = data.id_uo;
             }
                 uoID = data.id_uo_adicional;

            this.cmpResponsable.reset();
            this.cmpResponsable.store.baseParams = Ext.apply(this.cmpResponsable.store.baseParams, {id_uo: uoID});
            this.cmpResponsable.modificado = true;
            if(data){
                this.cmpResponsable.setValue(data.funcionario_resp);
                this.ventanaResponsable.show();
            }
          //  console.log(this.cmpResponsable.getValue())

        },
        
        crearFormResponsableNC:function(){
           // Peticion ajax al metodo controlador            
            var storeCombo = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/NoConformidad/listarFuncionariosUO',
                id: 'id_funcionario',
                root: 'datos',
                sortInfo:{
                    field: 'desc_funcionario',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_funcionario','desc_funcionario','desc_funcionario_cargo'],
                remoteSort: true
                // baseParams: {par_filtro: 'desc_funcionario'}
            });
            
              var combo = new Ext.form.ComboBox({
                name:'id_funcionario_nc',
                fieldLabel:'Responsable de No Conformidad',
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
                title: 'Configuracion',
                collapsible: true,
                maximizable: true,
                autoDestroy: true,
                width: 380,
                height: 170,
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
            this.cmpResponsable = this.formAuto.getForm().findField('id_funcionario_nc');
        },

        saveResponsable: function(){
            var d = this.getSelectedData();
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_auditoria/control/NoConformidad/asignarFuncRespNC',
                params: {
                    id_nc: d.id_nc,
                    id_funcionario_nc: this.cmpResponsable.getValue()
                },
                success: this.successWizard,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        
		 successWizard:function(resp){
			var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            if(!reg.ROOT.error){
                if(this.ventanaResponsable){
                    this.ventanaResponsable.hide();
                }
				Phx.CP.loadingHide();
				this.reload();
			}else{
					alert("Error no se no se registro el funcionario")
			}
		},

	    cmbTipoAuditoria: new Ext.form.ComboBox({
			name:'tipoauditoria',
			fieldLabel: 'Tipo de Auditoria',
			allowBlank: false,
			emptyText:'Tipo de Auditoria...',
			blankText: 'Tipo de auditoria',
			store:new Ext.data.JsonStore(
				{
					url: '../../sis_auditoria/control/TipoAuditoria/listarTipoAuditoria',
					id: 'id_tipo_auditoria',
					root: 'datos',
					sortInfo:{
						field: 'id_tipo_auditoria',
						direction: 'DESC'
					},
					totalProperty: 'total',
					fields: ['id_tipo_auditoria','tipo_auditoria','id_uo','nombre_unidad','' ],
					//fields: ['id_aom','nombre_aom2','gerencia_uo'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'tipo_auditoria'}
				}),
			valueField: 'id_tipo_auditoria',
			triggerAction: 'all',
			displayField: 'tipo_auditoria',
			hiddenName: 'id_tipo_auditoria',
			mode:'remote',
			pageSize:50,
			queryDelay:500,
			listWidth:'280',
			width:300
		}),
    cmbAuditorias: new Ext.form.ComboBox({
			fieldLabel: 'Auditoria u Oportunidad de mejora',
			allowBlank: false,
			emptyText:'Auditoria u Oportunidad de mejora...',
			blankText: 'Auditorias',
			store:new Ext.data.JsonStore(
				{
					url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarAuditoriaOportunidadMejora',
					id: 'id_aom',
					root: 'datos',
					sortInfo:{
						field: 'nombre_aom1',
						direction: 'DESC'
					},
					totalProperty: 'total',
					fields: ['id_aom','nombre_aom1','id_uo','nombre_unidad','' ],
					remoteSort: true,
					baseParams:{par_filtro:'nombre_aom1'}
				}),
			valueField: 'id_aom',
			triggerAction: 'all',
			displayField: 'nombre_aom1',
			hiddenName: 'id_aom',
			mode:'remote',
			pageSize:50,
			queryDelay:500,
			listWidth:'280',
			width:300
		}),
    };
	
</script>
