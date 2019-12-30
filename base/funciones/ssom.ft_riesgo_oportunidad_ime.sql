CREATE OR REPLACE FUNCTION ssom.ft_riesgo_oportunidad_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_riesgo_oportunidad_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.triesgo_oportunidad'
   AUTOR: 		 (max.camacho)
   FECHA:	        16-12-2019 17:57:34
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				16-12-2019 17:57:34								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.triesgo_oportunidad'
   #
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_ro	integer;

BEGIN

	v_nombre_funcion = 'ssom.ft_riesgo_oportunidad_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_RIOP_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 17:57:34
	***********************************/

	if(p_transaccion='SSOM_RIOP_INS')then

		begin
			--Sentencia de la insercion
			insert into ssom.triesgo_oportunidad(
				id_tipo_ro,
				nombre_ro,
				codigo_ro,
				estado_reg,
				id_usuario_ai,
				usuario_ai,
				fecha_reg,
				id_usuario_reg,
				fecha_mod,
				id_usuario_mod
			) values(
								v_parametros.id_tipo_ro,
								v_parametros.nombre_ro,
								v_parametros.codigo_ro,
								'activo',
								v_parametros._id_usuario_ai,
								v_parametros._nombre_usuario_ai,
								now(),
								p_id_usuario,
								null,
								null



							)RETURNING id_ro into v_id_ro;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Riesgo Oportunidad almacenado(a) con exito (id_ro'||v_id_ro||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_ro',v_id_ro::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_RIOP_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		16-12-2019 17:57:34
    ***********************************/

	elsif(p_transaccion='SSOM_RIOP_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.triesgo_oportunidad set
																				id_tipo_ro = v_parametros.id_tipo_ro,
																				nombre_ro = v_parametros.nombre_ro,
																				codigo_ro = v_parametros.codigo_ro,
																				fecha_mod = now(),
																				id_usuario_mod = p_id_usuario,
																				id_usuario_ai = v_parametros._id_usuario_ai,
																				usuario_ai = v_parametros._nombre_usuario_ai
			where id_ro=v_parametros.id_ro;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Riesgo Oportunidad modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_ro',v_parametros.id_ro::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_RIOP_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		16-12-2019 17:57:34
    ***********************************/

	elsif(p_transaccion='SSOM_RIOP_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.triesgo_oportunidad
			where id_ro=v_parametros.id_ro;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Riesgo Oportunidad eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_ro',v_parametros.id_ro::varchar);

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