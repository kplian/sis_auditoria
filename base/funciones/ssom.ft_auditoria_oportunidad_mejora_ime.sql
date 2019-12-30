CREATE OR REPLACE FUNCTION ssom.ft_auditoria_oportunidad_mejora_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
  RETURNS varchar AS
$body$
  /**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_auditoria_oportunidad_mejora_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tauditoria_oportunidad_mejora'
   AUTOR: 		 (max.camacho)
   FECHA:	        17-07-2019 17:41:55
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				17-07-2019 17:41:55								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tauditoria_oportunidad_mejora'
   #
   ***************************************************************************/

DECLARE

  v_nro_requerimiento    	integer;
  v_parametros           	record;
  v_id_requerimiento     	integer;
  v_resp		            varchar;
  v_nombre_funcion        text;
  v_mensaje_error         text;
  v_id_aom				integer;
  v_id_aom2				integer;
  v_id_nc2				integer;


  v_id_aom_delete 		integer;
  v_resp_record			record;

  v_codigo_tpo_aom 		varchar;
  v_bandera1              integer;
  v_bandera2              integer;
  v_responsable           integer;
  v_id_equipo_responsable integer;
  v_parametro_aom         record;
  v_modificado            boolean;
  v_array_aux varchar[];
  v_indice 				integer;

  v_id_usuario			integer;
  p_id_usuario_ai 		integer;
  p_usuario_ai 			varchar;

  v_resumen 				text;

  v_id_parametro			integer;
  v_codigo_parametro		varchar;

  --variables para cambio de siguiente estado automatico
  va_id_tipo_estado 		integer[];
  va_codigo_estado 		varchar[];
  va_disparador    		varchar[];
  va_regla         		varchar[];
  va_prioridad     		integer[];
  v_registros				record;
  v_cantidad				integer;
  v_cant_process			integer;
  v_cant_team_resp		integer;
  v_cant_norma			integer;
  v_cant_task				integer;

  v_registros_nc        record;
  v_cant_asig_nc          integer;
  v_cant_asig_crev    	integer;
  v_cant_asig_pnnc		integer;
  v_cant_asig_sinc		integer;


  --variables wf
  v_id_proceso_macro      integer;
  v_num_tramite          varchar;
  v_codigo_tipo_proceso   varchar;
  v_fecha                 date;
  v_codigo_estado         varchar;
  v_id_proceso_wf         integer;
  v_id_estado_wf          integer;
  v_id_gestion            integer;

  -- variables de sig y ant estado de Wf
  v_id_tipo_estado        integer;
  v_codigo_estado_siguiente    varchar;
  v_id_depto              integer;
  v_obs                   varchar;
  v_acceso_directo        varchar;
  v_clase                 varchar;
  v_codigo_estados        varchar;
  v_id_cuenta_bancaria    integer;
  v_id_depto_lb           integer;
  v_parametros_ad         varchar;
  v_tipo_noti             varchar;
  v_titulo                varchar;
  v_id_estado_actual      integer;
  v_registros_proc        record;
  v_codigo_tipo_pro       varchar;
  v_id_usuario_reg        integer;
  v_id_estado_wf_ant       integer;
  v_id_funcionario        integer;

