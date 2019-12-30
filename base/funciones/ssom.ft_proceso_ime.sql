CREATE OR REPLACE FUNCTION ssom.ft_proceso_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_proceso_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tproceso'
   AUTOR: 		 (max.camacho)
   FECHA:	        15-07-2019 20:16:48
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				15-07-2019 20:16:48								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tproceso'
   #
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_proceso	integer;

BEGIN

	v_nombre_funcion = 'ssom.ft_proceso_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_PCS_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		15-07-2019 20:16:48
	***********************************/

	if(p_transaccion='SSOM_PCS_INS')then

		begin
			--Sentencia de la insercion
			insert into ssom.tproceso(
				proceso,
				descrip_proceso,
				acronimo,
				estado_reg,
				id_responsable,
				codigo_proceso,
				vigencia,
				id_usuario_ai,
				usuario_ai,
				fecha_reg,
				id_usuario_reg,
				id_usuario_mod,
				fecha_mod
			) values(
								v_parametros.proceso,
								v_parametros.descrip_proceso,
								v_parametros.acronimo,
								'activo',
								v_parametros.id_responsable,
								v_parametros.codigo_proceso,
								v_parametros.vigencia,
								v_parametros._id_usuario_ai,
								v_parametros._nombre_usuario_ai,
								now(),
								p_id_usuario,
								null,
								null



							)RETURNING id_proceso into v_id_proceso;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Proceso Auditoria almacenado(a) con exito (id_proceso'||v_id_proceso||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_proceso',v_id_proceso::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_PCS_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		15-07-2019 20:16:48
    ***********************************/

	elsif(p_transaccion='SSOM_PCS_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tproceso set
														 proceso = v_parametros.proceso,
														 descrip_proceso = v_parametros.descrip_proceso,
														 acronimo = v_parametros.acronimo,
														 id_responsable = v_parametros.id_responsable,
														 codigo_proceso = v_parametros.codigo_proceso,
														 vigencia = v_parametros.vigencia,
														 id_usuario_mod = p_id_usuario,
														 fecha_mod = now(),
														 id_usuario_ai = v_parametros._id_usuario_ai,
														 usuario_ai = v_parametros._nombre_usuario_ai
			where id_proceso=v_parametros.id_proceso;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Proceso Auditoria modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_proceso',v_parametros.id_proceso::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_PCS_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		15-07-2019 20:16:48
    ***********************************/

	elsif(p_transaccion='SSOM_PCS_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tproceso
			where id_proceso=v_parametros.id_proceso;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Proceso Auditoria eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_proceso',v_parametros.id_proceso::varchar);

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