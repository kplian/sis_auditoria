CREATE OR REPLACE FUNCTION ssom.ft_accion_propuesta_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_accion_propuesta_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.taccion_propuesta'
 AUTOR: 		 (szambrana)
 FECHA:	        04-07-2019 22:32:50
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				04-07-2019 22:32:50								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.taccion_propuesta'
 #3				04-08-2020 19:53:16								Refactorización No Conformidad
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_ap					integer;

    --variables adcionales para el wf
    v_rec_gestion 			record;
    v_codigo_tipo_proceso	varchar;
    v_id_proceso_macro  	integer;

    --declaracion de variables para el wf
	v_nro_tramite			varchar;	--integrar con wf new
    v_id_proceso_wf			integer; 	--integrar con wf new
    v_id_estado_wf			integer; 	--integrar con wf new
    v_codigo_estado			varchar; 	--integrar con wf new

    v_record				record; 	--almacenar los datos del registro selecionadio : cambiar estados
    v_id_tipo_estado		integer;
    v_pedir_obs				varchar;
    v_codigo_estado_siguiente	varchar;
    v_id_depto     			integer;
    v_obs					varchar;

    v_acceso_directo 		varchar;
    v_clase 				varchar;
    v_parametros_ad 		varchar;
    v_tipo_noti 			varchar;
    v_titulo  				varchar;
    v_id_estado_actual    	integer;

    --declaracion variables para el boton atras
	v_operacion				varchar;
    v_id_funcionario		integer;
    v_nombre_funcionario	varchar;
    v_id_usuario_reg		integer;
    v_id_estado_wf_ant		integer;
    v_id_mes_trabajo_con	integer; --#4
    v_fecha_ini				date;
    v_fecha_fin				date;
    v_fechas_validas 		boolean;
    v_aceptar				varchar;

  va_id_tipo_estado 	  integer [];
    va_codigo_estado 		  varchar [];
    va_disparador 	      varchar [];
    va_regla 				  varchar [];
    va_prioridad 		      integer [];
    v_registro_estado			record;
    v_record_accion				record;


    v_estado_new			varchar;
    v_id_estado_new			integer;

