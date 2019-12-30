CREATE OR REPLACE FUNCTION ssom.ft_probabilidad_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_probabilidad_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tprobabilidad'
   AUTOR: 		 (max.camacho)
   FECHA:	        16-12-2019 18:22:42
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				16-12-2019 18:22:42								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tprobabilidad'
   #
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_probabilidad	integer;

BEGIN

	v_nombre_funcion = 'ssom.ft_probabilidad_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_PROB_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 18:22:42
	***********************************/

	if(p_transaccion='SSOM_PROB_INS')then

		begin
			--Sentencia de la insercion
			insert into ssom.tprobabilidad(
				estado_reg,
				nombre_prob,
				desc_prob,
				id_usuario_reg,
				fecha_reg,
				id_usuario_ai,
				usuario_ai,
				id_usuario_mod,
				fecha_mod
			) values(
								'activo',
								v_parametros.nombre_prob,
								v_parametros.desc_prob,
								p_id_usuario,
								now(),
								v_parametros._id_usuario_ai,
								v_parametros._nombre_usuario_ai,
								null,
								null



							)RETURNING id_probabilidad into v_id_probabilidad;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Probabilidad almacenado(a) con exito (id_probabilidad'||v_id_probabilidad||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_probabilidad',v_id_probabilidad::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_PROB_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		16-12-2019 18:22:42
    ***********************************/

	elsif(p_transaccion='SSOM_PROB_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tprobabilidad set
																	nombre_prob = v_parametros.nombre_prob,
																	desc_prob = v_parametros.desc_prob,
																	id_usuario_mod = p_id_usuario,
																	fecha_mod = now(),
																	id_usuario_ai = v_parametros._id_usuario_ai,
																	usuario_ai = v_parametros._nombre_usuario_ai
			where id_probabilidad=v_parametros.id_probabilidad;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Probabilidad modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_probabilidad',v_parametros.id_probabilidad::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_PROB_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		16-12-2019 18:22:42
    ***********************************/

	elsif(p_transaccion='SSOM_PROB_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tprobabilidad
			where id_probabilidad=v_parametros.id_probabilidad;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Probabilidad eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_probabilidad',v_parametros.id_probabilidad::varchar);

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