--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_parametro_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_parametro_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.tparametro''
 AUTOR: 		 (max.camacho)
 FECHA:	        03-07-2019 16:18:31
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-07-2019 16:18:31								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.tparametro''
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_parametro	integer;

BEGIN

    v_nombre_funcion = ''ssom.ft_parametro_ime'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_PRM_INS''
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		03-07-2019 16:18:31
	***********************************/

	if(p_transaccion=''SSOM_PRM_INS'')then

        begin
        	--Sentencia de la insercion
        	insert into ssom.tparametro(
					id_tipo_parametro,
					estado_reg,
					valor_parametro,
								codigo_parametro,
					id_usuario_reg,
					fecha_reg,
					usuario_ai,
					id_usuario_ai,
					fecha_mod,
					id_usuario_mod
								) values(
					v_parametros.id_tipo_parametro,
					''activo'',
					v_parametros.valor_parametro,
								v_parametros.codigo_parametro,
					p_id_usuario,
					now(),
					v_parametros._nombre_usuario_ai,
					v_parametros._id_usuario_ai,
					null,
					null



					)RETURNING id_parametro into v_id_parametro;

					--Definicion de la respuesta
					v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Parametro almacenado(a) con exito (id_parametro''||v_id_parametro||'')'');
					v_resp = pxp.f_agrega_clave(v_resp,''id_parametro'',v_id_parametro::varchar);

					--Devuelve la respuesta
					return v_resp;

				end;

	/*********************************
 	#TRANSACCION:  ''SSOM_PRM_MOD''
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		03-07-2019 16:18:31
	***********************************/

	elsif(p_transaccion=''SSOM_PRM_MOD'')then

		begin
			--Sentencia de la modificacion
			update ssom.tparametro set
			id_tipo_parametro = v_parametros.id_tipo_parametro,
			valor_parametro = v_parametros.valor_parametro,
            codigo_parametro = v_parametros.codigo_parametro,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_parametro=v_parametros.id_parametro;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Parametro modificado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_parametro'',v_parametros.id_parametro::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_PRM_ELI''
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		03-07-2019 16:18:31
	***********************************/

	elsif(p_transaccion=''SSOM_PRM_ELI'')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tparametro
            where id_parametro=v_parametros.id_parametro;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Parametro eliminado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_parametro'',v_parametros.id_parametro::varchar);

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