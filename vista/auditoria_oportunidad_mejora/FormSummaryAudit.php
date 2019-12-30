<?php
/**
 *@package pXP
 *@file    FormSummaryAudit.php.php
 *@author  Maximiliano Camacho
 *@date    12-09-2019
 *@description permite registrar Resumen y Recomendacion
 */
header("content-type: text/javascript; charset=UTF-8");
?>

<script>
    Phx.vista.FormSummaryAudit=Ext.extend(Phx.frmInterfaz,{
        //ActSave:'../../sis_adquisiciones/control/Solicitud/SolicitarPresupuesto',
        ActSave:'../../sis_auditoria/control/AuditoriaOportunidadMejora/insertSummary',

        string_head_inicio: "En fecha ",
        string_head_fin: " conforme al Programa Anual de Auditorias Internas de la Empresa se realizó la auditoria:",
        string_title_responsable: "El Equipo auditor estuvo conformado por:",
        string_boddy: "Se visitaron los trabajos en las estructuras 104 (Excavación); 105 (Nivelación y puesta de Grillas); 108 (Excavación) en la zona de Paracti, y levantamiento de estructuras 8 y 10 en Santibáñez." +
            "El equipo auditor pondera el compromiso y responsabilidad del personal del Area y Proceso Auditados, Asi como el personal de la Gerencia y Administración.",
        string_glosa: "Como resultado de la auditoria se encontraron oportunidades de mejora que se presentan en el Informe de No Conformidades.",

        constructor:function(config) {
            this.maestro = config;
            console.log("valor data en constructor:",this.maestro.data);
            console.log("gggggggggggggggggggggggg:",config);

            Phx.vista.FormSummaryAudit.superclass.constructor.call(this,config);
            this.init();
            this.loadValoresIniciales2(config.data);
            this.formSummary();
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
            console.log(" kkkkkkkkkkkkkkkkkkkkkk ms->",ms);
            var reg_data = ms;
            if(reg_data.estado_wf == 'vob_informe'){
                this.Cmp.resumen.readOnly = true;
            }
            if(reg_data.estado_wf == 'plani_aprob' || reg_data.estado_wf == 'ejecutada' || reg_data.estado_wf == 'informe'){
                this.Cmp.resumen.readOnly = false;
            }
            var fecha = Ext.util.Format.date(ms.fecha_prev_inicio,'d/m/Y');
            console.log("fecha_prev_inicio->",fecha);
            var summary_team_resp = "";
            var content_summary = "";
            console.log("[id_responsable, desc_funcionario]-->","("+reg_data.id_funcionario+","+reg_data.desc_funcionario1+")");

            if(reg_data.id_funcionario == null || reg_data.desc_funcionario1 == ""){
                if(reg_data.requiere_programacion == "0" && reg_data.requiere_formulario == "0"){

                    content_summary = this.string_head_inicio + '<b>'+ fecha +'</b>'+ this.string_head_fin+'<br><br>' ;
                    content_summary+= 'Titulo: <b>'+reg_data.nombre_aom1 +'</b><br><br>';
                    content_summary+= 'CONTENIDO.-<br><br>##' + this.string_boddy + '##<br><br>';
                    content_summary+= 'CONCLUSION.-<br><br>##' + this.string_glosa + '##<br><br>';
                    //if(reg_data.resumen == '' || reg_data.resumen == null){
                        this.Cmp.resumen.setValue(content_summary);
                        this.Cmp.id_aom.setValue(reg_data.id_aom);
                    //}
                    /*else{
                        this.Cmp.resumen.setValue(reg_data.resumen);
                        this.Cmp.id_aom.setValue(reg_data.id_aom);
                    }*/
                }
                else{
                    if(reg_data.requiere_programacion == "1" && reg_data.requiere_formulario == "1"){
                        console.log("Entra RQ",reg_data.requiere_programacion);
                        this.string_head_inicio = "Fecha de Reunion: ";
                        var temario = "1. Temario 1<br>"+"2. Temario 2<br>"+"3. Temario 3<br>"+"4. Tem .....<br>"+"5. Conclusiones<br><br>";
                        var analisis_seguiento = "1. Analisis y Seguiento 1<br>"+"2. Analisis y Seguiento 2<br><br>"
                        //alert("Hola Soy OM",reg_data.id_funcionario + data.desc_funcionario1);
                        content_summary = '<b>'+this.string_head_inicio+'</b>'+ fecha +'<br>' ;
                        content_summary+= '<b>Lugar: </b>'+reg_data.lugar +'<br>';
                        content_summary+= '<b>Convocada por: </b>'+reg_data.nombre_gconsultivo+'<br>';
                        content_summary+= '<b>Participantes:</b>' +" ---, ---, ---, ..., etc"+ '<br><br>';
                        content_summary+= '<b>Temario:</b><br>'+temario+ '<br>';
                        content_summary+= '<b>Analisis y Seguimiento:</b><br>' +analisis_seguiento+ '<br>';

                        if(reg_data.formulario_ingreso == '' || reg_data.formulario_ingreso == null){
                            this.Cmp.resumen.setValue(content_summary);
                            this.Cmp.id_aom.setValue(reg_data.id_aom);
                        }
                        else{
                            this.Cmp.resumen.setValue(reg_data.resumen);
                            this.Cmp.id_aom.setValue(reg_data.id_aom);
                        }
                    }
                    else{
                        //console.log("caso especial");
                        if(reg_data.formulario_ingreso == '' || reg_data.formulario_ingreso == null){
                            this.Cmp.resumen.setValue(content_summary);
                            this.Cmp.id_aom.setValue(reg_data.id_aom);
                        }
                        else{
                            this.Cmp.resumen.setValue(reg_data.resumen);
                            this.Cmp.id_aom.setValue(reg_data.id_aom);
                        }
                    }
                }
            }
            else{
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/EquipoResponsable/listarEquipoResponsable',
                    params:{start:0, limit:50,id_aom: reg_data.id_aom},
                    dataType:"JSON",
                    success:function (resp) {
                        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                        //var summary_team_resp = "";
                        //var content_summary = "";
                        if(reg.datos.length>0){
                            /*console.log("id_aom->",reg);
                            console.log("id_aom->",reg.datos.length);
                            console.log("codigo aom->",reg.datos[0].id_aom);*/
                            console.log("codigo aom->",reg.datos[0].desc_funcionario1);

                            for(var i = 0; i < reg.datos.length; i++){
                                summary_team_resp = summary_team_resp +"-"+reg.datos[i].desc_funcionario1+"<br>";
                            }
                            //console.log("valor del resumen .....>",reg_data.resumen);
                            content_summary = this.string_head_inicio + '<b>'+ fecha +'</b>'+ this.string_head_fin+'<br><br>' ;
                            content_summary+= 'Titulo: <b>'+reg_data.nombre_aom1 +'</b><br><br>';
                            content_summary+= this.string_title_responsable + '</b><br><br>';
                            content_summary+= summary_team_resp + '</b><br><br>';
                            content_summary+= 'CONTENIDO.-<br><br>' + this.string_boddy + '<br><br>';
                            content_summary+= 'CONCLUSION.-<br><br>' + this.string_glosa + '<br><br>';

                            if(reg_data.resumen == '' || reg_data.resumen == null){
                                this.Cmp.resumen.setValue(content_summary);
                                this.Cmp.id_aom.setValue(reg_data.id_aom);
                            }
                            else{
                                this.Cmp.resumen.setValue(reg_data.resumen);
                                this.Cmp.id_aom.setValue(reg_data.id_aom);
                            }

                        }
                        else{
                            console.log("No tiene asignado el responsable al Auditoria");
                        }

                    },
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
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
        //labelSubmit: '<i class="fa fa-check"></i> Aplicar Filtro',
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
                    name: 'resumen',
                    fieldLabel: 'RESÚMEN',
                    anchor: '95%',
                    height: 450,
                    //useClearIcon : false,
                    readOnly: false
                    //height:'100%',
                },
                type:'HtmlEditor',
                //type:'TextArea',
                filters:{pfiltro:'aom.resumen',type:'string'},
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

            this.mostrarComponente(this.Cmp.resumen);
        }

    })
</script>