--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_grupo_consultivo_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_grupo_consultivo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.tgrupo_consultivo''
 AUTOR: 		 (max.camacho)
 FECHA:	        22-07-2019 23:01:14
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				22-07-2019 23:01:14								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.tgrupo_consultivo''
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_gconsultivo	integer;

BEGIN

    v_nombre_funcion = ''ssom.ft_grupo_consultivo_ime'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_GCT_INS''
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		22-07-2019 23:01:14
	***********************************/

	if(p_transaccion=''SSOM_GCT_INS'')then

        begin
        	--Sentencia de la insercion
        	insert into ssom.tgrupo_consultivo(
			nombre_programacion,
			id_empresa,
			descrip_gconsultivo,
			nombre_gconsultivo,
			requiere_programacion,
			nombre_formulario,
			estado_reg,
			requiere_formulario,
			id_usuario_ai,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.nombre_programacion,
			v_parametros.id_empresa,
			v_parametros.descrip_gconsultivo,
			v_parametros.nombre_gconsultivo,
			v_parametros.requiere_programacion,
			v_parametros.nombre_formulario,
			''activo'',
			v_parametros.requiere_formulario,
			v_parametros._id_usuario_ai,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			null,
			null



			)RETURNING id_gconsultivo into v_id_gconsultivo;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Grupo Consultivo almacenado(a) con exito (id_gconsultivo''||v_id_gconsultivo||'')'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_gconsultivo'',v_id_gconsultivo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_GCT_MOD''
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		22-07-2019 23:01:14
	***********************************/

	elsif(p_transaccion=''SSOM_GCT_MOD'')then

		begin
			--Sentencia de la modificacion
			update ssom.tgrupo_consultivo set
			nombre_programacion = v_parametros.nombre_programacion,
			id_empresa = v_parametros.id_empresa,
			descrip_gconsultivo = v_parametros.descrip_gconsultivo,
			nombre_gconsultivo = v_parametros.nombre_gconsultivo,
			requiere_programacion = v_parametros.requiere_programacion,
			nombre_formulario = v_parametros.nombre_formulario,
			requiere_formulario = v_parametros.requiere_formulario,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_gconsultivo=v_parametros.id_gconsultivo;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Grupo Consultivo modificado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_gconsultivo'',v_parametros.id_gconsultivo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_GCT_ELI''
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		22-07-2019 23:01:14
	***********************************/

	elsif(p_transaccion=''SSOM_GCT_ELI'')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tgrupo_consultivo
            where id_gconsultivo=v_parametros.id_gconsultivo;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Grupo Consultivo eliminado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_gconsultivo'',v_parametros.id_gconsultivo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	else

    	raise exception ''Transaccion inexistente: %'',p_transaccion;

	end if;

EXCEPTION

	WHEN OTHERS THEN
		v_resp='''';
		v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,''codigo_error'',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,''procedimientos'',v_nombre_funcion);
		raise exception ''%'',v_resp;

END;
'LANGUAGE 'plpgsql'
 VOLATILE
 CALLED ON NULL INPUT
 SECURITY INVOKER
 COST 100;