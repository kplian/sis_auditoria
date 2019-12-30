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
        nombreVista: 'registroNoConformidad',
		//añadimos 2 variables
        obj:{},

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
			Phx.vista.NoConformidadGestion.superclass.constructor.call(this,config);
            this.load({params:{start:0, limit:this.tam_pag,id_aom:this.obj.id_aom}});

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
            this.ocultarComponente(this.Cmp.id_uo_adicional); //corregido
            this.Cmp.bandera.on('Check', function (Seleccion, dato) {
                if (dato){
                    this.mostrarComponente(this.Cmp.id_uo_adicional);
                }else{
                    this.ocultarComponente(this.Cmp.id_uo_adicional);
                    this.Cmp.id_funcionario.reset();
                    this.onRecuperarGerente(this.obj.id_uo);
                }

            }, this);
			
			this.addButton('btnChequeoDocumentosWf',
				{	text: 'Documentos',
					iconCls: 'bchecklist',
					disabled: true,
					handler: this.loadCheckDocumentosPlanWf,
					tooltip: '<b>Documentos de la No conformidad</b><br/>Subir los documentos de evidencia.'
				}
			);

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
            this.getBoton('btnReporte').enable();
			this.getBoton('btnChequeoDocumentosWf').enable();							
        },

        // al seleccionar un resgistro el boton se activa o desactiva
        liberaMenu:function(config) {
            var tb = Phx.vista.NoConformidad.superclass.liberaMenu.call(this);
            if (tb) {
				this.getBoton('btnReporte').disable();
				this.getBoton('btnChequeoDocumentosWf').disable();				
            }

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
                //Carga los datos de ambos paneles
                 myPanel.onReloadPage(data); // izquierda
                 myPanelEast.onReloadPage(data); // derecha
            }

            delete myPanel;
            delete myPanelEast;

		},
        
		loadValoresIniciales: function () {
            Phx.vista.NoConformidadGestion.superclass.loadValoresIniciales.call(this);
             this.Cmp.id_aom.setValue(this.obj.id_aom);
             this.Cmp.id_uo.setValue(this.obj.id_uo);
             this.Cmp.mostrar.setValue(this.obj.nombre_unidad);
			 this.Cmp.nro_tramite_padre.setValue(this.obj.nro_tramite);
        },
		
        onButtonNew:function(){
            Phx.vista.NoConformidadGestion.superclass.onButtonNew.call(this);
			console.log(this.obj)
            this.Cmp.id_uo.setValue(this.obj.id_uo);
            this.Cmp.mostrar.setValue(this.obj.nombre_unidad);

            this.onRecuperarGerente(this.obj.id_uo);
            this.Cmp.id_uo_adicional.on('select', function(combo, record, index){
                this.Cmp.id_funcionario.reset();
                this.onRecuperarGerente(record.data.id_uo);
            },this);
        },
        onButtonEdit:function(){
            Phx.vista.NoConformidadGestion.superclass.onButtonEdit.call(this);
            this.Cmp.mostrar.setValue(this.obj.nombre_unidad); //habilitado
            if (this.Cmp.id_uo_adicional.getValue()  === null){
                this.Cmp.bandera.setValue(false);
                this.onRecuperarGerente(this.obj.id_uo); //habilitado
            }else{
                this.Cmp.bandera.setValue(true);
                this.onRecuperarGerente(this.Cmp.id_uo_adicional.getValue());
            }
        },

		onButtonReporte :function () {
			var rec = this.sm.getSelected();
			Ext.Ajax.request({
				url:'../../sis_auditoria/control/NoConformidad/reporteNoConforPDF',

				params:{id_aom : rec.data.id_aom},
				success: this.successExport,
				failure: this.conexionFailure,
				timeout:this.timeout,
				scope:this
			});
		},
		
		//aumentado para los documentos
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

		onRecuperarGerente:function (id_uo) {
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/listarRespAreaGerente',
                params:{id_uo: id_uo },
                success:function(resp){
                    var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    this.Cmp.id_funcionario.setValue(reg.ROOT.datos.id_funcionario);
                    this.Cmp.id_funcionario.setRawValue(reg.ROOT.datos.desc_funcionario);
                },
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
        }
		


    };
	
</script>
