CREATE OR REPLACE FUNCTION ssom.ft_no_conformidad_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_no_conformidad_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tno_conformidad'
 AUTOR: 		 (szambrana)
 FECHA:	        04-07-2019 19:53:16
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				04-07-2019 19:53:16								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tno_conformidad'
 #3				04-08-2020 19:53:16								Refactorización No Conformidad
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_nc					integer;

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

   	--variables para proceso disparador
	v_registros_proc	record;
    v_codigo_tipo_pro		varchar;
    v_codigo_llave 			varchar;
    v_desc_funcionario		varchar;
    v_msg					varchar;
	v_registos				record;
    v_estado_actual			record;
    v_estado_sigue			record;

    v_id_nuevo				integer;
	v_id_pn					integer;
    v_record_uo				record;
	v_aceptar				varchar;
    v_param					record;
    v_norma					record;

    va_id_tipo_estado 	  integer [];
    va_codigo_estado 		  varchar [];
    va_disparador 	      varchar [];
    va_regla 				  varchar [];
    va_prioridad 		      integer [];
    v_registro_estado			record;




BEGIN

    v_nombre_funcion = 'ssom.ft_no_conformidad_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_NOCONF_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 19:53:16
	***********************************/

	if(p_transaccion='SSOM_NOCONF_INS')then

        begin

            ---Obtener la gestion actual (sirve para wf)
        	select
            	g.id_gestion,
           		g.gestion
            into
                v_rec_gestion
            from param.tgestion g
            where g.gestion = EXTRACT(YEAR FROM current_date);

        	---Obtener el codigo del proceso macro y id proceso (sirve para wf
            select
            	tp.codigo,
         		pm.id_proceso_macro
                into
                v_codigo_tipo_proceso,
                v_id_proceso_macro
           	from  wf.tproceso_macro pm
           	inner join wf.ttipo_proceso tp on tp.id_proceso_macro = pm.id_proceso_macro
			where  pm.codigo='AUD' and tp.estado_reg = 'activo'
            and tp.codigo = 'AUNC';

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
                 'No conformidad',
                 v_codigo_tipo_proceso,
                 v_parametros.nro_tramite_padre);

        	--- raise exception 'nro -> %',v_nro_tramite;

        	insert into ssom.tno_conformidad(
                obs_consultor,
                estado_reg,
                evidencia,
                id_funcionario,
                id_uo,
                descrip_nc,
                id_parametro,
                obs_resp_area,
                id_aom,
                fecha_reg,
                usuario_ai,
                id_usuario_reg,
                id_usuario_ai,
                id_usuario_mod,
                fecha_mod,
                -- id_uo_adicional,
                id_proceso_wf,	--integrar con wf new
                id_estado_wf,	--integrar con wf new
                nro_tramite, 	--integrar con wf new
                estado_wf,  	--integrar con wf new
                codigo_nc,
                calidad,
                medio_ambiente,
                seguridad,
                responsabilidad_social,
                sistemas_integrados

          	) values(
                v_parametros.obs_consultor,
                'activo',
                v_parametros.evidencia,
                v_parametros.id_funcionario,
                v_parametros.id_uo,
                v_parametros.descrip_nc,
                v_parametros.id_parametro,
                v_parametros.obs_resp_area,
                v_parametros.id_aom,
                now(),
                v_parametros._nombre_usuario_ai,
                p_id_usuario,
                v_parametros._id_usuario_ai,
                null,
                null,
                -- v_parametros.id_uo_adicional,
                v_id_proceso_wf,	--integrar con wf new
                v_id_estado_wf,		--integrar con wf new
                v_nro_tramite,		--integrar con wf new
                v_codigo_estado,	--integrar con wf new
                ssom.f_generar_correlativo('NOCONF', EXTRACT(YEAR FROM current_date)::integer),
                v_parametros.calidad,
                v_parametros.medio_ambiente,
                v_parametros.seguridad,
                v_parametros.responsabilidad_social,
                v_parametros.sistemas_integrados
			)RETURNING id_nc into v_id_nc;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidad almacenado(a) con exito (id_nc'||v_id_nc||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_nc',v_id_nc::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_NOCONF_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 19:53:16
	***********************************/

	elsif(p_transaccion='SSOM_NOCONF_MOD')then

		begin


        if v_parametros.extra = 'si' then

        	update ssom.tno_conformidad set
			obs_consultor = v_parametros.obs_consultor,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now()
			where id_nc=v_parametros.id_nc;


        else
			--Sentencia de la modificacion
			update ssom.tno_conformidad set
			obs_consultor = v_parametros.obs_consultor,
			evidencia = v_parametros.evidencia,
			id_funcionario = v_parametros.id_funcionario,
			id_uo = v_parametros.id_uo,
			descrip_nc = v_parametros.descrip_nc,
			id_parametro = v_parametros.id_parametro,
			obs_resp_area = v_parametros.obs_resp_area,
			id_aom = v_parametros.id_aom,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            calidad = v_parametros.calidad,
            medio_ambiente = v_parametros.medio_ambiente,
            seguridad = v_parametros.seguridad,
            responsabilidad_social = v_parametros.responsabilidad_social,
            sistemas_integrados = v_parametros.sistemas_integrados
			where id_nc=v_parametros.id_nc;
        end if;
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_nc',v_parametros.id_nc::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_NOCONF_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 19:53:16
	***********************************/

	elsif(p_transaccion='SSOM_NOCONF_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tno_conformidad
            where id_nc=v_parametros.id_nc;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_nc',v_parametros.id_nc::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

    /*********************************
 	#TRANSACCION:  'SSOM_SIGA_IME'
 	#DESCRIPCION:	Cambiar de estado
 	#AUTOR:		szambrana
 	#FECHA:		31-01-2019 13:53:10
	***********************************/
	---se inserta las siguientes funciones para gestionas los datos del wf (sirve para el wf)
	elsif(p_transaccion='SSOM_SIGA_IME')then

        begin

            --Obtener datos del registro selecionado
            select
                nc.id_nc,
                nc.id_estado_wf,
                nc.id_proceso_wf,
                nc.nro_tramite,
                nc.estado_wf,
                nc.id_funcionario
            into
                v_record
            from ssom.tno_conformidad nc
            where nc.id_proceso_wf = v_parametros.id_proceso_wf_act;

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
            if pxp.f_existe_parametro(p_tabla,'id_depto_wf') then
                v_id_depto = v_parametros.id_depto_wf;
            end if;

            if pxp.f_existe_parametro(p_tabla,'obs') then
                v_obs = v_parametros.obs;
            else
                v_obs='---';
            end if;

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
            /* update ssom.tno_conformidad  set
            id_estado_wf = v_id_estado_actual,
            estado_wf = v_codigo_estado_siguiente,
            id_usuario_mod = p_id_usuario,
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai,
            fecha_mod = now()
            where id_proceso_wf = v_parametros.id_proceso_wf_act;*/

            if not ssom.f_procesar_estado_noconformidad (  p_id_usuario,
                                            v_parametros._id_usuario_ai,
                                            v_parametros._nombre_usuario_ai,
                                            v_id_estado_actual,
                                            v_parametros.id_proceso_wf_act,
                                            v_codigo_estado_siguiente) then

            	RAISE NOTICE 'PASANDO DE ESTADO';
            end if;

			--ciclo para el disparador de estados
           	for v_registros_proc in ( select * from json_populate_recordset(null::wf.proceso_disparado_wf, v_parametros.json_procesos::json)) loop
          	--conseguir el codigo del tipo proceso
        		select
                	tp.codigo,
                  	tp.codigo_llave
               	into
                  	v_codigo_tipo_pro,
                  	v_codigo_llave
               	from wf.ttipo_proceso tp
                where  tp.id_tipo_proceso =  v_registros_proc.id_tipo_proceso_pro;

                select
					ps_id_proceso_wf,
                    ps_id_estado_wf,
                    ps_codigo_estado,
                    ps_nro_tramite
                into
                    v_id_proceso_wf,
                    v_id_estado_wf,
                    v_codigo_estado,
                    v_nro_tramite
              	from ssom.f_registra_proceso_disparado_wf(
                    p_id_usuario,
                    v_parametros._id_usuario_ai,
                    v_parametros._nombre_usuario_ai,
                    v_id_estado_actual,
                    v_registros_proc.id_funcionario_wf_pro,
                    v_registros_proc.id_depto_wf_pro,
                    v_registros_proc.obs_pro,
                    v_codigo_tipo_pro,
                    v_codigo_tipo_pro);


				insert into ssom.taccion_propuesta
                    (
              		id_usuario_reg,
                    id_usuario_mod,
                    fecha_reg,
                    fecha_mod,
                    estado_reg,
                    id_usuario_ai,
                    usuario_ai,
                    id_nc,
                    id_parametro,
                    descrip_causa_nc,
                    descripcion_ap,
                    efectividad_cumpl_ap,
                    fecha_inicio_ap,
                    fecha_fin_ap,
                    id_funcionario,
                    obs_resp_area,
                    obs_auditor_consultor,
                    id_proceso_wf,
                    id_estado_wf,
                    nro_tramite,
                    estado_wf
                    )
                    values (
                    p_id_usuario,
                    null,
                    now(),
                    null,
                    'activo',
                    v_parametros._id_usuario_ai,
                    v_parametros._nombre_usuario_ai,
                    v_record.id_nc,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    v_record.id_funcionario,
                    null,
                    null,
                    v_id_proceso_wf,
                    v_id_estado_wf,
                    v_nro_tramite,
                    v_codigo_estado
                    );

              end loop;
        --Definicion de la respuesta
        v_resp = pxp.f_agrega_clave(v_resp,'mensaje','no conformidad cambio de estado (a)');
        v_resp = pxp.f_agrega_clave(v_resp,'id_proceso_wf_act',v_parametros.id_proceso_wf_act::varchar);

        --Devuelve la respuesta
        return v_resp;

		end;

    /*********************************
 	#TRANSACCION:  'SSOM_ANTE_IME'
 	#DESCRIPCION:	Estado Anterior
 	#AUTOR:		szambrana
 	#FECHA:		31-01-2019 13:53:10
	***********************************/
    elsif(p_transaccion='SSOM_ANTE_IME')then

		begin

        	if  pxp.f_existe_parametro(p_tabla , 'estado_destino')  then
               v_operacion = v_parametros.estado_destino;
            end if;
            --Obtener datos del registro seleccionado
			select
                    nc.id_nc,
                    nc.id_estado_wf,
                    nc.id_proceso_wf,
                    nc.nro_tramite,
                    nc.estado_wf,
                    pwf.id_tipo_proceso
                    into
                    v_record
            from ssom.tno_conformidad nc
            inner join wf.tproceso_wf pwf on pwf.id_proceso_wf = nc.id_proceso_wf
            where nc.id_proceso_wf = v_parametros.id_proceso_wf;

			v_id_proceso_wf = v_record.id_proceso_wf;

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

             --configurar acceso directo para la alarma
             v_acceso_directo = '';
             v_clase = '';
             v_parametros_ad = '';
             v_tipo_noti = 'notificacion';
             v_titulo  = 'Visto Bueno';

             -- registra nuevo estado

             v_id_estado_actual = wf.f_registra_estado_wf( v_id_tipo_estado,                --  id_tipo_estado al que retrocede
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

              update ssom.tno_conformidad set
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
 	#TRANSACCION:  'SSOM_REUO_IME'
 	#DESCRIPCION:	Obtener responsable uo
 	#AUTOR:		szambrana
 	#FECHA:		27-11-2019
	***********************************/

	elsif(p_transaccion='SSOM_REUO_IME')then

		begin
			--Sentencia de la modificacion


            select fun.id_funcionario,
                   fun.desc_funcionario1
                   into
                   v_id_funcionario,
                   v_desc_funcionario
    		from orga.tuo uni
		    inner join orga.tuo ger on ger.id_uo = orga.f_get_uo_gerencia( uni.id_uo, NULL::integer, NULL::date)
		    inner join orga.tuo_funcionario uof on uof.id_uo = ger.id_uo
		    inner join orga.vfuncionario fun on fun.id_funcionario = uof.id_funcionario
		    where uni.id_uo = v_parametros.id_uo and (uof.fecha_finalizacion is null or uof.fecha_finalizacion >= now()::date);

            if v_id_funcionario is null then
            	v_msg = 'Error no se encuentra el funcionario';
            else
            	v_msg = 'Exito';
            end if;


			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje',v_msg);
            v_resp = pxp.f_agrega_clave(v_resp,'id_funcionario',v_id_funcionario::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'desc_funcionario',v_desc_funcionario::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

    /*********************************
 	#TRANSACCION:  'SSOM_RNCUO_IME'
 	#DESCRIPCION:	Obtener responsable no conformidad
 	#AUTOR:		szambrana
 	#FECHA:		27-11-2019
	***********************************/

	elsif(p_transaccion='SSOM_RNCUO_IME')then

		begin
			--Sentencia de la modificacion
			update ssom.tno_conformidad set
			id_funcionario_nc = v_parametros.id_funcionario_nc
			where id_nc=v_parametros.id_nc;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_nc',v_parametros.id_nc::varchar);

            --Devuelve la respuesta
            return v_resp;

	end;
    /*********************************
 	#TRANSACCION:  'SSOM_SIAG_IME'
 	#DESCRIPCION:	Cambiar de estado en grupo por estado propuesto
 	#AUTOR:		szambrana
 	#FECHA:		21-12-2019
	***********************************/

	elsif(p_transaccion='SSOM_SIAG_IME')then

		begin

        for v_registos in (select   no.id_nc,
                                    no.id_estado_wf,
                                    no.id_proceso_wf,
                                    no.estado_wf,
                                    no.id_funcionario_nc,
                                    no.nro_tramite
                            from ssom.tauditoria_oportunidad_mejora au
                            inner join ssom.tno_conformidad no on no.id_aom = au.id_aom
                            where au.id_aom = v_parametros.id_aom
                                  and  no.estado_wf = 'propuesta'
                                  and  no.id_funcionario_nc is not null)

        loop

              select ewf.id_tipo_estado,
                     ti.codigo
                     into
                     v_estado_actual
              from wf.testado_wf ewf
              inner join wf.ttipo_estado ti on ti.id_tipo_estado = ewf.id_tipo_estado
              where ewf.id_estado_wf = v_registos.id_estado_wf;



               v_id_nuevo = ssom.f_id_estado_sigue(v_registos.id_proceso_wf,'verificar',p_id_usuario);

             --  raise exception '%',v_id_nuevo;
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
                where ew.id_estado_wf =  v_registos.id_estado_wf;

                ---obtener el codigo de estado ej: Vobo..etc
                select
                    te.codigo
                into
                    v_codigo_estado_siguiente
                from wf.ttipo_estado te
                where te.id_tipo_estado = v_id_nuevo;

                ---parametros del formulario de wf
                if pxp.f_existe_parametro(p_tabla,'id_depto_wf') then
                    v_id_depto = v_parametros.id_depto_wf;
                end if;

                if pxp.f_existe_parametro(p_tabla,'obs') then
                    v_obs = v_parametros.obs;
                else
                    v_obs='---';
                end if;

                ---configurar acceso directo para la alarma
                v_acceso_directo = '';
                v_clase = '';
                v_parametros_ad = '';
                v_tipo_noti = 'notificacion';
                v_titulo  = 'Visto Bueno';

                ---obtener datos de nuevo estado
                v_id_estado_actual = wf.f_registra_estado_wf( v_id_nuevo,
                                                              v_registos.id_funcionario_nc,
                                                              v_registos.id_estado_wf,
                                                              v_registos.id_proceso_wf,
                                                              p_id_usuario,
                                                              v_parametros._id_usuario_ai,
                                                              v_parametros._nombre_usuario_ai,
                                                              v_id_depto,
                                                              COALESCE(v_registos.nro_tramite,'--')||' Obs:'||v_obs,
                                                              v_acceso_directo,
                                                              v_clase,
                                                              v_parametros_ad,
                                                              v_tipo_noti,
                                                              v_titulo);

    			--raise exception '%',v_codigo_estado_siguiente;

                if not ssom.f_procesar_estado_noconformidad ( p_id_usuario,
                                                              v_parametros._id_usuario_ai,
                                                              v_parametros._nombre_usuario_ai,
                                                              v_id_estado_actual,
                                                              v_registos.id_proceso_wf,
                                                              v_codigo_estado_siguiente) then

                    RAISE NOTICE 'PASANDO DE ESTADO';
                end if;
        end loop;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades modificado(a)');
            -- v_resp = pxp.f_agrega_clave(v_resp,'id_nc',v_parametros.id_nc::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
    /*********************************
 	#TRANSACCION:  'SSOM_INTE_INS'
 	#DESCRIPCION:	Obtener responsable no conformidad
 	#AUTOR:		MMV
 	#FECHA:		27-11-2019
	***********************************/

	elsif(p_transaccion='SSOM_INTE_INS')then

		begin
			--Sentencia de la modificacion



        	select
            	g.id_gestion,
           		g.gestion
            into
                v_rec_gestion
            from param.tgestion g
            where g.gestion = EXTRACT(YEAR FROM current_date);

        	---Obtener el codigo del proceso macro y id proceso (sirve para wf
            select
            	tp.codigo,
         		pm.id_proceso_macro
                into
                v_codigo_tipo_proceso,
                v_id_proceso_macro
           	from  wf.tproceso_macro pm
           	inner join wf.ttipo_proceso tp on tp.id_proceso_macro = pm.id_proceso_macro
			where  pm.codigo='AUD' and tp.estado_reg = 'activo'
            and tp.codigo = 'AUNC';

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
                 'No conformidad',
                 v_codigo_tipo_proceso,
                 v_parametros.nro_tramite_padre);

               if (v_parametros.id_nc is null)then
                 insert into ssom.tno_conformidad(  obs_consultor,
                                                    estado_reg,
                                                    evidencia,
                                                    id_funcionario,
                                                    id_uo,
                                                    descrip_nc,
                                                    id_parametro,
                                                    obs_resp_area,
                                                    id_aom,
                                                    fecha_reg,
                                                    usuario_ai,
                                                    id_usuario_reg,
                                                    id_usuario_ai,
                                                    id_usuario_mod,
                                                    fecha_mod,
                                                    id_proceso_wf,
                                                    id_estado_wf,
                                                    nro_tramite,
                                                    estado_wf,
                                                    codigo_nc,
                                                    calidad,
                                                    medio_ambiente,
                                                    responsabilidad_social,
                                                    seguridad,
                                                    sistemas_integrados
                                                	) values(
                                                    v_parametros.obs_consultor,
                                                    'activo',
                                                    v_parametros.evidencia,
                                                    v_parametros.id_funcionario,
                                                    v_parametros.id_uo,
                                                    v_parametros.descrip_nc,
                                                    v_parametros.id_parametro,
                                                    v_parametros.obs_resp_area,
                                                    v_parametros.id_aom,
                                                    now(),
                                                    v_parametros._nombre_usuario_ai,
                                                    p_id_usuario,
                                                    v_parametros._id_usuario_ai,
                                                    null,
                                                    null,
                                                    v_id_proceso_wf,
                                                    v_id_estado_wf,
                                                    v_nro_tramite,
                                                    v_codigo_estado,
                                                    ssom.f_generar_correlativo('NOCONF', EXTRACT(YEAR FROM current_date)::integer),
                                                    v_parametros.calidad,
                                                    v_parametros.medio_ambiente,
                                                    v_parametros.responsabilidad_social,
                                                    v_parametros.seguridad,
                                                    v_parametros.sistemas_integrados
                                                	)RETURNING id_nc into v_id_nc;

               else

               update ssom.tno_conformidad set
                obs_consultor = v_parametros.obs_consultor,
                evidencia = v_parametros.evidencia,
                descrip_nc = v_parametros.descrip_nc,
                id_parametro = v_parametros.id_parametro,
                obs_resp_area = v_parametros.obs_resp_area,
                id_usuario_mod = p_id_usuario,
                fecha_mod = now(),
                id_usuario_ai = v_parametros._id_usuario_ai,
                usuario_ai = v_parametros._nombre_usuario_ai,
                calidad = v_parametros.calidad,
                medio_ambiente = v_parametros.medio_ambiente,
                seguridad = v_parametros.seguridad,
                responsabilidad_social = v_parametros.responsabilidad_social,
                sistemas_integrados = v_parametros.sistemas_integrados
                where id_nc=v_parametros.id_nc;

               end if;

           /* if (v_parametros.id_nc is not null)then

            	delete from ssom.tpnorma_noconformidad np
                where np.id_nc = v_parametros.id_nc;

             	v_id_nc = v_parametros.id_nc;

            end if;*/

            /*foreach v_id_pn in array string_to_array(v_parametros.id_pn,',')
           				 										loop
                         insert into ssom.tpnorma_noconformidad(  id_nc,
                                                                  estado_reg,
                                                                  id_pn,
                                                                  id_norma,
                                                                  usuario_ai,
                                                                  fecha_reg,
                                                                  id_usuario_reg,
                                                                  id_usuario_ai,
                                                                  fecha_mod,
                                                                  id_usuario_mod
                                                                  ) values(
                                                                  v_id_nc,
                                                                  'activo',
                                                                  v_id_pn,
                                                                  v_parametros.id_norma,
                                                                  v_parametros._nombre_usuario_ai,
                                                                  now(),
                                                                  p_id_usuario,
                                                                  v_parametros._id_usuario_ai,
                                                                  null,
                                                                  null
                                                                  );

        	end loop;*/
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_nc',v_id_nc::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
    /*********************************
 	#TRANSACCION:  'SSOM_NOGET_IME'
 	#DESCRIPCION:	Obtener responsable no conformidad
 	#AUTOR:		MMV
 	#FECHA:		29/07/2020
	***********************************/

	elsif(p_transaccion='SSOM_NOGET_IME')then

		begin
			--Sentencia de la modificacion

            select  uo.id_uo,
                    uo.nombre_unidad,
                    fu.id_funcionario,
                    fu.desc_funcionario1
                    into
                    v_record_uo
            from orga.tuo uo
            inner join orga.tnivel_organizacional ni on ni.id_nivel_organizacional = uo.id_nivel_organizacional
            inner join orga.tuo_funcionario fo on fo.id_uo = uo.id_uo
            inner join orga.vfuncionario fu on fu.id_funcionario = fo.id_funcionario
            where uo.estado_reg = 'activo'
                    and ni.numero_nivel not in (9,8,7,0)
                    and (fo.fecha_finalizacion is null or fo.fecha_finalizacion >= now())
                    and uo.id_uo = v_parametros.id_uo
            order by numero_nivel;



			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_uo',v_record_uo.id_uo::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'nombre_unidad',v_record_uo.nombre_unidad::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'id_funcionario',v_record_uo.id_funcionario::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'desc_funcionario1',v_record_uo.desc_funcionario1::varchar);
            --Devuelve la respuesta
            return v_resp;

		end;
    /*********************************
 	#TRANSACCION:  'SSOM_RNACE_IME'
 	#DESCRIPCION:	Obtener responsable no conformidad
 	#AUTOR:		MMV
 	#FECHA:		29/7/2020
	***********************************/

	elsif(p_transaccion='SSOM_RNACE_IME')then

		begin
			--Sentencia de la modificacion

           if( v_parametros.fieldName = 'revisar')then

                  select no.revisar into v_aceptar
                  from ssom.tno_conformidad no
                  where no.id_nc = v_parametros.id_nc;


                  if (v_aceptar = 'si')then

                  	update ssom.tno_conformidad set
                    revisar = 'no',
                    rechazar = 'no'
                    where id_nc=v_parametros.id_nc;

                  end if;

                  if (v_aceptar = 'no')then

                    	update ssom.tno_conformidad set
                        revisar = 'si',
                        rechazar = 'no'
                        where id_nc=v_parametros.id_nc;

                  end if;
           end if;

           if( v_parametros.fieldName = 'rechazar')then

           		 	select no.rechazar into v_aceptar
                    from ssom.tno_conformidad no
                    where no.id_nc = v_parametros.id_nc;


                  if (v_aceptar = 'si')then

                  	update ssom.tno_conformidad set
                    revisar = 'no',
                    rechazar = 'no'
                    where id_nc=v_parametros.id_nc;

                  end if;

                  if (v_aceptar = 'no')then

                    	update ssom.tno_conformidad set
                        revisar = 'no',
                        rechazar = 'si'
                        where id_nc=v_parametros.id_nc;

                  end if;

           end if;


			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_nc',v_parametros.id_nc::varchar);

            --Devuelve la respuesta
            return v_resp;

	end;
    /*********************************
 	#TRANSACCION:  'SSOM_NOTOD_IME'
 	#DESCRIPCION:	Obtener responsable no conformidad
 	#AUTOR:		MMV
 	#FECHA:		29/7/2020
	***********************************/

	elsif(p_transaccion='SSOM_NOTOD_IME')then

		begin

        --Sentencia de la modificacion

        update ssom.tno_conformidad set
        revisar = 'si',
        rechazar = 'no'
        where id_aom = v_parametros.id_aom;


        --Definicion de la respuesta
        v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades modificado(a)');
        v_resp = pxp.f_agrega_clave(v_resp,'id_aom',v_parametros.id_aom::varchar);

        --Devuelve la respuesta
        return v_resp;

	end;

    /*********************************
 	#TRANSACCION:  'SSOM_NGET_IME'
 	#DESCRIPCION:	Obtener responsable no conformidad
 	#AUTOR:		MMV
 	#FECHA:		29/7/2020
	***********************************/

	elsif(p_transaccion='SSOM_NGET_IME')then

		begin

        --Sentencia de la modificacion

     	select  pa.id_parametro,
        		pa.valor_parametro
                into
                v_param
        from ssom.tno_conformidad  no
        inner join ssom.tparametro pa on pa.id_parametro = no.id_parametro
        where no.id_nc = v_parametros.id_nc;

        select  pn.id_norma,
        		no.sigla_norma
                into
                v_norma
        from ssom.tpnorma_noconformidad pn
        inner join ssom.tnorma no on no.id_norma = pn.id_norma
        where pn.id_nc = v_parametros.id_nc;


        --Definicion de la respuesta
        v_resp = pxp.f_agrega_clave(v_resp,'mensaje','No Conformidades modificado(a)');
        v_resp = pxp.f_agrega_clave(v_resp,'id_nc',v_parametros.id_nc::varchar);
        v_resp = pxp.f_agrega_clave(v_resp,'id_parametro',v_param.id_parametro::varchar);
        v_resp = pxp.f_agrega_clave(v_resp,'valor_parametro',v_param.valor_parametro::varchar);
        v_resp = pxp.f_agrega_clave(v_resp,'id_norma',v_norma.id_norma::varchar);
        v_resp = pxp.f_agrega_clave(v_resp,'sigla_norma',v_norma.sigla_norma::varchar);


        --Devuelve la respuesta
        return v_resp;

	end;
    /****************************************************
    #TRANSACCION:     'SSOM_ACES_IME'
    #DESCRIPCION:     Cambiar estado
    #AUTOR:           MMV
    #FECHA:			  8/7/2020
    ***************************************************/

    elseif( p_transaccion='SSOM_ACES_IME') then

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



     --  raise exception '%',va_codigo_estado[1];
       update ssom.tno_conformidad set
        id_estado_wf =  v_id_estado_actual,
        estado_wf = va_codigo_estado[1],
        id_usuario_mod=p_id_usuario,
        fecha_mod=now()
       where id_proceso_wf = v_parametros.id_proceso_wf;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Exito');
      v_resp = pxp.f_agrega_clave(v_resp,'id_proceso_wf',v_parametros.id_proceso_wf::varchar);

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

ALTER FUNCTION ssom.ft_no_conformidad_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;