<?php
/**
 *@package pXP
 *@file NoConformidadImplementar.php
 *@author  (szambrana)
 *@date 04-07-2019 19:53:16
 *@Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadImplementar = {

        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'No Conformidad',
        nombreVista: 'NoConformidadImplementar',
        bedit:false,
        bnew:false,
        bdel:false,
        dblclickEdit: false,

        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            this.maestro = config;
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            Phx.vista.NoConformidadImplementar.superclass.constructor.call(this,config);
            this.store.baseParams.interfaz = this.nombreVista;
            this.init();
            this.load({params:{start:0, limit:this.tam_pag}});
        },
        arrayDefaultColumHidden:['nombre_aom1','nombre_unidad','desc_funcionario_resp','nro_tramite','descrip_nc'],
        rowExpander: new Ext.ux.grid.RowExpander({
            tpl : new Ext.Template(
                '<br>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Nombre Auditoria:&nbsp;&nbsp;</b> {nombre_aom1}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Area:&nbsp;&nbsp;</b> {nombre_unidad}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Responsable Auditoria:&nbsp;&nbsp;</b> {desc_funcionario_resp}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Codigo:&nbsp;&nbsp;</b> {nro_tramite}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Descripcion:&nbsp;&nbsp;</b> {descrip_nc}</p>',
            )
        }),
        tabsouth:[
            {
                url:'../../../sis_auditoria/vista/accion_propuesta/AccionesPropuestaImplementadas.php',
                title:'Acciones',
                height:'50%',
                cls:'AccionesPropuestaImplementadas'
            }
        ],
    };

</script>