BEGIN

    v_nombre_funcion = 'ssom.ft_accion_propuesta_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_ACCPRO_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 22:32:50
	***********************************/

	if(p_transaccion='SSOM_ACCPRO_INS')then

        begin

        --raise exception '%',v_parametros.nro_tramite_padre;

            ---Obtener la gestion actual (sirve para wf)
        	select
            	g.id_gestion,
           		g.gestion
            into
                v_rec_gestion
            from param.tgestion g
            where g.gestion = EXTRACT(YEAR FROM current_date);

			select
            	tp.codigo,
           		pm.id_proceso_macro
            	into
                v_codigo_tipo_proceso,
                v_id_proceso_macro
           	from  wf.tproceso_macro pm
           	inner join wf.ttipo_proceso tp on tp.id_proceso_macro = pm.id_proceso_macro
			where  pm.codigo='AUD' and tp.estado_reg = 'activo' --and tp.inicio = 'no'
            and tp.codigo = 'ACCP';

        	--- generar nro de tramite usando funcion de wf (sirve para wf)

         	select
				ps_num_tramite ,
                ps_id_proceso_wf ,
                ps_id_estado_wf ,
                ps_codigo_estado
            	into
                v_nro_tramite,
                v_id_proceso_wf,
                v_id_estado_wf,
                v_codigo_estado
        	from wf.f_inicia_tramite(
                p_id_usuario,
                v_parametros._id_usuario_ai,
                v_parametros._nombre_usuario_ai,
                v_rec_gestion.id_gestion,
                v_codigo_tipo_proceso,
                NULL,
                NULL,
                'Accion propuesta',
                v_codigo_tipo_proceso,
                v_parametros.nro_tramite_padre);
                --Condicion para fechas utilizamos la funcion overlaps
				v_fechas_validas = (select( v_parametros.fecha_inicio_ap::date, v_parametros.fecha_inicio_ap::date) overlaps
									      ( v_parametros.fecha_inicio_ap::date, v_parametros.fecha_fin_ap::date));

            if not v_fechas_validas then
        		raise exception 'La fecha final debe ser igual o mayor a la fecha inicial';
            end if;



        	--Sentencia de la insercion
        	insert into ssom.taccion_propuesta(
                obs_resp_area,
                descripcion_ap,
                id_parametro,
                id_funcionario,
                descrip_causa_nc,
                estado_reg,
                efectividad_cumpl_ap,
                fecha_fin_ap,
                obs_auditor_consultor,
                id_nc,
                fecha_inicio_ap,
                id_usuario_ai,
                id_usuario_reg,
                usuario_ai,
                fecha_reg,
                id_usuario_mod,
                fecha_mod,
                id_proceso_wf,	--integrar con wf new
                id_estado_wf,	--integrar con wf new
                nro_tramite, 	--integrar con wf new
                estado_wf, 		--integrar con wf new
                codigo_ap
          	) values(
                v_parametros.obs_resp_area,
                v_parametros.descripcion_ap,
                v_parametros.id_parametro,
                null, --v_parametros.id_funcionario,
                v_parametros.descrip_causa_nc,
                'activo',
                v_parametros.efectividad_cumpl_ap,
                v_parametros.fecha_fin_ap,
                v_parametros.obs_auditor_consultor,
                v_parametros.id_nc,
                v_parametros.fecha_inicio_ap,
                v_parametros._id_usuario_ai,
                p_id_usuario,
                v_parametros._nombre_usuario_ai,
                now(),
                null,
                null,
                v_id_proceso_wf,	--integrar con wf new
                v_id_estado_wf,		--integrar con wf new
                v_nro_tramite,		--integrar con wf new
                v_codigo_estado,	--integrar con wf new
                ssom.f_generar_correlativo('ACCPRO', EXTRACT(YEAR FROM current_date)::integer)
			)RETURNING id_ap into v_id_ap;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Acciones Propuestas almacenado(a) con exito (id_ap'||v_id_ap||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ap',v_id_ap::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_ACCPRO_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 22:32:50
	***********************************/

	elsif(p_transaccion='SSOM_ACCPRO_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.taccion_propuesta set
			obs_resp_area = v_parametros.obs_resp_area,
			descripcion_ap = v_parametros.descripcion_ap,
			id_parametro = v_parametros.id_parametro,
			-- id_funcionario = v_parametros.id_funcionario,
			descrip_causa_nc = v_parametros.descrip_causa_nc,
			efectividad_cumpl_ap = v_parametros.efectividad_cumpl_ap,
			fecha_fin_ap = v_parametros.fecha_fin_ap,
			obs_auditor_consultor = v_parametros.obs_auditor_consultor,
			id_nc = v_parametros.id_nc,
			fecha_inicio_ap = v_parametros.fecha_inicio_ap,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_ap=v_parametros.id_ap;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Acciones Propuestas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ap',v_parametros.id_ap::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_ACCPRO_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 22:32:50
	***********************************/

	elsif(p_transaccion='SSOM_ACCPRO_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.taccion_propuesta
            where id_ap=v_parametros.id_ap;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Acciones Propuestas eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ap',v_parametros.id_ap::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

    /*********************************
 	#TRANSACCION:  'SSOM_SIG_IME'
 	#DESCRIPCION:	Cambiar de estado
 	#AUTOR:		szambrana
 	#FECHA:		31-01-2019 13:53:10
	***********************************/
	---se inserta las siguientes funciones para gestionas los datos del wf (sirve para el wf)
	elsif(p_transaccion='SSOM_SIG_IME')then

		begin
        --raise exception ' -->%<-----', v_parametros.id_uo_padre;
        --Obtener datos del registro selecionado
        select
        	ap.id_ap,
        	ap.id_estado_wf,
            ap.id_proceso_wf,
            ap.nro_tramite,
            ap.estado_wf
        into
            v_record
		from ssom.taccion_propuesta ap
        where ap.id_proceso_wf = v_parametros.id_proceso_wf_act;

        ---obtener datos de actual estado
        select
        	ew.id_tipo_estado,
            te.pedir_obs,
            ew.id_estado_wf
        into
        	v_id_tipo_estado,
        	v_pedir_obs,
        	v_id_estado_wf
        from wf.testado_wf ew
        inner join wf.ttipo_estado te on te.id_tipo_estado = ew.id_tipo_estado
        where ew.id_estado_wf =  v_parametros.id_estado_wf_act;

        ---obtener el codigo de estado ej: Vobo..etc
        select
        	te.codigo
        into
        	v_codigo_estado_siguiente
        from wf.ttipo_estado te
        where te.id_tipo_estado = v_parametros.id_tipo_estado;

        ---parametros del formulario de wf
        IF  pxp.f_existe_parametro(p_tabla,'id_depto_wf') THEN
        	v_id_depto = v_parametros.id_depto_wf;
        END IF;

    	IF  pxp.f_existe_parametro(p_tabla,'obs') THEN
        	v_obs = v_parametros.obs;
       	ELSE
        	v_obs='---';
		END IF;

		---configurar acceso directo para la alarma
        v_acceso_directo = '';
        v_clase = '';
        v_parametros_ad = '';
        v_tipo_noti = 'notificacion';
        v_titulo  = 'Visto Bueno';

        ---obtener datos de nuevo estado
        v_id_estado_actual = wf.f_registra_estado_wf(v_parametros.id_tipo_estado,
        											v_parametros.id_funcionario_wf,
                                                    v_parametros.id_estado_wf_act,
                                                    v_parametros.id_proceso_wf_act,
                                                    p_id_usuario,
                                                    v_parametros._id_usuario_ai,
                                                    v_parametros._nombre_usuario_ai,
                                                    v_id_depto,
                                                    COALESCE(v_record.nro_tramite,'--')||' Obs:'||v_obs,
                                                    v_acceso_directo ,
                                                    v_clase,
                                                    v_parametros_ad,
                                                    v_tipo_noti,
                                                    v_titulo);


		---actualizar datos de nuevo estado
        update ssom.taccion_propuesta  set
              id_estado_wf = v_id_estado_actual,
              estado_wf = v_codigo_estado_siguiente,
              id_usuario_mod = p_id_usuario,
              id_usuario_ai = v_parametros._id_usuario_ai,
              usuario_ai = v_parametros._nombre_usuario_ai,
              fecha_mod = now()
              where id_proceso_wf = v_parametros.id_proceso_wf_act;

             /*
           		IF NOT ssom.f_procesar_estado(  p_id_usuario,
                                                v_parametros._id_usuario_ai,
                                                v_parametros._nombre_usuario_ai,
                                                v_id_estado_actual,
                                                v_parametros.id_proceso_wf_act,
                                                v_codigo_estado_siguiente) THEN

         			RAISE NOTICE 'PASANDO DE ESTADO';

          		END IF;*/



        --Definicion de la respuesta
        v_resp = pxp.f_agrega_clave(v_resp,'mensaje','accion propuesta cambio de estado (a)');
        v_resp = pxp.f_agrega_clave(v_resp,'id_proceso_wf_act',v_parametros.id_proceso_wf_act::varchar);

        --Devuelve la respuesta
        return v_resp;

		end;

    /*********************************
 	#TRANSACCION:  'SSOM_ANT_IME'
 	#DESCRIPCION:	Estado Anterior
 	#AUTOR:		szambrana
 	#FECHA:		31-01-2019 13:53:10
	***********************************/
    elsif(p_transaccion='SSOM_ANT_IME')then

		begin

           if  pxp.f_existe_parametro(p_tabla , 'estado_destino')  then
               v_operacion = v_parametros.estado_destino;
            end if;
            --Obtener datos del registro seleccionado
			select
                    ap.id_nc,
                    ap.id_estado_wf,
                    ap.id_proceso_wf,
                    ap.nro_tramite,
                    ap.estado_wf,
                    pwf.id_tipo_proceso
                    into
                    v_record
            from ssom.taccion_propuesta ap
            inner join wf.tproceso_wf pwf on pwf.id_proceso_wf = ap.id_proceso_wf
            where ap.id_proceso_wf = v_parametros.id_proceso_wf;

			v_id_proceso_wf = v_record.id_proceso_wf;


              --delete from asis.tmes_trabajo_con c
              --where c.id_mes_trabajo = v_record.id_mes_trabajo;


          SELECT

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
          FROM wf.f_obtener_estado_ant_log_wf(v_parametros.id_estado_wf);


             --configurar acceso directo para la alarma
                 v_acceso_directo = '';
                 v_clase = '';
                 v_parametros_ad = '';
                 v_tipo_noti = 'notificacion';
                 v_titulo  = 'Visto Bueno';

              -- registra nuevo estado

              v_id_estado_actual = wf.f_registra_estado_wf(	  v_id_tipo_estado,                --  id_tipo_estado al que retrocede
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

                  update ssom.taccion_propuesta set
                  id_estado_wf =  v_id_estado_actual,
                  estado_wf = v_codigo_estado,  --modificado
                  id_usuario_mod = p_id_usuario,
                  id_usuario_ai = v_parametros._id_usuario_ai,
                  usuario_ai = v_parametros._nombre_usuario_ai,
                  fecha_mod = now()
                  where id_proceso_wf = v_parametros.id_proceso_wf;

                  ---#4---
				    --select nc.id_nc into v_id_mes_trabajo_con
                    --from ssom.tno_conformidad nc
                    --where nc.id_proceso_wf = v_parametros.id_proceso_wf;

                    --delete from asis.tmes_trabajo_con mc
                    --where mc.id_mes_trabajo = v_id_mes_trabajo_con;
                    ---#4---

             -- si hay mas de un estado disponible  preguntamos al usuario
                v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Se realizo el cambio de estado)');
                v_resp = pxp.f_agrega_clave(v_resp,'operacion','cambio_exitoso');

              --Devuelve la respuesta
                return v_resp;
 			end;
     /*********************************
 	#TRANSACCION:  'SSOM_APACE_IME'
 	#DESCRIPCION:	Obtener responsable no conformidad
 	#AUTOR:		MMV
 	#FECHA:		29/7/2020
	***********************************/

	elsif(p_transaccion='SSOM_APACE_IME')then

		begin
			--Sentencia de la modificacion
           if( v_parametros.fieldName = 'revisar')then

                  select no.revisar into v_aceptar
                  from ssom.taccion_propuesta no
                  where no.id_ap = v_parametros.id_ap;


                  if (v_aceptar = 'si')then

                  	update ssom.taccion_propuesta set
                    revisar = 'no',
                    rechazar = 'no'
                    where id_ap=v_parametros.id_ap;

                  end if;

                  if (v_aceptar = 'no')then

                    	update ssom.taccion_propuesta set
                        revisar = 'si',
                        rechazar = 'no'
                        where id_ap=v_parametros.id_ap;

                  end if;
           end if;

           if( v_parametros.fieldName = 'rechazar')then

           		 	select no.rechazar into v_aceptar
                    from ssom.taccion_propuesta no
                    where no.id_ap = v_parametros.id_ap;


                  if (v_aceptar = 'si')then

                  	update ssom.taccion_propuesta set
                    revisar = 'no',
                    rechazar = 'no'
                    where id_ap=v_parametros.id_ap;

                  end if;

                  if (v_aceptar = 'no')then

                    	update ssom.taccion_propuesta set
                        revisar = 'no',
                        rechazar = 'si'
                        where id_ap=v_parametros.id_ap;

                  end if;

           end if;

           if( v_parametros.fieldName = 'implementar')then

           		 	select no.implementar into v_aceptar
                    from ssom.taccion_propuesta no
                    where no.id_ap = v_parametros.id_ap;


                  if (v_aceptar = 'si')then

                  	update ssom.taccion_propuesta set
                    implementar = 'no'
                    where id_ap=v_parametros.id_ap;

                  end if;

                  if (v_aceptar = 'no')then

                    	update ssom.taccion_propuesta set
                        implementar = 'si'
                        where id_ap=v_parametros.id_ap;

                  end if;

           end if;


			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ap',v_parametros.id_ap::varchar);

            --Devuelve la respuesta
            return v_resp;

	end;
        /****************************************************
    #TRANSACCION:     'SSOM_IMES_IME'
    #DESCRIPCION:     Cambiar estado
    #AUTOR:           MMV
    #FECHA:			  8/7/2020
    ***************************************************/

    elseif( p_transaccion='SSOM_IMES_IME') then

    begin


  	for v_record_accion in (  select 	ac.id_proceso_wf,
                                          ac.id_estado_wf,
                                          ac.rechazar,
                                          ac.revisar
                                  from ssom.taccion_propuesta ac
                                  where ac.id_nc = v_parametros.id_nc
                              )loop

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
          where pw.id_proceso_wf =  v_record_accion.id_proceso_wf;

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

            if (v_record_accion.revisar = 'si') then

            	v_id_estado_new = va_id_tipo_estado[1]::integer;
                v_estado_new =  va_codigo_estado[1]::varchar;

            end if;

            if (v_record_accion.rechazar = 'si') then
            		v_id_estado_new = va_id_tipo_estado[2]::integer;
                	v_estado_new =  va_codigo_estado[2]::varchar;
            end if;

             v_id_estado_actual = wf.f_registra_estado_wf(  v_id_estado_new,
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



          update ssom.taccion_propuesta set
          id_estado_wf =  v_id_estado_actual,
          estado_wf = v_estado_new,
          id_usuario_mod = p_id_usuario,
          fecha_mod = now()
          where id_proceso_wf = v_record_accion.id_proceso_wf;

      end loop;
      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Exito');
      v_resp = pxp.f_agrega_clave(v_resp,'id_nc',v_parametros.id_nc::varchar);

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

ALTER FUNCTION ssom.ft_accion_propuesta_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;