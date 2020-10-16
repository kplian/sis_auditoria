CREATE OR REPLACE FUNCTION "ssom"."ft_repon_accion_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_repon_accion_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.trepon_accion'
 AUTOR: 		 (admin.miguel)
 FECHA:	        06-10-2020 15:21:07
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				06-10-2020 15:21:07								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.trepon_accion'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_repon_accion	integer;
			    
BEGIN

    v_nombre_funcion = 'ssom.ft_repon_accion_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_RAN_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin.miguel	
 	#FECHA:		06-10-2020 15:21:07
	***********************************/

	if(p_transaccion='SSOM_RAN_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ssom.trepon_accion(
			estado_reg,
			obs_dba,
			id_ap,
			id_funcionario,
			id_usuario_reg,
			fecha_reg,
			id_usuario_ai,
			usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.obs_dba,
			v_parametros.id_ap,
			v_parametros.id_funcionario,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_repon_accion into v_id_repon_accion;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Responsable Accion almacenado(a) con exito (id_repon_accion'||v_id_repon_accion||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_repon_accion',v_id_repon_accion::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_RAN_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin.miguel	
 	#FECHA:		06-10-2020 15:21:07
	***********************************/

	elsif(p_transaccion='SSOM_RAN_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.trepon_accion set
			obs_dba = v_parametros.obs_dba,
			id_ap = v_parametros.id_ap,
			id_funcionario = v_parametros.id_funcionario,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_repon_accion=v_parametros.id_repon_accion;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Responsable Accion modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_repon_accion',v_parametros.id_repon_accion::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_RAN_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin.miguel	
 	#FECHA:		06-10-2020 15:21:07
	***********************************/

	elsif(p_transaccion='SSOM_RAN_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.trepon_accion
            where id_repon_accion=v_parametros.id_repon_accion;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Responsable Accion eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_repon_accion',v_parametros.id_repon_accion::varchar);
              
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
ALTER FUNCTION "ssom"."ft_repon_accion_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
