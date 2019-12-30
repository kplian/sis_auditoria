CREATE OR REPLACE FUNCTION ssom.ft_tipo_parametro_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_tipo_parametro_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.ttipo_parametro'
   AUTOR: 		 (max.camacho)
   FECHA:	        03-07-2019 13:09:09
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				03-07-2019 13:09:09								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.ttipo_parametro'
   #
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_tipo_parametro	integer;

BEGIN

	v_nombre_funcion = 'ssom.ft_tipo_parametro_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_TPR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		03-07-2019 13:09:09
	***********************************/

	if(p_transaccion='SSOM_TPR_INS')then

		begin
			--Sentencia de la insercion
			insert into ssom.ttipo_parametro(
				tipo_parametro,
				descrip_parametro,
				estado_reg,
				id_usuario_ai,
				usuario_ai,
				fecha_reg,
				id_usuario_reg,
				fecha_mod,
				id_usuario_mod
			) values(
								v_parametros.tipo_parametro,
								v_parametros.descrip_parametro,
								'activo',
								v_parametros._id_usuario_ai,
								v_parametros._nombre_usuario_ai,
								now(),
								p_id_usuario,
								null,
								null



							)RETURNING id_tipo_parametro into v_id_tipo_parametro;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo Parametro almacenado(a) con exito (id_tipo_parametro'||v_id_tipo_parametro||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_parametro',v_id_tipo_parametro::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_TPR_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		03-07-2019 13:09:09
    ***********************************/

	elsif(p_transaccion='SSOM_TPR_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.ttipo_parametro set
																		tipo_parametro = v_parametros.tipo_parametro,
																		descrip_parametro = v_parametros.descrip_parametro,
																		fecha_mod = now(),
																		id_usuario_mod = p_id_usuario,
																		id_usuario_ai = v_parametros._id_usuario_ai,
																		usuario_ai = v_parametros._nombre_usuario_ai
			where id_tipo_parametro=v_parametros.id_tipo_parametro;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo Parametro modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_parametro',v_parametros.id_tipo_parametro::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_TPR_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		03-07-2019 13:09:09
    ***********************************/

	elsif(p_transaccion='SSOM_TPR_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.ttipo_parametro
			where id_tipo_parametro=v_parametros.id_tipo_parametro;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo Parametro eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_parametro',v_parametros.id_tipo_parametro::varchar);

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
	COST 100;