--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_accion_ro_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_accion_ro_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.taccion_ro''
 AUTOR: 		 (max.camacho)
 FECHA:	        16-12-2019 19:41:57
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 19:41:57								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.taccion_ro''
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_accion_ro	integer;

BEGIN

    v_nombre_funcion = ''ssom.ft_accion_ro_ime'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_ARO_INS''
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 19:41:57
	***********************************/

	if(p_transaccion=''SSOM_ARO_INS'')then

        begin
        	--Sentencia de la insercion
        	insert into ssom.taccion_ro(
					id_aom_ro,
					accion_ro,
					estado_reg,
					desc_accion_ro,
					id_usuario_ai,
					id_usuario_reg,
					fecha_reg,
					usuario_ai,
					fecha_mod,
					id_usuario_mod
								) values(
					v_parametros.id_aom_ro,
					v_parametros.accion_ro,
					''activo'',
					v_parametros.desc_accion_ro,
					v_parametros._id_usuario_ai,
					p_id_usuario,
					now(),
					v_parametros._nombre_usuario_ai,
					null,
					null

					)RETURNING id_accion_ro into v_id_accion_ro;

					--Definicion de la respuesta
					v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Accion-RO almacenado(a) con exito (id_accion_ro''||v_id_accion_ro||'')'');
					v_resp = pxp.f_agrega_clave(v_resp,''id_accion_ro'',v_id_accion_ro::varchar);

					--Devuelve la respuesta
					return v_resp;

				end;

	/*********************************
 	#TRANSACCION:  ''SSOM_ARO_MOD''
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 19:41:57
	***********************************/

	elsif(p_transaccion=''SSOM_ARO_MOD'')then

		begin
			--Sentencia de la modificacion
			update ssom.taccion_ro set
			id_aom_ro = v_parametros.id_aom_ro,
			accion_ro = v_parametros.accion_ro,
			desc_accion_ro = v_parametros.desc_accion_ro,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_accion_ro=v_parametros.id_accion_ro;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Accion-RO modificado(a)'');
			v_resp = pxp.f_agrega_clave(v_resp,''id_accion_ro'',v_parametros.id_accion_ro::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_ARO_ELI''
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 19:41:57
	***********************************/

	elsif(p_transaccion=''SSOM_ARO_ELI'')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.taccion_ro
            where id_accion_ro=v_parametros.id_accion_ro;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Accion-RO eliminado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_accion_ro'',v_parametros.id_accion_ro::varchar);

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