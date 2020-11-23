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
     #2				4/8/20202				MMV						Refactorización funciones auditoria oportunidad de mejora
     ***************************************************************************/

DECLARE

  v_parametros           	record;
  v_resp		            varchar;
  v_nombre_funcion        	text;
  v_id_aom					integer;
  v_responsable           	integer;
  v_id_usuario			    integer;
  p_id_usuario_ai 		    integer;
  p_usuario_ai 			    varchar;
  v_resumen 				text;
  v_registros				record;
  v_id_proceso_macro      integer;
  v_num_tramite           varchar;
  v_codigo_tipo_proceso   varchar;
  v_codigo_estado         varchar;
  v_id_proceso_wf         integer;
  v_id_estado_wf          integer;
  v_id_gestion            integer;

  -- variables de sig y ant estado de Wf
  v_id_tipo_estado        		integer;
  v_codigo_estado_siguiente    	varchar;
  v_id_depto              integer;
  v_obs                   varchar;
  v_acceso_directo        varchar;
  v_clase                 varchar;
  v_codigo_estados        varchar;
  v_parametros_ad         varchar;
  v_tipo_noti             varchar;
  v_titulo                varchar;
  v_id_estado_actual      integer;
  v_registros_proc        record;
  v_codigo_tipo_pro       varchar;
  v_id_usuario_reg        integer;
  v_id_estado_wf_ant      integer;
  v_id_funcionario        integer;

  v_registro_estado 	  record;

  va_id_tipo_estado 	  integer [];
  va_codigo_estado 		  varchar [];
  va_disparador 	      varchar [];
  va_regla 				  varchar [];
  va_prioridad 		      integer [];

   v_json_formularion  json;

    v_json_formulario_record		record;
    v_equipo_record			record;

    v_fecha_prog_inicio date;
    v_fecha_prev_inicio date;
    v_fecha_prev_fin 	date;
    v_fecha_prog_fin 	date;
    v_id_tobjeto 		integer;
    v_id_tnorma 		integer;
    v_lugar  			varchar;
     v_id_destinatario integer;
	v_recomendacion  varchar;
    v_id_destinatarios varchar;
    v_equipo		text;
    v_no_conformindad	record;
    v_codigo_aud		varchar;
    v_correlativo		varchar;

