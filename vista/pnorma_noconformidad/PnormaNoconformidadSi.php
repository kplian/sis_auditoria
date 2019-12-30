<?php
/**
 *@package pXP
*@file gen-PnormaNoconformidadSi.php
 *@author  (szambrana)
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.PnormaNoconformidadSi = {

        require:'../../../sis_auditoria/vista/pnorma_noconformidad/PnormaNoconformidad.php',
        requireclase:'Phx.vista.PnormaNoconformidad',
        title:'No Conformidad Detalle',
        nombreVista: 'No Conformidad Detalle',

        constructor: function(config) {
            Phx.vista.PnormaNoconformidadSi.superclass.constructor.call(this,config);
            this.init();
         //   this.load({params:{start:0, limit:this.tam_pag}});
        },

        onReloadPage:function (m)
		{
			this.maestro=m;
			this.store.baseParams={id_nc:this.maestro.id_nc};
            this.load({params:{start:0, limit:50}})
		},
		loadValoresIniciales:function ()
		{
			Phx.vista.PnormaNoconformidadSi.superclass.loadValoresIniciales.call(this);
			this.Cmp.id_nc.setValue(this.maestro.id_nc);
		},

		//vamos añadir la interfaz debil referida a los puntos de norma para las no conformidades****SSS
        east: {
            url:'../../../sis_auditoria/vista/si_noconformidad/SiNoconformidad.php',
            title:'Sistemas Integrados para No conformidad',
            //height:'50%',
            width: '50%',
            cls:'SiNoconformidad'
        }
    };
</script>
