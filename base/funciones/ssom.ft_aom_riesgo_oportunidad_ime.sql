--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_aom_riesgo_oportunidad_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_aom_riesgo_oportunidad_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.taom_riesgo_oportunidad''
 AUTOR: 		 (max.camacho)
 FECHA:	        16-12-2019 20:00:49
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 20:00:49								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.taom_riesgo_oportunidad''
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_aom_ro	integer;

BEGIN

    v_nombre_funcion = ''ssom.ft_aom_riesgo_oportunidad_ime'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_AURO_INS''
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 20:00:49
	***********************************/

	if(p_transaccion=''SSOM_AURO_INS'')then

        begin
        	--Sentencia de la insercion
        	insert into ssom.taom_riesgo_oportunidad(
			estado_reg,
			id_impacto,
			id_probabilidad,
			id_tipo_ro,
			id_ro,
            otro_nombre_ro,
			id_aom,
			criticidad,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			''activo'',
			v_parametros.id_impacto,
			v_parametros.id_probabilidad,
			v_parametros.id_tipo_ro,
			v_parametros.id_ro,
            v_parametros.otro_nombre_ro,
			v_parametros.id_aom,
			v_parametros.criticidad,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null



			)RETURNING id_aom_ro into v_id_aom_ro;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Auditoria Riesgo Oportunidad almacenado(a) con exito (id_aom_ro''||v_id_aom_ro||'')'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_aom_ro'',v_id_aom_ro::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_AURO_MOD''
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 20:00:49
	***********************************/

	elsif(p_transaccion=''SSOM_AURO_MOD'')then

		begin
			--Sentencia de la modificacion
			update ssom.taom_riesgo_oportunidad set
			id_impacto = v_parametros.id_impacto,
			id_probabilidad = v_parametros.id_probabilidad,
			id_tipo_ro = v_parametros.id_tipo_ro,
			id_ro = v_parametros.id_ro,
            otro_nombre_ro = v_parametros.otro_nombre_ro,
			id_aom = v_parametros.id_aom,
			criticidad = v_parametros.criticidad,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_aom_ro=v_parametros.id_aom_ro;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Auditoria Riesgo Oportunidad modificado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_aom_ro'',v_parametros.id_aom_ro::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_AURO_ELI''
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 20:00:49
	***********************************/

	elsif(p_transaccion=''SSOM_AURO_ELI'')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.taom_riesgo_oportunidad
            where id_aom_ro=v_parametros.id_aom_ro;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Auditoria Riesgo Oportunidad eliminado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_aom_ro'',v_parametros.id_aom_ro::varchar);

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