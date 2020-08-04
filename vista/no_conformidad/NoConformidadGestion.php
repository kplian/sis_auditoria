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
    fwidth: '60%',
    fheight: '80%',
    constructor: function(config) {
          this.Atributos[this.getIndAtributo('revisar')].grid=false;
          this.Atributos[this.getIndAtributo('rechazar')].grid=false;
          this.maestro=config.maestro;
          Phx.vista.NoConformidadGestion.superclass.constructor.call(this,config);
          this.init();
          var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
          if(dataPadre){
              this.onEnablePanel(this, dataPadre);
          }
          else {
              this.bloquearMenus();
          }
    },
    onReloadPage:function(m){
      this.maestro=m;
      this.store.baseParams = {id_aom: this.maestro.id_aom,interfaz : this.nombreVista};
      this.load({params:{start:0, limit:50}});
    },
    loadValoresIniciales: function () {
        Phx.vista.NoConformidadGestion.superclass.loadValoresIniciales.call(this);
    },
    preparaMenu:function(n){
        const tb =this.tbar;
        Phx.vista.NoConformidadGestion.superclass.preparaMenu.call(this,n);
        this.getBoton('btnChequeoDocumentosWf').enable();
        this.getBoton('btnNoram').enable();
        return tb
    },
    liberaMenu:function(){
        const tb = Phx.vista.NoConformidadGestion.superclass.liberaMenu.call(this);
        if(tb){
            this.getBoton('btnChequeoDocumentosWf').disable();
            this.getBoton('btnNoram').disable();
        }
        return tb
    },
    onEvento:function() {
      this.ocultarComponente(this.Cmp.id_uo_adicional); //corregido
      this.Cmp.bandera.on('Check', function (Seleccion, dato) {
          if (dato){
              this.mostrarComponente(this.Cmp.id_uo_adicional);
          }else{
              this.ocultarComponente(this.Cmp.id_uo_adicional);
              this.Cmp.id_funcionario.reset();
              this.onRecuperarGerente(this.maestro.id_uo);
          }
      }, this);
    },
    onButtonReporte :function () {
      var rec = this.sm.getSelected();
      Ext.Ajax.request({
        url:'../../sis_auditoria/control/NoConformidad/reporteNoConforPDF',
        params:{id_aom : this.maestro.id_aom},
        success: this.successExport,
        failure: this.conexionFailure,
        timeout:this.timeout,
        scope:this
      });
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
    },
        preparaMenu:function(n){
            Phx.vista.NoConformidadGestion.superclass.preparaMenu.call(this, n);
            this.getBoton('btnNoram').enable();
        },
        liberaMenu:function() {
            var tb = Phx.vista.NoConformidadGestion.superclass.liberaMenu.call(this);
            if (tb) {
                this.getBoton('btnNoram').disable();
            }
        },

    };

</script>