BEGIN

  v_nombre_funcion = 'ssom.ft_auditoria_oportunidad_mejora_ime';
  v_parametros = pxp.f_get_record(p_tabla);

  /*********************************
   #TRANSACCION:  'SSOM_AOM_INS'
   #DESCRIPCION:	Insercion de registros
   #AUTOR:		max.camacho
   #FECHA:		17-07-2019 17:41:55
  ***********************************/

  if(p_transaccion='SSOM_AOM_INS')then
    v_bandera1 = pxp.f_get_variable_global('ssom_auditoria');
    v_bandera2 = pxp.f_get_variable_global('ssom_oportunidad_mejora');
    begin

      --Obtener la gestion actual (sirve para wf)

      select
        g.id_gestion,
        g.gestion
        into
          --v_rec_gestion
          v_id_gestion
      from param.tgestion g
      where g.gestion = EXTRACT(YEAR FROM current_date);

      --Obtener el codigo del proceso macro y id proceso (sirve para wf)

      select
        tp.codigo,
        pm.id_proceso_macro
        into
          v_codigo_tipo_proceso,
          v_id_proceso_macro
      from  wf.tproceso_macro pm
              inner join wf.ttipo_proceso tp on tp.id_proceso_macro = pm.id_proceso_macro
      where pm.codigo='SAOM' and tp.estado_reg = 'activo' and tp.inicio = 'si';

      If v_id_proceso_macro is NULL THEN
        raise exception 'El proceso macro  de codigo % no esta configurado en el sistema WF',v_codigo_tipo_proceso;
      END IF;
      --v_id_funcionario = 699;

      --generar nro de tramite usando funcion de wf (sirve para wf)

      --raise EXCEPTION 'Llega...';
      select
        ps_num_tramite,
        ps_id_proceso_wf ,
        ps_id_estado_wf ,
        ps_codigo_estado
        into
          v_num_tramite,
          v_id_proceso_wf,
          v_id_estado_wf,
          v_codigo_estado
      from wf.f_inicia_tramite(
               p_id_usuario,
               v_parametros._id_usuario_ai,
               v_parametros._nombre_usuario_ai,
               v_id_gestion,
               v_codigo_tipo_proceso,
               v_id_funcionario,
               NULL,
               'Inicio de Seguimiento de Auditorias',
               '',
               null);

      --Sentencia de la insercion
      insert into ssom.tauditoria_oportunidad_mejora(
        id_proceso_wf,
        nro_tramite_wf,
        resumen,
        id_funcionario,
        fecha_prog_inicio,
        recomendacion,
        id_uo,
        id_gconsultivo,
        fecha_prev_inicio,
        fecha_prev_fin,
        fecha_prog_fin,
        descrip_aom2,
        nombre_aom1,
        documento,
        estado_reg,
        estado_wf,
        id_tobjeto,
        id_estado_wf,
        id_tnorma,
        fecha_eje_inicio,
        codigo_aom,
        id_tipo_auditoria,
        descrip_aom1,
        lugar,
        id_tipo_om,
        formulario_ingreso,
        estado_form_ingreso,
        fecha_eje_fin,
        nombre_aom2,
        id_usuario_ai,
        fecha_reg,
        usuario_ai,
        id_usuario_reg,
        id_usuario_mod,
        fecha_mod
      ) values(
                v_id_proceso_wf,
                v_num_tramite,
                v_resumen,
                v_parametros.id_funcionario,
                v_parametros.fecha_prog_inicio,
                v_parametros.recomendacion,
                v_parametros.id_uo,
                v_parametros.id_gconsultivo,
                --'Programado',
                --v_parametros.fecha_prev_inicio,
                v_parametros.fecha_prog_inicio,
                --v_parametros.fecha_prev_fin,
                v_parametros.fecha_prog_fin,
                v_parametros.fecha_prog_fin,
                v_parametros.descrip_aom2,
                v_parametros.nombre_aom1,
                v_parametros.documento,
                'activo',
                --v_parametros.estado_wf,
                v_codigo_estado,
                v_parametros.id_tobjeto,
                v_id_estado_wf,
                v_parametros.id_tnorma,
                v_parametros.fecha_eje_inicio,
                v_parametros.codigo_aom,
                v_parametros.id_tipo_auditoria,
                v_parametros.descrip_aom1,
                v_parametros.lugar,
                v_parametros.id_tipo_om,
                v_parametros.formulario_ingreso,
                v_parametros.estado_form_ingreso,
                v_parametros.fecha_eje_fin,
                v_parametros.nombre_aom2,
                v_parametros._id_usuario_ai,
                now(),
                v_parametros._nombre_usuario_ai,
                p_id_usuario,
                null,
                null

              )RETURNING id_aom into v_id_aom;
      --Raise exception 'Hola';
      --RAISE EXCEPTION 'Entra al id de insercion de EQ % %', v_parametros.id_funcionario,v_id_aom;
      if(v_id_aom > 0 and (select codigo_tpo_aom from ssom.ttipo_auditoria where id_tipo_auditoria = v_parametros.id_tipo_auditoria)='AI') then
        --RAISE EXCEPTION 'Entra al id de insercion de EQ % %', v_parametros.id_funcionario,v_id_aom;
        v_responsable = v_parametros.id_funcionario;
        v_id_usuario = p_id_usuario;
        --Sentencia de la insercion
        insert into ssom.tequipo_responsable(
          id_funcionario,
          --participacion,
          exp_tec_externo,
          id_parametro,
          obs_participante,
          estado_reg,
          id_aom,
          id_usuario_ai,
          id_usuario_reg,
          usuario_ai,
          fecha_reg,
          id_usuario_mod,
          fecha_mod
        ) values(
                  v_responsable,
                  null,
                  (select id_parametro from ssom.tparametro where codigo_parametro = 'RESP'),
                  '',
                  'activo',
                  v_id_aom,
                  v_parametros._id_usuario_ai,
                  v_id_usuario,
                  v_parametros._nombre_usuario_ai,
                  now(),
                  null,
                  null

                )RETURNING id_equipo_responsable into v_id_equipo_responsable;

      end if;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora almacenado(a) con exito (id_aom'||v_id_aom||')');
      v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_id_aom::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;

    /*********************************
     #TRANSACCION:  'SSOM_AOM_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		17-07-2019 17:41:55
    ***********************************/

  elsif(p_transaccion='SSOM_AOM_MOD')then
    begin
      --Sentencia de la modificacion

      update ssom.tauditoria_oportunidad_mejora set
                                                  id_proceso_wf = v_parametros.id_proceso_wf,
                                                  nro_tramite_wf = v_parametros.nro_tramite_wf,
                                                  resumen = v_parametros.resumen,
                                                  id_funcionario = v_parametros.id_funcionario,
                                                  fecha_prog_inicio = v_parametros.fecha_prog_inicio,
                                                  recomendacion = v_parametros.recomendacion,
                                                  id_uo = v_parametros.id_uo,
                                                  id_gconsultivo = v_parametros.id_gconsultivo,
                                                  fecha_prev_inicio = v_parametros.fecha_prev_inicio,
                                                  fecha_prev_fin = v_parametros.fecha_prev_fin,
                                                  fecha_prog_fin = v_parametros.fecha_prog_fin,
                                                  descrip_aom2 = v_parametros.descrip_aom2,
                                                  nombre_aom1 = v_parametros.nombre_aom1,
                                                  documento = v_parametros.documento,
                                                  estado_wf = v_parametros.estado_wf,
                                                  id_tobjeto = v_parametros.id_tobjeto,
                                                  id_estado_wf = v_parametros.id_estado_wf,
                                                  id_tnorma = v_parametros.id_tnorma,
                                                  fecha_eje_inicio = v_parametros.fecha_eje_inicio,
                                                  codigo_aom = v_parametros.codigo_aom,
                                                  id_tipo_auditoria = v_parametros.id_tipo_auditoria,
                                                  descrip_aom1 = v_parametros.descrip_aom1,
                                                  lugar = v_parametros.lugar,
                                                  id_tipo_om = v_parametros.id_tipo_om,
                                                  formulario_ingreso = v_parametros.formulario_ingreso,
                                                  estado_form_ingreso = v_parametros.estado_form_ingreso,
                                                  fecha_eje_fin = v_parametros.fecha_eje_fin,
                                                  nombre_aom2 = v_parametros.nombre_aom2,
                                                  id_usuario_mod = p_id_usuario,
                                                  fecha_mod = now(),
                                                  id_usuario_ai = v_parametros._id_usuario_ai,
                                                  usuario_ai = v_parametros._nombre_usuario_ai
      where id_aom=v_parametros.id_aom;

      if(v_parametros.id_funcionario is not null) then

        select
          id_parametro
             ,codigo_parametro
          into
            v_id_parametro,
            v_codigo_parametro
        from ssom.tparametro
        where codigo_parametro = 'RESP';

        update ssom.tequipo_responsable set
                                          id_funcionario = v_parametros.id_funcionario,
                                          --participacion = null,
                                          exp_tec_externo = null,
                                          id_parametro = v_id_parametro, --(select id_parametro from ssom.tparametro where codigo_parametro = 'RESP')
                                          obs_participante = (select obs_participante from ssom.tequipo_responsable where id_aom = v_parametros.id_aom and id_parametro = v_id_parametro),--(select id_parametro from ssom.tparametro where codigo_parametro = 'RESP'))
                                          id_aom = v_parametros.id_aom,
                                          id_usuario_mod = p_id_usuario,
                                          fecha_mod = now(),
                                          id_usuario_ai = v_parametros._id_usuario_ai,
                                          usuario_ai = v_parametros._nombre_usuario_ai
        where id_aom = v_parametros.id_aom and id_parametro = v_id_parametro; --(select id_parametro from ssom.tparametro where codigo_parametro = 'RESP');
      end if;
      v_modificado = false;
      if((select count(id_parametro_aom) from ssom.tparametro_aom where id_aom = v_parametros.id_aom)> 0)then
        --raise exception 'yo soy %',v_parametros.id_aom;
        --v_table_aux = select id_parametro_aom,id_aom,id_parametro from ssom.tparametro_aom where id_aom;
          v_array_aux[0] = v_parametros.id_tnorma;
          v_array_aux[1] = v_parametros.id_tobjeto;
        v_indice = 0;
        for v_parametro_aom in (select id_parametro_aom,id_aom,id_parametro from ssom.tparametro_aom where id_aom = v_parametros.id_aom ) LOOP
          update ssom.tparametro_aom set
                                       --id_aom = v_parametros.id_aom,
                                       id_parametro = v_array_aux[v_indice]::integer,
                                       obs_param_aom = null,
                                       fecha_mod = now(),
                                       id_usuario_ai = v_parametros._id_usuario_ai,
                                       usuario_ai = v_parametros._nombre_usuario_ai
          where id_parametro_aom = v_parametro_aom.id_parametro_aom;
          v_indice = v_indice + 1;
        END LOOP;
        v_modificado = true;

      end if;
      --raise exception  'id_tnorma ---> %  v_modificado %',v_parametros.id_tnorma,v_modificado;
      if(v_parametros.id_tnorma is not null and v_modificado = false) then
        insert into ssom.tparametro_aom (id_aom,id_parametro,obs_param_aom) VALUES(v_parametros.id_aom,v_parametros.id_tnorma,null);
      end if;
      if(v_parametros.id_tobjeto is not null and v_modificado = false) then
        insert into ssom.tparametro_aom (id_aom,id_parametro,obs_param_aom) VALUES(v_parametros.id_aom,v_parametros.id_tobjeto,null);
      end if;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora modificado(a)');
      v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;

    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*********************************
    #TRANSACCION:  'SSOM_AOMSR_MOD'
    #DESCRIPCION:	Modificacion de resumen de auditoria
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

  elsif(p_transaccion='SSOM_AOMSR_MOD')then
    begin
      --RAISE EXCEPTION 'valor';
      --Sentencia de la modificacion

      update ssom.tauditoria_oportunidad_mejora set
        resumen = v_parametros.resumen
        --recomendacion = v_parametros.recomendacion
      where id_aom = v_parametros.id_aom;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora modificado(a)');
      v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;
    /*********************************
    #TRANSACCION:  'SSOM_AOMRC_MOD'
    #DESCRIPCION:	Modificacion de resumen de auditoria
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

  elsif(p_transaccion='SSOM_AOMRC_MOD')then
    begin
      --RAISE EXCEPTION 'valor';
      --Sentencia de la modificacion
      update ssom.tauditoria_oportunidad_mejora set
        recomendacion = v_parametros.recomendacion
        --recomendacion = v_parametros.recomendacion
      where id_aom = v_parametros.id_aom;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora modificado(a)');
      v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;
    /*********************************
    #TRANSACCION:  'SSOM_OMARC_MOD'
    #DESCRIPCION:	Modificacion de resumen de auditoria
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

  elsif(p_transaccion='SSOM_OMARC_MOD')then
    begin
      --RAISE EXCEPTION 'valor';
      --Sentencia de la modificacion
      update ssom.tauditoria_oportunidad_mejora set
        formulario_ingreso = v_parametros.formulario_ingreso
        --recomendacion = v_parametros.recomendacion
      where id_aom = v_parametros.id_aom;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora modificado(a)');
      v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;

    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    /*********************************
    #TRANSACCION:  'SSOM_AOM_ELI'
    #DESCRIPCION:	Eliminacion de registros
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

  elsif(p_transaccion='SSOM_AOM_ELI')then

    begin
      --Sentencia de la eliminacion
      v_id_aom_delete = v_parametros.id_aom;
      delete from ssom.tauditoria_oportunidad_mejora where id_aom = v_parametros.id_aom;
      for v_resp_record in (select id_equipo_responsable from ssom.tequipo_responsable where id_aom = v_id_aom_delete) LOOP
        delete from ssom.tequipo_responsable
        where id_equipo_responsable = v_resp_record.id_equipo_responsable;
      END LOOP;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora eliminado(a)');
      v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;

    /*********************************
    #TRANSACCION:  'SSOM_ANEXT_MOD'
    #DESCRIPCION:	Modificacion de resumen de auditoria
    #AUTOR:		max.camacho
    #FECHA:		21-10-2019 17:41:55
    ***********************************/

  elsif(p_transaccion = 'SSOM_ANEXT_MOD')then

    begin
      /*select
        aom.id_aom,
        aom.id_proceso_wf,
        aom.id_estado_wf,
        aom.estado_wf
      into
        v_registros
      from ssom.tauditoria_oportunidad_mejora aom
      where aom.id_aom = v_parametros.p_id_aom ;*/

      select
        aom.id_aom
           ,aom.nro_tramite_wf
           ,aom.id_proceso_wf
           ,aom.id_estado_wf
           ,aom.estado_wf
           ,aom.resumen
           ,aom.recomendacion
           ,aom.lugar
           ,aom.id_tnorma
           ,aom.id_tobjeto
           ,aom.fecha_eje_inicio
           ,aom.fecha_eje_fin
        into
          v_registros
      from ssom.tauditoria_oportunidad_mejora aom
      where aom.id_aom = v_parametros.p_id_aom;


      if(v_registros.estado_wf = 'prog_aprob') then

        if ((v_registros.lugar is not null or v_registros.lugar <>'') and (v_registros.id_tnorma is not null or v_registros.id_tnorma <> '') and (v_registros.id_tobjeto is not null or v_registros.id_tobjeto <> '') and (v_registros.fecha_eje_inicio is not null) and (v_registros.fecha_eje_fin is not null)) then

          select count(id_aproceso) into v_cant_process from ssom.tauditoria_proceso where id_aom = v_parametros.p_id_aom;
          if(v_cant_process = 0) then
            RAISE EXCEPTION ' Para la Planificacion es necesario Asignar al menos un Proceso Auditable a la Auditoria...!!! ';
          end if;

          select count(id_equipo_responsable) into v_cant_team_resp from ssom.tequipo_responsable where id_aom = v_parametros.p_id_aom;
          if(v_cant_team_resp = 0 or v_cant_team_resp = 1) then
            RAISE EXCEPTION ' Para la Planificacion es necesario Asignar un Auiditor Lider/Responsable y al menos mas un Auditor que no sea Responsable de la Auditoria...!!! ';
          end if;

          select count(id_anpn) into v_cant_norma from ssom.tauditoria_npn where id_aom = v_parametros.p_id_aom;
          if(v_cant_norma = 0) then
            RAISE EXCEPTION ' Para la Planificacion es necesario Asignar un Puntos de Norma a la Auditoria...!!! ';
          end if;

          select count(id_cronograma) into v_cant_task from ssom.tcronograma where id_aom = v_parametros.p_id_aom;
          if(v_cant_task = 0) then
            RAISE EXCEPTION ' Para la Planificacion es necesario agregar actividad(es) a Cronograma para el proceso de la Auditoria...!!! ';
          end if;

        else
          RAISE EXCEPTION 'Para planificar es necesario llenar Datos Generales, verifique por favor...!!! %',v_parametros;
        end if;

      end if;
      --Para cambiar siguiente estado
      if(v_registros.estado_wf = 'ejecutada') then

        if ((v_registros.resumen is not null or v_registros.resumen <>'') and (v_registros.recomendacion is not null or v_registros.recomendacion <>'')) then

          select count(id_destinatario_aom) into v_cant_asig_crev from ssom.tdestinatario where id_aom = v_parametros.p_id_aom;
          if(v_cant_asig_crev = 0) then
            RAISE EXCEPTION ' El informe requiere ser asignado Auditor(es) revisor(es) de la Auditoria...!!! ';
          end if;

          /*select
          id_aom
          ,id_nc
          into
          v_cant_asig_nc
          from ssom.tno_conformidad
          where id_aom = v_parametros.p_id_aom;*/


          select count(id_nc) into v_cant_asig_nc from ssom.tno_conformidad where id_aom = v_parametros.p_id_aom;
          --raise EXCEPTION 'heeeeeeeeeeee %',v_cant_asig_nc;
          if(v_cant_asig_nc > 0) then
            --raise EXCEPTION 'llegaaaaaaa %', v_parametros.p_id_aom;
            for v_registros_nc in (select * from ssom.tno_conformidad where id_aom = v_parametros.p_id_aom order by id_nc asc ) LOOP

              select count(id_pnnc) into v_cant_asig_pnnc from ssom.tpnorma_noconformidad where id_nc = v_registros_nc.id_nc;
              if(v_cant_asig_pnnc = 0) then
                RAISE EXCEPTION ' Si Idenfico No conformidad (Hallazgo) es necesario Asignar al menos un Punto de Norma...!!! ';
              end if;

              select count(id_sinc) into v_cant_asig_sinc from ssom.tsi_noconformidad where id_nc = v_registros_nc.id_nc;
              --raise EXCEPTION 'llegaaaaaaa';
              if(v_cant_asig_sinc = 0) then
                RAISE EXCEPTION ' Si Idenfico No conformidad (Hallazgo) es necesario Asignar al menos un Sistema Integrado...!!! ';
              end if;

            END LOOP;

          end if;

        else
          RAISE EXCEPTION ' El informe requiere ser llenada Resumen y Recomendacion de la Auditoria...!!! %',v_parametros;
        end if;

      end if;

      select
        *
        into
          va_id_tipo_estado,
          va_codigo_estado,
          va_disparador,
          va_regla,
          va_prioridad
      FROM wf.f_obtener_estado_wf(v_registros.id_proceso_wf, v_registros.id_estado_wf,NULL,'siguiente');


      --raise exception '--  % ,  % ,% ',v_id_proceso_wf,v_id_estado_wf,va_codigo_estado;


      IF va_codigo_estado[2] is not null THEN
        raise exception 'El proceso de WF esta mal parametrizado,  solo admite un estado siguiente para el estado: %', v_registros.estado_wf;
      END IF;

      IF va_codigo_estado[1] is  null THEN
        raise exception 'El proceso de WF esta mal parametrizado, no se encuentra el estado siguiente,  para el estado: %', v_registros.estado_wf;
      END IF;

      v_id_usuario  = p_id_usuario;
      p_id_usuario_ai = null;
      p_usuario_ai = null;

      --estado siguiente
      v_id_estado_actual =  wf.f_registra_estado_wf(va_id_tipo_estado[1],
        --NULL,
                                                    v_parametros.p_id_funcionario,
                                                    v_registros.id_estado_wf,
                                                    v_registros.id_proceso_wf,
        --p_id_usuario,
                                                    v_id_usuario,
                                                    p_id_usuario_ai, -- id_usuario_ai
                                                    p_usuario_ai, -- usuario_ai
                                                    null,
                                                    'Auditoria Planificada');

      --Actualiza estado en la Auditoria
      update ssom.tauditoria_oportunidad_mejora set
                                                  id_estado_wf =  v_id_estado_actual,
                                                  estado_wf = va_codigo_estado[1],
                                                  id_usuario_mod=p_id_usuario,
                                                  fecha_mod=now(),
                                                  id_usuario_ai = p_id_usuario_ai,
                                                  usuario_ai = p_usuario_ai
      where id_aom  = v_registros.id_aom;

      v_resp ='Exit';
      return v_resp;

    end;

    /****************************************************
    #TRANSACCION:      'SSOM_WFBACK_IME'
    #DESCRIPCION:     Retrocede el estado proyectos
    #AUTOR:           EGS
    #FECHA:
    #ISSUE:
    ***************************************************/

  elseif( p_transaccion='SSOM_WFBACK_IME')then

    begin
      --raise exception'entra';
      --Obtenemos datos basicos
      select
        aom.id_aom,
        ewf.id_proceso_wf,
        aom.id_estado_wf,
        aom.estado_wf
        into
          v_registros_proc
      from ssom.tauditoria_oportunidad_mejora aom
             inner join wf.testado_wf ewf on ewf.id_estado_wf = aom.id_estado_wf
      where aom.id_aom = v_parametros.id_aom;

      v_id_proceso_wf = v_registros_proc.id_proceso_wf;
      select
        ps_id_tipo_estado,
        ps_id_funcionario,
        ps_id_usuario_reg,
        ps_id_depto,
        ps_codigo_estado,
        ps_id_estado_wf_ant
        into
          v_id_tipo_estado,
          v_id_funcionario,
          v_id_usuario_reg,
          v_id_depto,
          v_codigo_estado,
          v_id_estado_wf_ant
      from wf.f_obtener_estado_ant_log_wf(v_parametros.id_estado_wf);

      --Configurar acceso directo para la alarma
      v_acceso_directo = '';
      v_clase = '';
      v_parametros_ad = '';
      v_tipo_noti = 'notificacion';
      v_titulo  = 'Visto Bueno';

      if v_codigo_estado_siguiente not in('borrador','finalizado','anulado') then
        v_acceso_directo = '../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php';
        v_clase = 'AuditoriaOportunidadMejora';
        v_parametros_ad = '{filtro_directo:{campo:"aom.id_proceso_wf",valor:"'||v_id_proceso_wf::varchar||'"}}';
        v_tipo_noti = 'notificacion';
        v_titulo  = 'Visto Bueno';
      end if;


      --Registra nuevo estado
      v_id_estado_actual = wf.f_registra_estado_wf(
          v_id_tipo_estado,                --  id_tipo_estado al que retrocede
          v_id_funcionario,                --  funcionario del estado anterior
          v_parametros.id_estado_wf,       --  estado actual ...
          v_id_proceso_wf,                 --  id del proceso actual
          p_id_usuario,                    -- usuario que registra
          v_parametros._id_usuario_ai,
          v_parametros._nombre_usuario_ai,
          v_id_depto,                       --depto del estado anterior
          '[RETROCESO] '|| v_parametros.obs,
          v_acceso_directo,
          v_clase,
          v_parametros_ad,
          v_tipo_noti,
          v_titulo);
      --raise exception 'v_id_estado_actual %', v_id_estado_actual;
      if not ssom.f_fun_regreso_auditoria_wf(
          v_parametros.id_aom,
          p_id_usuario,
          v_parametros._id_usuario_ai,
          v_parametros._nombre_usuario_ai,
          v_id_estado_actual,
          v_parametros.id_proceso_wf,
          v_codigo_estado) then

        raise exception 'Error al retroceder estado';

      end if;

      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Se realizo el cambio de estado de la Auditoria)');
      v_resp = pxp.f_agrega_clave(v_resp,'operacion','cambio_exitoso');

      --Devuelve la respuesta
      return v_resp;

    end;

    /*********************************
      #TRANSACCION:      'SSOM_WFNEXT_INS'
      #DESCRIPCION:      Controla el cambio al siguiente estado
      #AUTOR:           EGS
      #FECHA:
      #ISSUE:
      ***********************************/


  elseif(p_transaccion='SSOM_WFNEXT_INS')then

    begin
      --Obtenemos datos basico

      select
        ewf.id_proceso_wf,
        aom.id_estado_wf,
        aom.estado_wf
        into
          v_id_proceso_wf,
          v_id_estado_wf,
          v_codigo_estado
      from ssom.tauditoria_oportunidad_mejora aom
             inner join wf.testado_wf ewf on ewf.id_estado_wf = aom.id_estado_wf
      where aom.id_aom = v_parametros.id_aom;

      --Recupera datos del estado
      select
        ewf.id_tipo_estado,
        te.codigo
        into
          v_id_tipo_estado,
          v_codigo_estados
      from wf.testado_wf ewf
             inner join wf.ttipo_estado te on te.id_tipo_estado = ewf.id_tipo_estado
      where ewf.id_estado_wf = v_parametros.id_estado_wf_act;

      -- obtener datos tipo estado
      select
        te.codigo
        into
          v_codigo_estado_siguiente
      from wf.ttipo_estado te
      where te.id_tipo_estado = v_parametros.id_tipo_estado;

      if pxp.f_existe_parametro(p_tabla,'id_depto_wf') then
        v_id_depto = v_parametros.id_depto_wf;
      end if;

      if pxp.f_existe_parametro(p_tabla,'obs') then
        v_obs=v_parametros.obs;
      else
        v_obs='---';
      end if;

      --Acciones por estado siguiente que podrian realizarse
      if v_codigo_estado_siguiente in ('') then
      end if;

      ---------------------------------------
      -- REGISTRA SIGUIENTE ESTADO DEL WF
      ---------------------------------------
      --Configurar acceso directo para la alarma
      v_acceso_directo = '';
      v_clase = '';
      v_parametros_ad = '';
      v_tipo_noti = 'notificacion';
      v_titulo  = 'VoBo';

      --raise exception 'v_codigo_estado_siguiente %',v_codigo_estado_siguiente;
      if v_codigo_estado_siguiente not in('programado') then
        v_acceso_directo = '../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php';
        v_clase = 'Licencia';
        v_parametros_ad = '{filtro_directo:{campo:"aom.id_proceso_wf",valor:"'||v_id_proceso_wf::varchar||'"}}';
        v_tipo_noti = 'notificacion';
        v_titulo  = 'VoBo';
      end if;
      v_id_estado_actual = wf.f_registra_estado_wf(
          v_parametros.id_tipo_estado,
          v_parametros.id_funcionario_wf,
          v_parametros.id_estado_wf_act,
          v_id_proceso_wf,
          p_id_usuario,
          v_parametros._id_usuario_ai,
          v_parametros._nombre_usuario_ai,
          v_id_depto,                       --depto del estado anterior
          v_obs,
          v_acceso_directo,
          v_clase,
          v_parametros_ad,
          v_tipo_noti,
          v_titulo );


      --raise exception 'v_id_estado_actual %',v_id_estado_actual;
      --------------------------------------
      -- Registra los procesos disparados
      --------------------------------------
      for v_registros_proc in ( select * from json_populate_recordset(null::wf.proceso_disparado_wf, v_parametros.json_procesos::json)) loop

        --Obtencion del codigo tipo proceso
        select
          tp.codigo
          into
            v_codigo_tipo_pro
        from wf.ttipo_proceso tp
        where tp.id_tipo_proceso =  v_registros_proc.id_tipo_proceso_pro;

        --Disparar creacion de procesos seleccionados
        select
          ps_id_proceso_wf,
          ps_id_estado_wf,
          ps_codigo_estado
          into
            v_id_proceso_wf,
            v_id_estado_wf,
            v_codigo_estado
        from wf.f_registra_proceso_disparado_wf(
                 p_id_usuario,
                 v_parametros._id_usuario_ai,
                 v_parametros._nombre_usuario_ai,
                 v_id_estado_actual,
                 v_registros_proc.id_funcionario_wf_pro,
                 v_registros_proc.id_depto_wf_pro,
                 v_registros_proc.obs_pro,
                 v_codigo_tipo_pro,
                 v_codigo_tipo_pro);

      end loop;

      if ssom.f_fun_inicio_auditoria_wf(
          v_parametros.id_aom,
          p_id_usuario,
          v_parametros._id_usuario_ai,
          v_parametros._nombre_usuario_ai,
          v_id_estado_actual,
          v_id_proceso_wf,
          v_codigo_estado_siguiente,
        --v_id_depto_lb,
        --v_id_cuenta_bancaria,
          v_codigo_estado
        ) then

      end if;
      -- si hay mas de un estado disponible  preguntamos al usuario
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Se realizo el cambio de estado del pago simple id='||v_parametros.id_aom);
      v_resp = pxp.f_agrega_clave(v_resp,'operacion','cambio_exitoso');
      -- Devuelve la respuesta
      return v_resp;
    end;


  else

    raise exception 'Transaccion inexistente: %',p_transaccion;

  end if;

  EXCEPTION

  WHEN OTHERS THEN
    v_resp='';
    v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
    v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
    v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
    raise exception '%',v_resp;

END;
$body$
  LANGUAGE 'plpgsql'
  VOLATILE
  CALLED ON NULL INPUT
  SECURITY INVOKER
  COST 100;