BEGIN

  v_nombre_funcion = 'ssom.ft_auditoria_oportunidad_mejora_ime';
  v_parametros = pxp.f_get_record(p_tabla);

  /*********************************
   #TRANSACCION:  'SSOM_AOM_INS'
   #DESCRIPCION:	Insercion de registros
   #AUTOR:		MMV
   #FECHA:		17-07-2019 17:41:55
  ***********************************/

  if(p_transaccion='SSOM_AOM_INS')then

    begin

      --Obtener la gestion actual (sirve para wf)
      select
        g.id_gestion
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
      where pm.codigo='AUD' and tp.estado_reg = 'activo' and tp.inicio = 'si';

      If v_id_proceso_macro is NULL THEN
        raise exception 'El proceso macro  de codigo % no esta configurado en el sistema WF',v_codigo_tipo_proceso;
      END IF;

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



               select tip.codigo_tpo_aom into v_codigo_aud
               from ssom.ttipo_auditoria tip
               where tip.id_tipo_auditoria  = v_parametros.id_tipo_auditoria;


               -- raise exception '%',v_codigo_aud;



      --Sentencia de la insercion
    insert into ssom.tauditoria_oportunidad_mejora( id_proceso_wf,
        											nro_tramite_wf,
    											    id_funcionario,
        											fecha_prog_inicio,
                                                    fecha_prog_fin,
        											id_uo,
                                                    nombre_aom1,
                                                    estado_reg,
                                                    estado_wf,
                                                  	id_estado_wf,
                                                    codigo_aom,
                                                    id_tipo_auditoria,
                                                    descrip_aom1,
                                                    id_tipo_om,
                                                  	id_usuario_ai,
                                                    fecha_reg,
                                                    usuario_ai,
                                                    id_usuario_reg,
                                                    id_usuario_mod,
                                                    fecha_mod,
                                                    id_gestion,
                                                    id_gconsultivo,
                                                    fecha_prev_inicio,
                                                    fecha_prev_fin,
                                                    nro_tramite
      												)values(
                                                    v_id_proceso_wf,
                                                    v_num_tramite,
                                                    v_parametros.id_funcionario,
                                                    v_parametros.fecha_prog_inicio,
                                                    v_parametros.fecha_prog_fin,
                                                    v_parametros.id_uo,
                                                    v_parametros.nombre_aom1,
                                                    'activo',
                                                    v_codigo_estado,
                                                    v_id_estado_wf,
                                                    'codigo',
                                                    v_parametros.id_tipo_auditoria,
                                                    v_parametros.descrip_aom1,
                                                    v_parametros.id_tipo_om,
                                                    v_parametros._id_usuario_ai,
                                                    now(),
                                                    v_parametros._nombre_usuario_ai,
                                                    p_id_usuario,
                                                    null,
                                                    null,
                                                    v_id_gestion,
                                                    v_parametros.id_gconsultivo,
                                                    v_parametros.fecha_prev_inicio,
                                                    v_parametros.fecha_prev_fin,
                                                    ssom.f_generar_correlativo (v_codigo_aud,
  													                            EXTRACT(YEAR FROM current_date)::integer,true)
                                                    )RETURNING id_aom into v_id_aom;



        if v_parametros.id_funcionario is not null then
              --Sentencia de la insercion
              insert into ssom.tequipo_responsable(   id_funcionario,
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
                                                      v_parametros.id_funcionario,
                                                       null,
                                                      (select id_parametro from ssom.tparametro where codigo_parametro = 'RESP'),
                                                      '',
                                                      'activo',
                                                      v_id_aom,
                                                      v_parametros._id_usuario_ai,
                                                      p_id_usuario,
                                                      v_parametros._nombre_usuario_ai,
                                                      now(),
                                                      null,
                                                      null);
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
     #AUTOR:		MMV
     #FECHA:		17-07-2019 17:41:55
    ***********************************/

  elsif(p_transaccion='SSOM_AOM_MOD')then

    begin
      --Sentencia de la modificacion

      update ssom.tauditoria_oportunidad_mejora set
      id_funcionario = v_parametros.id_funcionario,
      fecha_prog_inicio = v_parametros.fecha_prog_inicio,
      id_uo = v_parametros.id_uo,
      fecha_prev_inicio = v_parametros.fecha_prev_inicio,
      fecha_prev_fin = v_parametros.fecha_prev_fin,
      fecha_prog_fin = v_parametros.fecha_prog_fin,
      nombre_aom1 = v_parametros.nombre_aom1,
      id_tobjeto = v_parametros.id_tobjeto,
      id_tnorma = v_parametros.id_tnorma,
      fecha_eje_inicio = v_parametros.fecha_eje_inicio,
      fecha_eje_fin = v_parametros.fecha_eje_fin,
      descrip_aom1 = v_parametros.descrip_aom1,
      lugar = v_parametros.lugar,
      id_tipo_om = v_parametros.id_tipo_om,
      id_usuario_mod = p_id_usuario,
      fecha_mod = now(),
      id_usuario_ai = v_parametros._id_usuario_ai,
      usuario_ai = v_parametros._nombre_usuario_ai
      where id_aom=v_parametros.id_aom;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora modificado(a)');
      v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;

    /*********************************
    #TRANSACCION:  'SSOM_AOMSR_MOD'
    #DESCRIPCION:	Modificacion de resumen de auditoria
    #AUTOR:		MMV
    #FECHA:
    ***********************************/
	 elsif(p_transaccion='SSOM_AOMSR_MOD')then
    	 begin


          update ssom.tauditoria_oportunidad_mejora set
          recomendacion = v_parametros.recomendacion
          where id_aom = v_parametros.id_aom;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora modificado(a)');
      v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;

    /*********************************
    #TRANSACCION:  'SSOM_AOM_ELI'
    #DESCRIPCION:	Eliminacion de registros
    #AUTOR:		MMV
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

      elsif(p_transaccion='SSOM_AOM_ELI')then

        begin


            delete from ssom.tauditoria_proceso pr
            where pr.id_aom = v_parametros.id_aom;

            delete from ssom.tauditoria_npn nk
            where nk.id_aom = v_parametros.id_aom;

            delete from ssom.taom_riesgo_oportunidad oa
            where oa.id_aom = v_parametros.id_aom;

            delete from ssom.tdestinatario de
            where de.id_aom = v_parametros.id_aom;


          --Sentencia de la eliminacion
          delete from ssom.tauditoria_oportunidad_mejora
          where id_aom = v_parametros.id_aom;

          --Definicion de la respuesta
          v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora eliminado(a)');
          v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

          --Devuelve la respuesta
          return v_resp;

        end;

    /****************************************************
    #TRANSACCION:     'SSOM_WFAPRO_IME'
    #DESCRIPCION:     Retrocede el estado proyectos
    #AUTOR:           MMV
    #FECHA:			  8/7/2020
    ***************************************************/

    elseif( p_transaccion='SSOM_WFAPRO_IME') then

    begin

    -- Validar estado
	select  pw.id_proceso_wf,
            ew.id_estado_wf,
            te.codigo,
            pw.fecha_ini,
            te.id_tipo_estado,
            te.pedir_obs,
            pw.nro_tramite
          into
            v_registro_estado
          from wf.tproceso_wf pw
          inner join wf.testado_wf ew  on ew.id_proceso_wf = pw.id_proceso_wf and ew.estado_reg = 'activo'
          inner join wf.ttipo_estado te on ew.id_tipo_estado = te.id_tipo_estado
          where pw.id_proceso_wf =  v_parametros.id_proceso_wf;

    --- obtener

         select  ps_id_tipo_estado,
                 ps_codigo_estado,
                 ps_disparador,
                 ps_regla,
                 ps_prioridad
             into
                va_id_tipo_estado,
                va_codigo_estado,
                va_disparador,
                va_regla,
                va_prioridad
            from wf.f_obtener_estado_wf(
            v_registro_estado.id_proceso_wf,
             null,
             v_registro_estado.id_tipo_estado,
             'siguiente',
             p_id_usuario);

                v_acceso_directo = '';
                v_clase = '';
                v_parametros_ad = '';
                v_tipo_noti = 'notificacion';
                v_titulo  = 'Aprobado';


                 v_id_estado_actual = wf.f_registra_estado_wf(  va_id_tipo_estado[1]::integer,
                                                                null,--v_parametros.id_funcionario_wf,
                                                                v_registro_estado.id_estado_wf,
                                                                v_registro_estado.id_proceso_wf,
                                                                p_id_usuario,
                                                                v_parametros._id_usuario_ai,
                                                                v_parametros._nombre_usuario_ai,
                                                                null,--v_id_depto,                       --depto del estado anterior
                                                                'Aprobado', --obt
                                                                v_acceso_directo,
                                                                v_clase,
                                                                v_parametros_ad,
                                                                v_tipo_noti,
                                                                v_titulo);



           -- raise exception '%',va_codigo_estado[1];
       	 if va_codigo_estado[1] = 'ejecutada' then
         	select  ao.id_aom,
            		ao.fecha_prog_inicio,
                    ao.nombre_aom1,
                    ao.resumen
                   into
                   v_registros_proc
            from ssom.tauditoria_oportunidad_mejora ao
            where ao.id_proceso_wf = v_parametros.id_proceso_wf;

            if (v_registros_proc.resumen is null or v_registros_proc.resumen = '') then
            v_equipo := '';
            for v_equipo_record in (select fun.desc_funcionario1
                                from ssom.tequipo_responsable re
                                inner join orga.vfuncionario fun on fun.id_funcionario = re.id_funcionario
                                where re.id_aom = v_registros_proc.id_aom)loop

               v_equipo := v_equipo || '<li>'||v_equipo_record.desc_funcionario1||'</li> ' ;

              end loop;

  v_resumen = '<div>
                <p>En fecha '||to_char( v_registros_proc.fecha_prog_inicio,'DD/MM/YYYY')||', conforme al Programa Anual de Auditorias Internas de la Empresa se realizó la auditoria:</p>
                <p>"'||v_registros_proc.nombre_aom1||'"</p>
                <p>El Equipo auditor estuvo conformado por:</p>
                <ul>
                    '||v_equipo||'
                </ul>
                <p>El equipo auditor pondera el compromiso y responsabilidad del personal del Area y Proceso Auditados, Asi como el personal de la Gerencia y Administración. </p>
                <p>Como resultado de la auditoria se encontraron oportunidades de mejora que se presentan en el Informe de No Conformidades 4-R-010 anexo.</p>
              </div>';
  				update ssom.tauditoria_oportunidad_mejora set
                      id_estado_wf =  v_id_estado_actual,
                      estado_wf = va_codigo_estado[1],
                      id_usuario_mod=p_id_usuario,
                      fecha_mod=now(),
                      id_usuario_ai = p_id_usuario_ai,
                      resumen = v_resumen,
                      usuario_ai = p_usuario_ai
                     where id_proceso_wf  = v_parametros.id_proceso_wf;

        	end if;
       end if;


          /*    if va_codigo_estado[1] = 'notificar_responsable' then


       		select  ao.id_aom
                   into
                   v_registros_proc
            from ssom.tauditoria_oportunidad_mejora ao
            where ao.id_proceso_wf = v_parametros.id_proceso_wf;

            	for v_no_conformindad in (select  nc.id_nc,
                                          nc.id_proceso_wf,
                                          nc.id_estado_wf
                                  from ssom.tno_conformidad nc
                                  where nc.id_aom = v_registros_proc.id_aom)loop

            		if ssom.f_cambiar_estado_no_conformidad(v_no_conformindad.id_proceso_wf,
                                                                  v_no_conformindad.id_estado_wf,
                                                                  p_id_usuario ,
                                                                  'revisar') then

     			 		end if;

                end loop;



              end if;*/

       --raise exception '%',va_codigo_estado;

       if va_codigo_estado[1] = 'curso' then

       		select  ao.id_aom,
            		ao.fecha_prog_inicio,
                    ao.nombre_aom1,
                    ao.resumen
                   into
                   v_registros_proc
            from ssom.tauditoria_oportunidad_mejora ao
            where ao.id_proceso_wf = v_parametros.id_proceso_wf;


       	for v_no_conformindad in (select  nc.id_nc,
                                          nc.id_proceso_wf,
                                          nc.id_estado_wf,
                                          nc.revisar,
                                          nc.rechazar
                                  from ssom.tno_conformidad nc
                                  where nc.id_aom = v_registros_proc.id_aom)loop

        					if ssom.f_cambiar_estado_no_conformidad(v_no_conformindad.id_proceso_wf,
                                                                    v_no_conformindad.id_estado_wf,
                                                                    p_id_usuario,
                                                                    v_no_conformindad.revisar,
                                                                    v_no_conformindad.rechazar) then
                            end if;

       	end loop;

       end if;

       update ssom.tauditoria_oportunidad_mejora set
        id_estado_wf =  v_id_estado_actual,
        estado_wf = va_codigo_estado[1],
        id_usuario_mod=p_id_usuario,
        fecha_mod=now(),
        id_usuario_ai = p_id_usuario_ai,
        usuario_ai = p_usuario_ai
       where id_proceso_wf  = v_parametros.id_proceso_wf;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Exito');
      v_resp = pxp.f_agrega_clave(v_resp,'id_proceso_wf',v_parametros.id_proceso_wf::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;
    /****************************************************
    #TRANSACCION:      'SSOM_WFBACK_IME'
    #DESCRIPCION:     Retrocede el estado proyectos
    #AUTOR:           EGS
    #FECHA:			  8/7/2020
    ***************************************************/

  elseif( p_transaccion='SSOM_WFBACK_IME')then

    begin

     select
        aom.id_aom,
        ewf.id_proceso_wf,
        aom.id_estado_wf,
        aom.estado_wf
        into
          v_registros_proc
      from ssom.tauditoria_oportunidad_mejora aom
             inner join wf.testado_wf ewf on ewf.id_estado_wf = aom.id_estado_wf
      where aom.id_proceso_wf = v_parametros.id_proceso_wf;

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


      if not ssom.f_fun_regreso_auditoria_wf(
          v_registros_proc.id_aom,
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
      #FECHA:			 8/7/2020
      ***********************************/

  elseif(p_transaccion='SSOM_WFNEXT_INS')then

    begin
      --Obtenemos datos basico

      select
      aom.id_aom,
        ewf.id_proceso_wf,
        aom.id_estado_wf,
        aom.estado_wf
        into
        v_id_aom,
          v_id_proceso_wf,
          v_id_estado_wf,
          v_codigo_estado
      from ssom.tauditoria_oportunidad_mejora aom
             inner join wf.testado_wf ewf on ewf.id_estado_wf = aom.id_estado_wf
      where aom.id_proceso_wf = v_parametros.id_proceso_wf_act;

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

      v_acceso_directo = '';
      v_clase = '';
      v_parametros_ad = '';
      v_tipo_noti = 'notificacion';
      v_titulo  = 'VoBo';

      v_id_estado_actual = wf.f_registra_estado_wf( v_parametros.id_tipo_estado,
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
                                                    v_titulo);
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


      if ssom.f_fun_inicio_auditoria_wf(  v_id_aom,
       									  p_id_usuario,
                                          v_parametros._id_usuario_ai,
                                          v_parametros._nombre_usuario_ai,
                                          v_id_estado_actual,
                                          v_id_proceso_wf,
                                          v_codigo_estado_siguiente,
                                          v_codigo_estado
                                        ) then

      end if;
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Se realizo el cambio de estado del pago simple id='||v_id_proceso_wf::varchar);
      v_resp = pxp.f_agrega_clave(v_resp,'operacion','cambio_exitoso');
      -- Devuelve la respuesta
      return v_resp;
    end;

    /*********************************
     #TRANSACCION:  'SSOM_PLA_IME'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		MMV
     #FECHA:		17-07-2019 17:41:55
    ***********************************/

  elsif(p_transaccion='SSOM_PLA_IME')then
    begin

      --Sentencia de la modificacion

       select 	au.id_aom,
       			au.id_estado_wf,
                au.id_proceso_wf,
                au.estado_wf
                into
                v_registros_proc
       from ssom.tauditoria_oportunidad_mejora au
       where au.id_aom = v_parametros.id_aom;

       v_json_formularion =  v_parametros.arratFormulario::json;

       if (exists(select 1
                   from ssom.tauditoria_oportunidad_mejora au
                   where au.id_aom = v_parametros.id_aom))then


       for v_json_formulario_record in (select json_array_elements(v_json_formularion))loop

        v_fecha_prog_inicio  = v_json_formulario_record.json_array_elements::json->>'fecha_prog_inicio';
        v_fecha_prev_inicio  = v_json_formulario_record.json_array_elements::json->>'fecha_prev_inicio';
        v_fecha_prev_fin =  v_json_formulario_record.json_array_elements::json->>'fecha_prev_fin';
        v_fecha_prog_fin = v_json_formulario_record.json_array_elements::json->>'fecha_prog_fin';
        v_id_tobjeto = v_json_formulario_record.json_array_elements::json->>'id_tobjeto';
        v_id_tnorma  = v_json_formulario_record.json_array_elements::json->>'id_tnorma';
        v_lugar  = v_json_formulario_record.json_array_elements::json->>'lugar';

		v_id_destinatario = null;
        v_resumen  = null;
		v_recomendacion  = null;


			 if v_parametros.informe = 'si' then

             		v_id_destinatario = v_json_formulario_record.json_array_elements::json->>'id_destinatario';
                    v_recomendacion  = v_json_formulario_record.json_array_elements::json->>'recomendacion';
        			v_id_destinatarios =   v_json_formulario_record.json_array_elements::json->>'id_destinatarios';



             		update ssom.tauditoria_oportunidad_mejora set
                    id_destinatario =  v_id_destinatario,
                    resumen = v_parametros.resumen,
                    recomendacion = v_parametros.recomendacion,
                    id_usuario_mod = p_id_usuario,
                    fecha_mod = now()
                    where id_aom=v_parametros.id_aom;

             		delete from ssom.tdestinatario  dd
                    where dd.id_aom = v_parametros.id_aom;

             foreach v_id_funcionario IN  array (string_to_array(v_id_destinatarios,','))  loop

                --Sentencia de la insercion
               	insert into ssom.tdestinatario(
				id_aom,
				id_funcionario,
				estado_reg,
				id_usuario_ai,
				fecha_reg,
				usuario_ai,
				id_usuario_reg,
				fecha_mod,
				id_usuario_mod
                ) values(
                  v_parametros.id_aom,
                  v_id_funcionario,
                  'activo',
                  v_parametros._id_usuario_ai,
                  now(),
                  v_parametros._nombre_usuario_ai,
                  p_id_usuario,
                  null,
                  null
         		  );
            end loop;

             else
             		update ssom.tauditoria_oportunidad_mejora set
                      fecha_prog_inicio = v_fecha_prog_inicio ,
                      fecha_prev_inicio = v_fecha_prev_inicio,
                      fecha_prev_fin = v_fecha_prev_fin,
                      fecha_prog_fin = v_fecha_prog_fin,
                      id_tobjeto = v_id_tobjeto,
                      id_tnorma = v_id_tnorma,
                      lugar = v_lugar,
                      id_usuario_mod = p_id_usuario,
                      fecha_mod = now()
                    where id_aom=v_parametros.id_aom;
             end if;



       end loop;

       if (v_registros_proc.estado_wf = 'aprobado_responsable') then

       			 if ssom.f_cambiar_estado(v_registros_proc.id_proceso_wf,
             						  v_registros_proc.id_estado_wf,
                                      p_id_usuario ) then

     			 end if;

       end if;

       else

       	raise exception 'Huvo un error Wen...!';

       end if;



      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria - Oportunidad Mejora modificado(a)');
      v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

      --Devuelve la respuesta
      return v_resp;

    end;
    /*********************************
 	#TRANSACCION:  'SSOM_GETPRO_IME'
 	#DESCRIPCION:	Recuperar datos proceso
 	#AUTOR:		MMV
 	#FECHA:		13/7/2020
	***********************************/

	elsif(p_transaccion='SSOM_GETPRO_IME')then

		begin

            select pr.id_proceso into v_registros
            from ssom.tauditoria_proceso pr
            where pr.id_aom = v_parametros.id_aom;

            -- raise exception '%',v_registros.id_proceso;
            --Definicion de la respuesta
             v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Datos de decuentos recuperados con exito');
             v_resp = pxp.f_agrega_clave(v_resp,'id_proceso',v_registros.id_proceso::varchar);

            --Devuelve la respuesta
            return v_resp;

	end;

      /*********************************
 	#TRANSACCION:  'SSOM_CORREL_IME'
 	#DESCRIPCION:	Generara correlativo
 	#AUTOR:		MMV
 	#FECHA:		4/11/2020
	***********************************/

	elsif(p_transaccion='SSOM_CORREL_IME')then

		begin


             select tip.codigo_tpo_aom into v_codigo_aud
             from ssom.ttipo_auditoria tip
        	 where tip.id_tipo_auditoria  = v_parametros.id_tipo_auditoria;

       	     v_correlativo = ssom.f_generar_correlativo (v_codigo_aud, EXTRACT(YEAR FROM current_date)::integer,false);

            --Definicion de la respuesta
             v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Datos de decuentos recuperados con exito');
             v_resp = pxp.f_agrega_clave(v_resp,'correlativo',v_correlativo::varchar);

            --Devuelve la respuesta
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
PARALLEL UNSAFE
COST 100;

ALTER FUNCTION ssom.ft_auditoria_oportunidad_mejora_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;