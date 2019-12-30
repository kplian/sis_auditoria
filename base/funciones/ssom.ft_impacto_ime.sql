CREATE OR REPLACE FUNCTION ssom.ft_impacto_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_impacto_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.timpacto'
   AUTOR: 		 (max.camacho)
   FECHA:	        16-12-2019 18:31:26
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				16-12-2019 18:31:26								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.timpacto'
   #
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_impacto	integer;

BEGIN

	v_nombre_funcion = 'ssom.ft_impacto_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_IMP_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 18:31:26
	***********************************/

	if(p_transaccion='SSOM_IMP_INS')then

		begin
			--Sentencia de la insercion
			insert into ssom.timpacto(
				desc_imp,
				estado_reg,
				nombre_imp,
				id_usuario_ai,
				id_usuario_reg,
				fecha_reg,
				usuario_ai,
				id_usuario_mod,
				fecha_mod
			) values(
								v_parametros.desc_imp,
								'activo',
								v_parametros.nombre_imp,
								v_parametros._id_usuario_ai,
								p_id_usuario,
								now(),
								v_parametros._nombre_usuario_ai,
								null,
								null



							)RETURNING id_impacto into v_id_impacto;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Impacto almacenado(a) con exito (id_impacto'||v_id_impacto||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_impacto',v_id_impacto::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_IMP_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		16-12-2019 18:31:26
    ***********************************/

	elsif(p_transaccion='SSOM_IMP_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.timpacto set
														 desc_imp = v_parametros.desc_imp,
														 nombre_imp = v_parametros.nombre_imp,
														 id_usuario_mod = p_id_usuario,
														 fecha_mod = now(),
														 id_usuario_ai = v_parametros._id_usuario_ai,
														 usuario_ai = v_parametros._nombre_usuario_ai
			where id_impacto=v_parametros.id_impacto;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Impacto modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_impacto',v_parametros.id_impacto::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_IMP_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		16-12-2019 18:31:26
    ***********************************/

	elsif(p_transaccion='SSOM_IMP_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.timpacto
			where id_impacto=v_parametros.id_impacto;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Impacto eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_impacto',v_parametros.id_impacto::varchar);

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