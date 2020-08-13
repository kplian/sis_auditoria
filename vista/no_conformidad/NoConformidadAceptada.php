<?php
/**
 *@package pXP
 *@file NoConformidadAceptada.php
 *@author  (szambrana)
 *@date 04-07-2019 19:53:16
 *@Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadAceptada = {

        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'No Conformidad',
        nombreVista: 'NoConformidadAceptada',
        bedit:false,
        bnew:false,
        bdel:false,
        dblclickEdit: false,

        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            this.maestro = config;
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            Phx.vista.NoConformidadAceptada.superclass.constructor.call(this,config);
            this.getBoton('btnChequeoDocumentosWf').setVisible(false);

            this.init();
        },
        onReloadPage:function(m){
            this.maestro = m;
            this.store.baseParams = {id_aom: this.maestro.id_aom,interfaz : this.nombreVista};
            this.load({params:{start:0, limit:50}})
        },
        loadValoresIniciales: function () {
            Phx.vista.NoConformidadAceptada.superclass.loadValoresIniciales.call(this);
            this.Cmp.id_aom.setValue(this.maestro.id_aom);
        },
        preparaMenu:function(n){
            const tb =this.tbar;
            Phx.vista.NoConformidadAceptada.superclass.preparaMenu.call(this,n);
            this.getBoton('btnNoram').enable();
            return tb
        },
        liberaMenu:function(){
            const tb = Phx.vista.NoConformidadAceptada.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('btnNoram').disable();
            }
            return tb
        },
    };

</script>
