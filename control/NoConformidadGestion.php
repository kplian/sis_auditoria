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
		/*
		gruposBarraTareas:[
            {name:'borrador',title:'<h1 align="center"><i></i>Borrador</h1>',grupo:0,height:0},
            {name:'asignado',title:'<h1 align="center"><i></i>Asignado</h1>',grupo:1,height:0},
            {name:'aprobado',title:'<h1 align="center"><i></i>Aprobado</h1>',grupo:2,height:0}
        ],
		*/
        constructor: function(config) {
			//insertamos los combos
			this.maestro=config.maestro;
			this.initButtons=[this.cmbTipoAuditoria, this.cmbAuditorias];
			//
            Phx.vista.NoConformidadGestion.superclass.constructor.call(this,config);
            
			this.cmbTipoAuditoria.on('select', function(combo, record, index){
			    this.cmbTipoAuditoria = record.data.variable;
                this.cmbAuditorias.enable();
                this.cmbAuditorias.reset();
                this.store.removeAll();
                this.cmbAuditorias.store.baseParams = Ext.apply(this.cmbAuditorias.store.baseParams, {v_oportunidad: record.data.variable});
                this.cmbAuditorias.modificado = true;
			},this);
			//insertamos y habilitamos el boton atras
			this.addButton('atras',{argument: { estado: 'anterior'},
				text:'Anterior',
				iconCls: 'batras',
				disabled:true,
				//handler:this.antEstado,
				handler:this.onButtonAtras,
				tooltip: '<b>Pasar al anterior Estado</b>'});
			//insertamos y habilitamos el boton siguiente
			this.addButton('siguiente',{text:'Siguiente',
				iconCls: 'badelante',
				disabled:true,
				handler:this.onButtonSiguiente,   //creamos esta funcion para disparar el evento al presionar siguiente
				tooltip: '<b>Siguiente</b><p>Pasar al siguiente estado</p>'});
					
			//insertamos y habilitamos el boton Gantt
			this.addBotonesGantt();
			
			this.cmbAuditorias.on('select', function( combo, record, index){
				 this.capturaFiltros();
			},this);
			this.init();
            this.addButton('acciones',{
                            text: 'Acciones',
                            iconCls: 'bdocuments',
                            disabled: false,
                            handler: this.onButtonAcciones,
                            tooltip: '<b>Asigna acciones para resolver la No conformidades...</b>',
                            scope:this
            });
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

        //los botnoes se preparan al inicar la vista
        preparaMenu:function(n){
            Phx.vista.NoConformidad.superclass.preparaMenu.call(this, n);
            this.getBoton('siguiente').enable();
            this.getBoton('atras').enable(); 	//se habilita para el boton para atras
			this.getBoton('diagrama_gantt').enable();
        },

        // al seleccionar un resgistro el boton se ativa o desativa
        liberaMenu:function() {
            var tb = Phx.vista.NoConformidad.superclass.liberaMenu.call(this);
            if (tb) {
                this.getBoton('siguiente').disable();
                this.getBoton('atras').disable();	//se habilita para el boton para atras
				this.getBoton('diagrama_gantt').disable();
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
            this.Cmp.id_aom.setValue(this.cmbAuditorias.getValue());
            Phx.vista.NoConformidadGestion.superclass.loadValoresIniciales.call(this);
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
                alert('Selecciones un regisro')
            }

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
        },
		//adicionamos los combos para seleccionar la auditoria 
		//de esta manera se despliegan sus no conformidades
		cmbTipoAuditoria: new Ext.form.ComboBox({
			name:'tipoauditoria',
			fieldLabel:'Tipo de Auditoria',
			allowBlank: false,
			emptyText:'Tipo de Auditoria...',
			store: new Ext.data.ArrayStore({
				fields: ['variable', 'valor'],
				data :  [   ['0','Auditoria Interna'],
							['1','Oportunidad de Mejora']
				]
			}),
			valueField: 'variable',
			displayField: 'valor',
			mode: 'local',
			forceSelection:true,
			typeAhead: true,
			triggerAction: 'all',
			lazyRender: true,
			queryDelay: 1000,
			width: 150,
			minChars: 2 ,
			//enableMultiSelect: true
		}),
		
	    cmbAuditorias: new Ext.form.ComboBox({
        // fieldLabel: 'Auditoria u Oportunidad de mejora',
			allowBlank: false,
			emptyText:'Auditoria u Oportunidad de mejora...',
			blankText: 'Auditorias',
			store:new Ext.data.JsonStore(
				{
					url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/listarAuditoriaOportunidadMejora',
					id: 'id_aom',
					root: 'datos',
					sortInfo:{
						field: 'nombre_aom2',
						direction: 'DESC'
					},
					totalProperty: 'total',
					fields: ['id_aom','nombre_aom2','id_uo'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'nombre_aom2'}
				}),
			valueField: 'id_aom',
			triggerAction: 'all',
			displayField: 'nombre_aom2',
			hiddenName: 'id_aom',
			mode:'remote',
			pageSize:50,
			queryDelay:500,
			listWidth:'280',
			width:300,
			tpl:'<tpl for="."><div class="x-combo-list-item"><p><font color="#006400"><b>{nombre_aom2}</b></font></p>' +
			'<p><font color="#006400"><b>{id_aom}</b></font></p><p><b>{id_uo}</b></p></div></tpl>',
		})

    };
</script>
