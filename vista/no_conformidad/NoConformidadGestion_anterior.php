<?php
/**
 *@package pXP
 *@file NoConformidadGestion.php
 *@author  (szambrana)
 *@date 04-07-2019 19:53:16
 *@Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadGestion = {

        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'No Conformidad Detalle',
        nombreVista: 'Gestion de No conformidad',
		//añadimos 2 variables
        obj:{},

        constructor: function(config) {
			this.idContenedor = config.idContenedor;
			// this.maestro=config.maestro;
			this.maestro = config;
			this.obj = {
			    id_aom : this.maestro.id_aom,
                id_uo : this.maestro.id_uo,
                nombre_unidad : this.maestro.nombre_unidad,
				//id_responsable : this.maestro.id_responsable, //aumentado
				//desc_funcionario1 : this.maestro.desc_funcionario1, //aumentado
				nombre_aom1 : this.maestro.nombre_aom1 //aumentado
            };
			Phx.vista.NoConformidadGestion.superclass.constructor.call(this,config);
            this.load({params:{start:0, limit:this.tam_pag,id_aom:this.obj.id_aom}});

			//insertamos los combos
			//this.initButtons=[this.cmbTipoAuditoria, this.cmbAuditorias];

			//insertamos y habilitamos el boton atras
			this.addButton('atras',{argument: { estado: 'anterior'},
				text:'Anterior',
				iconCls: 'batras',
				disabled:true,
				handler:this.onButtonAtras,
				tooltip: '<b>Pasar al anterior Estado</b>'});
			//insertamos y habilitamos el boton siguiente
			this.addButton('siguiente',
				{	text:'Siguiente',
					iconCls: 'badelante',
					disabled:true,
					handler:this.onButtonSiguiente,   //creamos esta funcion para disparar el evento al presionar siguiente
					tooltip: '<b>Siguiente</b><p>Pasar al siguiente estado</p>'
				}
			);
					
			//insertamos y habilitamos el boton Gantt
			this.addBotonesGantt();
            this.addButton('acciones',
				{	text: 'Acciones',
					iconCls: 'bdocuments',
					disabled: false,
					handler: this.onButtonAcciones,
					tooltip: '<b>Asigna acciones para resolver la No conformidades...</b>',
					scope:this
				}
			);
			//insertamos y habilitamos el boton de documentos			
			this.addButton('btnChequeoDocumentosWf',
				{	text: 'Documentos',
					iconCls: 'bchecklist',
					disabled: true,
					handler: this.loadCheckDocumentosPlanWf,
					tooltip: '<b>Documentos de la No conformidad</b><br/>Subir los documentos de evidencia.'
				}
			);			
			
			this.addButton('btnObs',
				{
					text :'Obs Wf',
					iconCls : 'bchecklist',
					disabled: true,
					handler : this.onOpenObs,
					tooltip : '<b>Observaciones</b><br/><b>Observaciones del WF</b>'
			}
			);
			
			this.addButton('btnReporte',
				{
					text :'Reporte',
					iconCls : 'bpdf32',
					disabled: true,
					handler : this.onButtonReporte,
					tooltip : '<b>Reporte</b><br/><b>No conformidades</b>'
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
			//this.load({params:{start:0, limit:this.tam_pag , id_aom: this.maestro.id_aom}})
			
        },

		//vamos añadir la interfaz debil referida a los puntos de norma para las no conformidades****SSS
		tabsouth:[
        {
            url:'../../../sis_auditoria/vista/pnorma_noconformidad/PnormaNoconformidadSi.php',
            title:'Puntos de norma para la No conformidad',
            height:'50%',
            cls:'PnormaNoconformidadSi'
        }
		],

        //los botones se preparan al inicar la vista
        preparaMenu:function(n){
            Phx.vista.NoConformidad.superclass.preparaMenu.call(this, n);
            this.getBoton('siguiente').enable();
            this.getBoton('atras').enable(); 	//se habilita para el boton para atras
			this.getBoton('diagrama_gantt').enable();
			this.getBoton('acciones').enable();
			this.getBoton('btnChequeoDocumentosWf').enable();
			this.getBoton('btnObs').enable();			
			this.getBoton('btnReporte').enable();
			
        },

        // al seleccionar un resgistro el boton se activa o desactiva
        liberaMenu:function() {
            var tb = Phx.vista.NoConformidad.superclass.liberaMenu.call(this);
            if (tb) {
                this.getBoton('siguiente').disable();
                this.getBoton('atras').disable();	//se habilita para el boton para atras
				this.getBoton('diagrama_gantt').disable();
				this.getBoton('acciones').disable();
				this.getBoton('btnChequeoDocumentosWf').disable();
				this.getBoton('btnObs').disable();
				this.getBoton('btnReporte').disable();				
            }
        },
		
		//Boton Siguiente
        onButtonSiguiente : function() {
            var rec = this.sm.getSelected();  // aqui se almacena los datos del registro selecionado
            console.log(rec);
            this.objWizard = Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/FormEstadoWf.php', // llama al formulario de wf
                'Estado de Wf',
                {
                    modal: true,
                    width: 700,
                    height: 450
                },
                {
                    data: {
                        id_estado_wf: rec.data.id_estado_wf, 	// parametros para obtener los estados de tu macro proceso y tipo proceso
                        id_proceso_wf: rec.data.id_proceso_wf	// parametros para obtener los estados de tu macro proceso y tipo proceso
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
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText)); // Respuesta del procedimiento
            Phx.CP.loadingShow(); // inica el reolad
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/siguienteEstado', // llamada al controlador del metodo para cambiar el estado
                params:{
                    id_proceso_wf_act:  resp.id_proceso_wf_act,
                    id_estado_wf_act:   resp.id_estado_wf_act,
                    id_tipo_estado:     resp.id_tipo_estado,
                    id_funcionario_wf:  resp.id_funcionario_wf,
                    id_depto_wf:        resp.id_depto_wf,
                    obs:                resp.obs,
                    json_procesos:      Ext.util.JSON.encode(resp.procesos)
                },
                success:this.successWizard,
                failure: this.conexionFailure,
                argument:{wizard:wizard},
                timeout:this.timeout,
                scope:this
            });
        },
        successWizard:function(resp){
            Phx.CP.loadingHide();
            resp.argument.wizard.panel.destroy();
            this.reload();
        },
		//Boton Atras
		onButtonAtras : function(res){
			//console.log("entra atras");
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

		//codigo necesario para añadir mas de un panel hijo en este caso tenemos 2
		onEnablePanel: function(idPanel, data) {
          console.log(data);
          var myPanel;
            if (typeof idPanel === 'object') {
                myPanel = idPanel
            } else {
                myPanel = Phx.CP.getPagina(idPanel);
            }
            if (idPanel && myPanel) {
                //Accede al panel derecho

                myPanelEast = Phx.CP.getPagina(idPanel+'-east');
                //console.log(myPanelEast);
                //Carga los datos de ambos paneles
                 myPanel.onReloadPage(data); // izquierda
                 myPanelEast.onReloadPage(data); // derecha
            }

            delete myPanel;
            delete myPanelEast;

       },
        loadValoresIniciales: function () {
            //this.Cmp.id_aom.setValue(this.cmbAuditorias.getValue());

            Phx.vista.NoConformidadGestion.superclass.loadValoresIniciales.call(this);
             this.Cmp.id_aom.setValue(this.obj.id_aom);
             this.Cmp.id_uo.setValue(this.obj.id_uo);
             this.Cmp.id_uo.setRawValue(this.obj.nombre_unidad);
			 //***
			 //this.Cmp.id_funcionario.setValue(this.obj.id_responsable);
			 //this.Cmp.id_funcionario.setRawValue(this.obj.desc_funcionario1);
			 

        },
        onButtonNew:function(){

            Phx.vista.NoConformidadGestion.superclass.onButtonNew.call(this);
            this.Cmp.id_uo.setValue(this.obj.id_uo);
            this.Cmp.id_uo.setRawValue(this.obj.nombre_unidad);
			//***
			//this.Cmp.id_funcionario.setValue(this.obj.id_responsable);
			//this.Cmp.id_funcionario.setRawValue(this.obj.desc_funcionario1);
			
            console.log(this.obj);

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

    };
	
</script>
