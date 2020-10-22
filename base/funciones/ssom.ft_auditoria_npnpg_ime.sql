CREATE OR REPLACE FUNCTION ssom.ft_auditoria_npnpg_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_auditoria_npnpg_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tauditoria_npnpg'
   AUTOR: 		 (max.camacho)
   FECHA:	        25-07-2019 21:34:47
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				25-07-2019 21:34:47								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tauditoria_npnpg'
          #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion

   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_anpnpg	integer;

	v_cantidad				integer = 0;

BEGIN

	v_nombre_funcion = 'ssom.ft_auditoria_npnpg_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_APNP_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		25-07-2019 21:34:47
	***********************************/

	select count(id_anpnpg) into v_cantidad from ssom.tauditoria_npnpg where id_anpn = v_parametros.id_anpn and id_pregunta = v_parametros.id_pregunta;

	if(v_cantidad > 0) then
		RAISE EXCEPTION ' Ya tiene Registrado la pregunta no es posible asignar mas de una ves a un Punto de Norma...!!! ';
	end if;

	if(p_transaccion='SSOM_APNP_INS')then

		begin
			--Sentencia de la insercion
			insert into ssom.tauditoria_npnpg(
				pg_valoracion,
				obs_pg,
				id_pregunta,
				estado_reg,
				id_anpn,
				id_usuario_ai,
				fecha_reg,
				usuario_ai,
				id_usuario_reg,
				id_usuario_mod,
				fecha_mod
			) values(
								v_parametros.pg_valoracion,
								v_parametros.obs_pg,
								v_parametros.id_pregunta,
								'activo',
								v_parametros.id_anpn,
								v_parametros._id_usuario_ai,
								now(),
								v_parametros._nombre_usuario_ai,
								p_id_usuario,
								null,
								null



							)RETURNING id_anpnpg into v_id_anpnpg;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Puntos Norma Pregunta almacenado(a) con exito (id_anpnpg'||v_id_anpnpg||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_anpnpg',v_id_anpnpg::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_APNP_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		25-07-2019 21:34:47
    ***********************************/

	elsif(p_transaccion='SSOM_APNP_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tauditoria_npnpg set
																		 pg_valoracion = v_parametros.pg_valoracion,
																		 obs_pg = v_parametros.obs_pg,
																		 id_pregunta = v_parametros.id_pregunta,
																		 id_anpn = v_parametros.id_anpn,
																		 id_usuario_mod = p_id_usuario,
																		 fecha_mod = now(),
																		 id_usuario_ai = v_parametros._id_usuario_ai,
																		 usuario_ai = v_parametros._nombre_usuario_ai
			where id_anpnpg=v_parametros.id_anpnpg;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Puntos Norma Pregunta modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_anpnpg',v_parametros.id_anpnpg::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_APNP_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		25-07-2019 21:34:47
    ***********************************/

	elsif(p_transaccion='SSOM_APNP_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tauditoria_npnpg
			where id_anpnpg=v_parametros.id_anpnpg;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Puntos Norma Pregunta eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_anpnpg',v_parametros.id_anpnpg::varchar);

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
PARALLEL UNSAFE
COST 100;

ALTER FUNCTION ssom.ft_auditoria_npnpg_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;