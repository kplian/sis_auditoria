--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_tipo_ro_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_tipo_ro_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.ttipo_ro''
 AUTOR: 		 (max.camacho)
 FECHA:	        16-12-2019 17:36:24
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 17:36:24								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.ttipo_ro''
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_tipo_ro	integer;

BEGIN

    v_nombre_funcion = ''ssom.ft_tipo_ro_ime'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_TRO_INS''
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 17:36:24
	***********************************/

	if(p_transaccion=''SSOM_TRO_INS'')then

        begin
        	--Sentencia de la insercion
        	insert into ssom.ttipo_ro(
			tipo_ro,
			estado_reg,
			desc_tipo_ro,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.tipo_ro,
			''activo'',
			v_parametros.desc_tipo_ro,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null



			)RETURNING id_tipo_ro into v_id_tipo_ro;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Tipo Riesgo Oportunidad almacenado(a) con exito (id_tipo_ro''||v_id_tipo_ro||'')'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_tipo_ro'',v_id_tipo_ro::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_TRO_MOD''
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 17:36:24
	***********************************/

	elsif(p_transaccion=''SSOM_TRO_MOD'')then

		begin
			--Sentencia de la modificacion
			update ssom.ttipo_ro set
			tipo_ro = v_parametros.tipo_ro,
			desc_tipo_ro = v_parametros.desc_tipo_ro,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tipo_ro=v_parametros.id_tipo_ro;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Tipo Riesgo Oportunidad modificado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_tipo_ro'',v_parametros.id_tipo_ro::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_TRO_ELI''
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 17:36:24
	***********************************/

	elsif(p_transaccion=''SSOM_TRO_ELI'')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.ttipo_ro
            where id_tipo_ro=v_parametros.id_tipo_ro;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Tipo Riesgo Oportunidad eliminado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_tipo_ro'',v_parametros.id_tipo_ro::varchar);

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