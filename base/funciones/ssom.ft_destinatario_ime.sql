CREATE OR REPLACE FUNCTION ssom.ft_destinatario_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_destinatario_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tdestinatario'
   AUTOR: 		 (max.camacho)
   FECHA:	        10-09-2019 23:09:14
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				10-09-2019 23:09:14								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tdestinatario'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_destinatario_aom	integer;
    v_revizar				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_destinatario_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_DEST_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		10-09-2019 23:09:14
	***********************************/

	if(p_transaccion='SSOM_DEST_INS')then

		begin
			--Sentencia de la insercion
			insert into ssom.tdestinatario(
			--	id_parametro,
				id_aom,
				id_funcionario,
				estado_reg,
				id_usuario_ai,
				fecha_reg,
				usuario_ai,
				id_usuario_reg,
				fecha_mod,
				id_usuario_mod
                ) values(
                 -- v_parametros.id_parametro,
                  v_parametros.id_aom,
                  v_parametros.id_funcionario,
                  'activo',
                  v_parametros._id_usuario_ai,
                  now(),
                  v_parametros._nombre_usuario_ai,
                  p_id_usuario,
                  null,
                  null
         		  )RETURNING id_destinatario_aom into v_id_destinatario_aom;

          --Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Destinatario almacenado(a) con exito (id_destinatario_aom'||v_id_destinatario_aom||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_destinatario_aom',v_id_destinatario_aom::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_DEST_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		10-09-2019 23:09:14
    ***********************************/

	elsif(p_transaccion='SSOM_DEST_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tdestinatario set
             -- id_parametro = v_parametros.id_parametro,
              id_aom = v_parametros.id_aom,
              id_funcionario = v_parametros.id_funcionario,
              fecha_mod = now(),
              id_usuario_mod = p_id_usuario,
              id_usuario_ai = v_parametros._id_usuario_ai,
              usuario_ai = v_parametros._nombre_usuario_ai
			where id_destinatario_aom=v_parametros.id_destinatario_aom;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Destinatario modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_destinatario_aom',v_parametros.id_destinatario_aom::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_DEST_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		10-09-2019 23:09:14
    ***********************************/

	elsif(p_transaccion='SSOM_DEST_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tdestinatario
			where id_destinatario_aom=v_parametros.id_destinatario_aom;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Destinatario eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_destinatario_aom',v_parametros.id_destinatario_aom::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

    /*********************************
     #TRANSACCION:   'SSOM_DCH_INS'
     #DESCRIPCION:	 check
     #AUTOR:		 MMV
     #FECHA:		 29/07/2020
    ***********************************/

	elsif(p_transaccion='SSOM_DCH_INS')then

		begin
			--Sentencia de la modificacion

            select de.incluir_informe into v_revizar
            from ssom.tdestinatario de
            where de.id_destinatario_aom = v_parametros.id_destinatario_aom;

            if (v_revizar = 'si') then

                update ssom.tdestinatario set
                incluir_informe = 'no'
                where id_destinatario_aom = v_parametros.id_destinatario_aom;

            end if;

            if (v_revizar = 'no') then

                update ssom.tdestinatario set
                incluir_informe = 'si'
                where id_destinatario_aom = v_parametros.id_destinatario_aom;

            end if;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Destinatario modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_destinatario_aom',v_parametros.id_destinatario_aom::varchar);

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

ALTER FUNCTION ssom.ft_destinatario_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;