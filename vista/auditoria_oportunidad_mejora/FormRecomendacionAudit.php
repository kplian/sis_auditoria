<?php
/**
 *@package pXP
 *@file    FormRecomendacionAudit.php
 *@author  Maximiliano Camacho
 *@date    17-09-2019
 *@description permite registrar Resumen y Recomendacion
 */
header("content-type: text/javascript; charset=UTF-8");
?>

<script>
    Phx.vista.FormRecomendacionAudit=Ext.extend(Phx.frmInterfaz,{
        //ActSave:'../../sis_adquisiciones/control/Solicitud/SolicitarPresupuesto',
        ActSave:'../../sis_auditoria/control/AuditoriaOportunidadMejora/insertRecomendation',

        string_recomendation: "",

        constructor:function(config) {
            this.maestro = config;
            //console.log("valor data en constructor:",this.maestro.data);
            Phx.vista.FormRecomendacionAudit.superclass.constructor.call(this,config);
            this.init();
            this.formSummary();
            this.loadValoresIniciales2(this.maestro.data);
            //this.obtenerCorreo();
        },

        /*obtenerCorreo:function() {
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                // form:this.form.getForm().getEl(),
                url:'../../sis_organigrama/control/Funcionario/getEmailEmpresa',
                params:{id_funcionario: this.id_funcionario},
                success:this.successSinc,
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });


        },
        successSinc:function(resp) {
            Phx.CP.loadingHide();
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            if(reg.ROOT.datos.resultado!='falla'){
                if(!reg.ROOT.datos.email_notificaciones_2){

                    alert('Confgure el EMAIL de notificaciones 1, en el archivo de datos generales');
                }

                this.getComponente('email').setValue(reg.ROOT.datos.email_notificaciones_2);
                this.getComponente('email_cc').setValue(reg.ROOT.datos.email_empresa);

            }else{
                alert(reg.ROOT.datos.mensaje)
            }
        },*/
        /*onReloadPage:function(m){
            this.maestro=m;
            this.store.baseParams = {id_anorma: this.maestro.id_anorma};
            console.log('maestro',this.maestro);
            //Ext.apply(this.Cmp.id_centro_costo.store.baseParams,{id_gestion: this.maestro.id_gestion});
            this.load({params:{start:0, limit:50}});
            // Envio de parametro para hacer consulta en Punto de Norma
            this.Cmp.id_anorma.disable(true);
            this.Cmp.id_pn.store.baseParams.id_norma = this.maestro.id_norma;
        },
        loadValoresIniciales: function () {
            this.Cmp.id_anorma.setValue(this.maestro.id_anorma);
            Phx.vista.AuditoriaNpn.superclass.loadValoresIniciales.call(this);
        },*/
        loadValoresIniciales2:function(ms) {
            var data = ms;
            //var v_date = data.fecha_prev_inicio;
            //var fecha = (v_date.getDay()+1)+"-"+(v_date.getMonth()+1)+"-"+v_date.getFullYear();
            //var content_summary = "";

            if(data.estado_wf == 'vob_informe'){
                this.Cmp.recomendacion.readOnly = true;
            }
            if(data.estado_wf == 'plani_aprob' || data.estado_wf == 'ejecutada' || data.estado_wf == 'informe'){
                this.Cmp.recomendacion.readOnly = false;
            }

            if(data.recomendacion == '' || data.recomendacion == null){
                this.Cmp.recomendacion.setValue(this.string_recomendation);
                this.Cmp.id_aom.setValue(data.id_aom);
            }
            else{
                this.Cmp.recomendacion.setValue(data.recomendacion);
                this.Cmp.id_aom.setValue(data.id_aom);
            }

        },
        /*onSubmit: function(){
            alert("Hola");
        },*/
        successSave:function(resp) {
            Phx.CP.loadingHide();
            Phx.CP.getPagina(this.idContenedorPadre).reload();
            this.panel.close();
        },

        //arrayDefaultColumHidden:['email','email_cc','asunto'],

        Atributos:[
            /*{
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_cotizacion'
            },
            type:'Field',
            form:true
        },*/

            {
                config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_solicitud'
                },
                type:'Field',
                form:true
            },{
                config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_aom'
                },
                type:'Field',
                form:true
            },
            {
                config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'estado'
                },
                type:'Field',
                form:true
            },
            {
                config:{
                    name: 'email',
                    fieldLabel: 'Destino',
                    allowBlank: true,
                    anchor: '90%',
                    gwidth: 100,
                    maxLength: 100,
                    value:'favio@kplian.com',
                    readOnly :true
                },
                type:'TextField',
                id_grupo:1,
                form:true
            },
            {
                config:{
                    name: 'email_cc',
                    fieldLabel: 'CC',
                    allowBlank: true,
                    anchor: '90%',
                    gwidth: 100,
                    maxLength: 100,
                    readOnly :true
                },
                type:'TextField',
                id_grupo:1,
                form:true
            },
            {
                config:{
                    name: 'asunto',
                    fieldLabel: 'Asunto',
                    allowBlank: true,
                    anchor: '90%',
                    gwidth: 100,
                    maxLength: 100
                },
                type:'TextField',
                id_grupo:1,
                form:true
            },
            {
                config:{
                    name: 'recomendacion',
                    fieldLabel: 'RECOMEND.',
                    anchor: '95%',
                    height: 450,
                    //height:'100%',
                },
                type:'HtmlEditor',
                //type:'TextArea',
                filters:{pfiltro:'aom.recomendacion',type:'string'},
                id_grupo:1,
                form:true
            },



        ],
        //arrayDefaultColumHidden:['email','email_cc','asunto'],
        title:'Solicitud de Compra',
        formSummary: function () {
            this.ocultarComponente(this.Cmp.email);
            this.ocultarComponente(this.Cmp.email_cc);
            this.ocultarComponente(this.Cmp.asunto);

            this.mostrarComponente(this.Cmp.recomendacion);
        }

    })
</script>