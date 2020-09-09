CREATE OR REPLACE FUNCTION "ssom"."ft_competencia_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_competencia_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tcompetencia'
 AUTOR: 		 (admin.miguel)
 FECHA:	        03-09-2020 16:11:08
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-09-2020 16:11:08								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tcompetencia'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_competencia	integer;
			    
BEGIN

    v_nombre_funcion = 'ssom.ft_competencia_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_COA_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin.miguel	
 	#FECHA:		03-09-2020 16:11:08
	***********************************/

	if(p_transaccion='SSOM_COA_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ssom.tcompetencia(
			estado_reg,
			obs_dba,
			id_equipo_auditores,
			id_norma,
			nro_auditorias,
			hras_formacion,
			meses_actualizacion,
			calificacion,
			id_usuario_reg,
			fecha_reg,
			id_usuario_ai,
			usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.obs_dba,
			v_parametros.id_equipo_auditores,
			v_parametros.id_norma,
			v_parametros.nro_auditorias,
			v_parametros.hras_formacion,
			v_parametros.meses_actualizacion,
			v_parametros.calificacion,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_competencia into v_id_competencia;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Competencia almacenado(a) con exito (id_competencia'||v_id_competencia||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_competencia',v_id_competencia::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_COA_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin.miguel	
 	#FECHA:		03-09-2020 16:11:08
	***********************************/

	elsif(p_transaccion='SSOM_COA_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tcompetencia set
			obs_dba = v_parametros.obs_dba,
			id_equipo_auditores = v_parametros.id_equipo_auditores,
			id_norma = v_parametros.id_norma,
			nro_auditorias = v_parametros.nro_auditorias,
			hras_formacion = v_parametros.hras_formacion,
			meses_actualizacion = v_parametros.meses_actualizacion,
			calificacion = v_parametros.calificacion,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_competencia=v_parametros.id_competencia;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Competencia modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_competencia',v_parametros.id_competencia::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_COA_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin.miguel	
 	#FECHA:		03-09-2020 16:11:08
	***********************************/

	elsif(p_transaccion='SSOM_COA_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tcompetencia
            where id_competencia=v_parametros.id_competencia;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Competencia eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_competencia',v_parametros.id_competencia::varchar);
              
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
ALTER FUNCTION "ssom"."ft_competencia_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
