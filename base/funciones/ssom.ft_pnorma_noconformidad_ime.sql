CREATE OR REPLACE FUNCTION ssom.ft_pnorma_noconformidad_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_pnorma_noconformidad_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tpnorma_noconformidad'
 AUTOR: 		 (szambrana)
 FECHA:	        19-07-2019 15:25:54
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				19-07-2019 15:25:54								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tpnorma_noconformidad'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_pnnc	integer;
    v_id_pn integer;

BEGIN

    v_nombre_funcion = 'ssom.ft_pnorma_noconformidad_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_PNNC_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana
 	#FECHA:		19-07-2019 15:25:54
	***********************************/

	if(p_transaccion='SSOM_PNNC_INS')then

        begin



         foreach v_id_pn in array string_to_array(v_parametros.id_pn,',')
           				 										loop

         insert into ssom.tpnorma_noconformidad(
			id_nc,
			estado_reg,
			id_pn,
			id_norma,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_nc,
			'activo',
			v_id_pn,
			v_parametros.id_norma,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null
			);

        end loop;

        	/*--validamos que no se inserten duplicados
            if exists (  select 1
                          from ssom.tpnorma_noconformidad no
                          where  no.id_nc = v_parametros.id_nc and no.id_pn = v_parametros.id_pn)then
                          raise exception 'El punto de norma ya existe';
            end if;

        	--Sentencia de la insercion
        	*/

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Puntos de norma para No Conformidades almacenado(a) con exito');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pnnc',v_id_pnnc::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_PNNC_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		19-07-2019 15:25:54
	***********************************/

	elsif(p_transaccion='SSOM_PNNC_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tpnorma_noconformidad set
			id_nc = v_parametros.id_nc,
			id_pn = v_parametros.id_pn,
			id_norma = v_parametros.id_norma,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_pnnc=v_parametros.id_pnnc;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Puntos de norma para No Conformidades modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pnnc',v_parametros.id_pnnc::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_PNNC_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana
 	#FECHA:		19-07-2019 15:25:54
	***********************************/

	elsif(p_transaccion='SSOM_PNNC_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tpnorma_noconformidad
            where id_pnnc=v_parametros.id_pnnc;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Puntos de norma para No Conformidades eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pnnc',v_parametros.id_pnnc::varchar);

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

ALTER FUNCTION ssom.ft_pnorma_noconformidad_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;