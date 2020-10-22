CREATE OR REPLACE FUNCTION ssom.ft_auditoria_npn_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_auditoria_npn_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tauditoria_npn'
   AUTOR: 		 (max.camacho)
   FECHA:	        25-07-2019 21:19:37
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				25-07-2019 21:19:37								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tauditoria_npn'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_anpn				integer;

	v_cantidad              integer = 0;
    v_id_pn					integer;

BEGIN

	v_nombre_funcion = 'ssom.ft_auditoria_npn_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_ANPN_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		25-07-2019 21:19:37
	***********************************/


	if(p_transaccion='SSOM_ANPN_INS')then

		begin


            foreach v_id_pn IN  array (string_to_array(v_parametros.id_pn::varchar,','))  loop

                --Sentencia de la insercion
                insert into ssom.tauditoria_npn(
                    estado_reg,
                    id_aom,--
                    id_pn,
                    id_norma,
                    fecha_reg,
                    usuario_ai,
                    id_usuario_reg,
                    id_usuario_ai,
                    id_usuario_mod,
                    fecha_mod
                ) values(
                    'activo',
                    v_parametros.id_aom,
                    v_id_pn, --v_parametros.id_pn,
                    v_parametros.id_norma,
                    now(),
                    v_parametros._nombre_usuario_ai,
                    p_id_usuario,
                    v_parametros._id_usuario_ai,
                    null,
                    null
                )RETURNING id_anpn into v_id_anpn;

            end loop;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Norma Punto de Norma almacenado(a) con exito (id_anpn'||v_id_anpn||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_anpn',v_id_anpn::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_ANPN_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		25-07-2019 21:19:37
    ***********************************/

	elsif(p_transaccion='SSOM_ANPN_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tauditoria_npn set
             id_aom = v_parametros.id_aom,---
             id_pn = v_parametros.id_pn::integer,
             id_norma = v_parametros.id_norma,
             id_usuario_mod = p_id_usuario,
             fecha_mod = now(),
             id_usuario_ai = v_parametros._id_usuario_ai,
             usuario_ai = v_parametros._nombre_usuario_ai
			where id_anpn=v_parametros.id_anpn;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Norma Punto de Norma modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_anpn',v_parametros.id_anpn::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

	/*********************************
     #TRANSACCION:  'SSOM_ANPN_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		25-07-2019 21:19:37
    ***********************************/

	elsif(p_transaccion='SSOM_ANPN_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tauditoria_npn
			where id_anpn=v_parametros.id_anpn;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Norma Punto de Norma eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_anpn',v_parametros.id_anpn::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

    /*********************************
     #TRANSACCION:  'SSOM_PNIN_INS'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		MMV
     #FECHA:		25-07-2019 21:19:37
    ***********************************/

	elsif(p_transaccion='SSOM_PNIN_INS')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tauditoria_npn
			where  id_aom = v_parametros.id_aom
            		and id_norma = v_parametros.id_norma;

             foreach v_id_pn IN  array (string_to_array(v_parametros.id_pn::varchar,','))  loop

                --Sentencia de la insercion
                insert into ssom.tauditoria_npn(
                    estado_reg,
                    id_aom,--
                    id_pn,
                    id_norma,
                    fecha_reg,
                    usuario_ai,
                    id_usuario_reg,
                    id_usuario_ai,
                    id_usuario_mod,
                    fecha_mod
                ) values(
                    'activo',
                    v_parametros.id_aom,
                    v_id_pn, --v_parametros.id_pn,
                    v_parametros.id_norma,
                    now(),
                    v_parametros._nombre_usuario_ai,
                    p_id_usuario,
                    v_parametros._id_usuario_ai,
                    null,
                    null
                );

            end loop;


			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Auditoria Norma Punto de Norma eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_anpn',v_parametros.id_aom::varchar);

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

ALTER FUNCTION ssom.ft_auditoria_npn_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;