--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_tipo_auditoria_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_tipo_auditoria_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.ttipo_auditoria''
 AUTOR: 		 (max.camacho)
 FECHA:	        17-07-2019 13:23:26
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				17-07-2019 13:23:26								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla ''ssom.ttipo_auditoria''
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_tipo_auditoria	integer;

BEGIN

    v_nombre_funcion = ''ssom.ft_tipo_auditoria_ime'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_TAU_INS''
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		17-07-2019 13:23:26
	***********************************/

	if(p_transaccion=''SSOM_TAU_INS'')then

        begin
        	--Sentencia de la insercion
        	insert into ssom.ttipo_auditoria(
			descrip_tauditoria,
			estado_reg,
			tipo_auditoria,
            codigo_tpo_aom,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.descrip_tauditoria,
			''activo'',
			v_parametros.tipo_auditoria,
            upper(v_parametros.codigo_tpo_aom),
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null



			)RETURNING id_tipo_auditoria into v_id_tipo_auditoria;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Tipo Auditoria almacenado(a) con exito (id_tipo_auditoria''||v_id_tipo_auditoria||'')'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_tipo_auditoria'',v_id_tipo_auditoria::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_TAU_MOD''
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		17-07-2019 13:23:26
	***********************************/

	elsif(p_transaccion=''SSOM_TAU_MOD'')then

		begin
			--Sentencia de la modificacion
			update ssom.ttipo_auditoria set
			descrip_tauditoria = v_parametros.descrip_tauditoria,
			tipo_auditoria = v_parametros.tipo_auditoria,
            codigo_tpo_aom = upper(v_parametros.codigo_tpo_aom),
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tipo_auditoria=v_parametros.id_tipo_auditoria;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Tipo Auditoria modificado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_tipo_auditoria'',v_parametros.id_tipo_auditoria::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_TAU_ELI''
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		17-07-2019 13:23:26
	***********************************/

	elsif(p_transaccion=''SSOM_TAU_ELI'')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.ttipo_auditoria
            where id_tipo_auditoria=v_parametros.id_tipo_auditoria;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',''Tipo Auditoria eliminado(a)'');
            v_resp = pxp.f_agrega_clave(v_resp,''id_tipo_auditoria'',v_parametros.id_tipo_auditoria::varchar);

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