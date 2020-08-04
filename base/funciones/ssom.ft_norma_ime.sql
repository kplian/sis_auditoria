CREATE OR REPLACE FUNCTION ssom.ft_norma_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_norma_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tnorma'
 AUTOR: 		 (szambrana)
 FECHA:	        02-07-2019 19:11:48
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				02-07-2019 19:11:48								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tnorma'	
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_norma	integer;

BEGIN

    v_nombre_funcion = 'ssom.ft_norma_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_NOR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana
 	#FECHA:		02-07-2019 19:11:48
	***********************************/

	if(p_transaccion='SSOM_NOR_INS')then

        begin
        	--Sentencia de la insercion
        	insert into ssom.tnorma(
			id_parametro,
			estado_reg,
			nombre_norma,
			sigla_norma,
			descrip_norma,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_parametro,
			'activo',
			v_parametros.nombre_norma,
			v_parametros.sigla_norma,
			v_parametros.descrip_norma,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null



			)RETURNING id_norma into v_id_norma;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Gestión de Normas almacenado(a) con exito (id_norma'||v_id_norma||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_norma',v_id_norma::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/**********************************
 	#TRANSACCION:  'SSOM_NOR_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		02-07-2019 19:11:48
	***********************************/

	elsif(p_transaccion='SSOM_NOR_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tnorma set
			id_parametro = v_parametros.id_parametro,
			nombre_norma = v_parametros.nombre_norma,
			sigla_norma = v_parametros.sigla_norma,
			descrip_norma = v_parametros.descrip_norma,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_norma=v_parametros.id_norma;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Gestión de Normas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_norma',v_parametros.id_norma::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_NOR_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		02-07-2019 19:11:48
	***********************************/

	elsif(p_transaccion='SSOM_NOR_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tnorma
            where id_norma=v_parametros.id_norma;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Gestión de Normas eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_norma',v_parametros.id_norma::varchar);

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

ALTER FUNCTION ssom.ft_norma_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;