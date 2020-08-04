CREATE OR REPLACE FUNCTION ssom.ft_punto_norma_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_punto_norma_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tpunto_norma'
 AUTOR: 		 (szambrana)
 FECHA:	        01-07-2019 18:45:10
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				01-07-2019 18:45:10								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tpunto_norma'	
    #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion

 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_pn	integer;

BEGIN

    v_nombre_funcion = 'ssom.ft_punto_norma_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_PTONOR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana
 	#FECHA:		01-07-2019 18:45:10
	***********************************/

	if(p_transaccion='SSOM_PTONOR_INS')then

        begin
        	--Sentencia de la insercion
        	insert into ssom.tpunto_norma(
			id_norma,
			nombre_pn,
			codigo_pn,
			descrip_pn,
			estado_reg,
			id_usuario_ai,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_norma,
			v_parametros.nombre_pn,
			v_parametros.codigo_pn,
			v_parametros.descrip_pn,
			'activo',
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			null,
			null



			)RETURNING id_pn into v_id_pn;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Puntos de Norma almacenado(a) con exito (id_pn'||v_id_pn||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pn',v_id_pn::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_PTONOR_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		01-07-2019 18:45:10
	***********************************/

	elsif(p_transaccion='SSOM_PTONOR_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tpunto_norma set
			id_norma = v_parametros.id_norma,
			nombre_pn = v_parametros.nombre_pn,
			codigo_pn = v_parametros.codigo_pn,
			descrip_pn = v_parametros.descrip_pn,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_pn=v_parametros.id_pn;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Puntos de Norma modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pn',v_parametros.id_pn::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_PTONOR_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		01-07-2019 18:45:10
	***********************************/

	elsif(p_transaccion='SSOM_PTONOR_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tpunto_norma
            where id_pn=v_parametros.id_pn;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Puntos de Norma eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pn',v_parametros.id_pn::varchar);

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

ALTER FUNCTION ssom.ft_punto_norma_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;