CREATE OR REPLACE FUNCTION ssom.ft_auditoria_proceso_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_auditoria_proceso_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tauditoria_proceso'
   AUTOR: 		 (max.camacho)
   FECHA:	        25-07-2019 15:51:56
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				25-07-2019 15:51:56								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tauditoria_proceso'
   #
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_aproceso	integer;
	v_ap_valoracion varchar;
	v_obs_pcs		text;

	v_cantidad			integer = 0;

BEGIN

	v_nombre_funcion = 'ssom.ft_auditoria_proceso_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_AUPC_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		25-07-2019 15:51:56
	***********************************/
	select count(id_aproceso) into v_cantidad from ssom.tauditoria_proceso where id_aom = v_parametros.id_aom and id_proceso = v_parametros.id_proceso;

	if(v_cantidad > 0) then
		RAISE EXCEPTION ' Ya tiene Registrado el proceso no es posible asignar mas de una ves a una Auditoria...!!! ';
	end if;

	if(p_transaccion='SSOM_AUPC_INS')then

		begin

			if pxp.f_existe_parametro(p_tabla,'ap_valoracion') then
				v_ap_valoracion = v_parametros.ap_valoracion;
			else
				v_ap_valoracion = '';
			end if;

			if pxp.f_existe_parametro(p_tabla,'ap_valoracion') then
				v_obs_pcs = v_parametros.obs_pcs;
			else
				v_obs_pcs = '';
			end if;
			--Sentencia de la insercion
			insert into ssom.tauditoria_proceso(
				estado_reg,
				id_aom,
				id_proceso,
				ap_valoracion,
				obs_pcs,
				id_usuario_reg,
				fecha_reg,
				id_usuario_ai,
				usuario_ai,
				id_usuario_mod,
				fecha_mod
			) values(
								'activo',
								v_parametros.id_aom,
								v_parametros.id_proceso,
								v_ap_valoracion,
								v_obs_pcs,
								p_id_usuario,
								now(),
								v_parametros._id_usuario_ai,
								v_parametros._nombre_usuario_ai,
								null,
								null



							)RETURNING id_aproceso into v_id_aproceso;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Proceso almacenado(a) con exito (id_aproceso'||v_id_aproceso||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_aproceso',v_id_aproceso::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_AUPC_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		25-07-2019 15:51:56
    ***********************************/

	elsif(p_transaccion='SSOM_AUPC_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tauditoria_proceso set
																			 id_aom = v_parametros.id_aom,
																			 id_proceso = v_parametros.id_proceso,
																			 ap_valoracion = v_parametros.ap_valoracion,
																			 obs_pcs = v_parametros.obs_pcs,
																			 id_usuario_mod = p_id_usuario,
																			 fecha_mod = now(),
																			 id_usuario_ai = v_parametros._id_usuario_ai,
																			 usuario_ai = v_parametros._nombre_usuario_ai
			where id_aproceso=v_parametros.id_aproceso;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Proceso modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_aproceso',v_parametros.id_aproceso::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_AUPC_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		25-07-2019 15:51:56
    ***********************************/

	elsif(p_transaccion='SSOM_AUPC_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tauditoria_proceso
			where id_aproceso=v_parametros.id_aproceso;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Proceso eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_aproceso',v_parametros.id_aproceso::varchar);

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