CREATE OR REPLACE FUNCTION "ssom"."ft_parametro_config_auditoria_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_parametro_config_auditoria_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tparametro_config_auditoria'
 AUTOR: 		 (max.camacho)
 FECHA:	        20-08-2019 16:16:47
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				20-08-2019 16:16:47								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tparametro_config_auditoria'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_param_config_aom	integer;
			    
BEGIN

    v_nombre_funcion = 'ssom.ft_parametro_config_auditoria_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_PCAOM_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho	
 	#FECHA:		20-08-2019 16:16:47
	***********************************/

	if(p_transaccion='SSOM_PCAOM_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ssom.tparametro_config_auditoria(
			estado_reg,
			param_gestion,
			param_fecha_a,
			param_fecha_b,
			param_serie,
			param_estado_config,
			id_usuario_reg,
			fecha_reg,
			id_usuario_ai,
			usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.param_gestion,
			v_parametros.param_fecha_a,
			v_parametros.param_fecha_b,
			v_parametros.param_serie,
			v_parametros.param_estado_config,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_param_config_aom into v_id_param_config_aom;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Parametro Configuracion Auditoria almacenado(a) con exito (id_param_config_aom'||v_id_param_config_aom||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_param_config_aom',v_id_param_config_aom::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_PCAOM_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		max.camacho	
 	#FECHA:		20-08-2019 16:16:47
	***********************************/

	elsif(p_transaccion='SSOM_PCAOM_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tparametro_config_auditoria set
			param_gestion = v_parametros.param_gestion,
			param_fecha_a = v_parametros.param_fecha_a,
			param_fecha_b = v_parametros.param_fecha_b,
			param_serie = v_parametros.param_serie,
			param_estado_config = v_parametros.param_estado_config,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_param_config_aom=v_parametros.id_param_config_aom;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Parametro Configuracion Auditoria modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_param_config_aom',v_parametros.id_param_config_aom::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_PCAOM_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		max.camacho	
 	#FECHA:		20-08-2019 16:16:47
	***********************************/

	elsif(p_transaccion='SSOM_PCAOM_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tparametro_config_auditoria
            where id_param_config_aom=v_parametros.id_param_config_aom;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Parametro Configuracion Auditoria eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_param_config_aom',v_parametros.id_param_config_aom::varchar);
              
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ssom"."ft_parametro_config_auditoria_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
