CREATE OR REPLACE FUNCTION ssom.ft_actividad_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_actividad_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tactividad'
   AUTOR: 		 (max.camacho)
   FECHA:	        05-08-2019 13:33:31
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				05-08-2019 13:33:31								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tactividad'
   #
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_actividad	integer;

BEGIN

	v_nombre_funcion = 'ssom.ft_actividad_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_ATV_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		05-08-2019 13:33:31
	***********************************/

	if(p_transaccion='SSOM_ATV_INS')then

		begin
			--Sentencia de la insercion
			insert into ssom.tactividad(
				actividad,
				codigo_actividad,
				obs_actividad,
				estado_reg,
				id_usuario_reg,
				fecha_reg,
				id_usuario_ai,
				usuario_ai,
				id_usuario_mod,
				fecha_mod
			) values(
								v_parametros.actividad,
								v_parametros.codigo_actividad,
								v_parametros.obs_actividad,
								'activo',
								p_id_usuario,
								now(),
								v_parametros._id_usuario_ai,
								v_parametros._nombre_usuario_ai,
								null,
								null



							)RETURNING id_actividad into v_id_actividad;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Actividad almacenado(a) con exito (id_actividad'||v_id_actividad||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_actividad',v_id_actividad::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_ATV_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		05-08-2019 13:33:31
    ***********************************/

	elsif(p_transaccion='SSOM_ATV_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tactividad set
															 actividad = v_parametros.actividad,
															 codigo_actividad = v_parametros.codigo_actividad,
															 obs_actividad = v_parametros.obs_actividad,
															 id_usuario_mod = p_id_usuario,
															 fecha_mod = now(),
															 id_usuario_ai = v_parametros._id_usuario_ai,
															 usuario_ai = v_parametros._nombre_usuario_ai
			where id_actividad=v_parametros.id_actividad;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Actividad modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_actividad',v_parametros.id_actividad::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_ATV_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		05-08-2019 13:33:31
    ***********************************/

	elsif(p_transaccion='SSOM_ATV_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tactividad
			where id_actividad=v_parametros.id_actividad;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Actividad eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_actividad',v_parametros.id_actividad::varchar);

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