<?php
/**
 *@package pXP
 *@file ProgramarAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 13-08-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.ProgramarAuditoria = {
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        nombreVista: 'ProgramarAuditoria',
        gruposBarraTareas:[
            {name:'pendiente',title:'<h1 align="center"><i></i>Pendientes</h1>',grupo:0,height:0},
            {name:'aprobado',title:'<h1 align="center"><i></i>Programadas</h1>',grupo:1,height:0},
            {name:'ejecucion',title:'<h1 align="center"><i></i>Planificados</h1>',grupo:2,height:0}
        ],
        tam_pag:50,
        actualizarSegunTab: function(name, indice){
            if (this.finCons) {
                this.store.baseParams.pes_estado = name;
                this.load({params: {start: 0, limit: this.tam_pag}});
            }
        },
        bnewGroups:[0],
        bactGroups:[0,1,2],
        bdelGroups:[0],
        beditGroups:[0],
        bexcelGroups:[0,1,2],
        fheight: '60%',
        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            Phx.vista.ProgramarAuditoria.superclass.constructor.call(this,config);
            this.getBoton('ant_estado').setVisible(false);
            this.getBoton('btnObs').setVisible(false);
            this.init();
            this.store.baseParams.pes_estado = 'pendiente';
            this.iniciarEvento();
            this.load({params:{ start:0, limit:this.tam_pag}});
        },
        onButtonNew: function () {
            Phx.vista.ProgramarAuditoria.superclass.onButtonNew.call(this);
            this.Cmp.id_tipo_auditoria.on('select', function( combo, record, index){
               if(record.data.codigo_tpo_aom === 'OM'){
                   this.mostrarComponente(this.Cmp.id_tipo_om);
                   this.mostrarComponente(this.Cmp.id_gconsultivo);
                   this.ocultarComponente(this.Cmp.id_funcionario);
               }else {
                   this.ocultarComponente(this.Cmp.id_tipo_om);
                   this.ocultarComponente(this.Cmp.id_gconsultivo);
                   this.mostrarComponente(this.Cmp.id_funcionario);
               }
            },this);
        },
        onButtonEdit:function(){
            Phx.vista.ProgramarAuditoria.superclass.onButtonEdit.call(this);
        },
        preparaMenu:function(n){
            var tb =this.tbar;
            Phx.vista.ProgramarAuditoria.superclass.preparaMenu.call(this,n);
            this.getBoton('sig_estado').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('btnObs').enable();
            this.getBoton('diagrama_gantt').enable();
            return tb
        },
        liberaMenu:function(){
            var tb = Phx.vista.ProgramarAuditoria.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('sig_estado').disable();
                this.getBoton('btnChequeoDocumentosWf').disable();
                this.getBoton('btnObs').disable();
                this.getBoton('diagrama_gantt').disable();
            }
            return tb
        }
       
};
</script>
