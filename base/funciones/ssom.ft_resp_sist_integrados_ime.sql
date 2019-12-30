CREATE OR REPLACE FUNCTION ssom.ft_resp_sist_integrados_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_resp_sist_integrados_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tresp_sist_integrados'
 AUTOR: 		 (szambrana)
 FECHA:	        02-08-2019 13:18:19
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				02-08-2019 13:18:19								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tresp_sist_integrados'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_respsi	integer;
			    
BEGIN

    v_nombre_funcion = 'ssom.ft_resp_sist_integrados_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_RESSI_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-08-2019 13:18:19
	***********************************/

	if(p_transaccion='SSOM_RESSI_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ssom.tresp_sist_integrados(
			descrip_func,
			estado_reg,
			id_funcionario,
            id_si,
			id_usuario_ai,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.descrip_func,
			'activo',
			v_parametros.id_funcionario,
            v_parametros.id_si,
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			null,
			null
							
			
			
			)RETURNING id_respsi into v_id_respsi;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Responsables de Sistemas Integrados almacenado(a) con exito (id_respsi'||v_id_respsi||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_respsi',v_id_respsi::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_RESSI_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-08-2019 13:18:19
	***********************************/

	elsif(p_transaccion='SSOM_RESSI_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tresp_sist_integrados set
			descrip_func = v_parametros.descrip_func,
			id_funcionario = v_parametros.id_funcionario,
            id_si = v_parametros.id_si,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_respsi=v_parametros.id_respsi;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Responsables de Sistemas Integrados modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_respsi',v_parametros.id_respsi::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_RESSI_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-08-2019 13:18:19
	***********************************/

	elsif(p_transaccion='SSOM_RESSI_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tresp_sist_integrados
            where id_respsi=v_parametros.id_respsi;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Responsables de Sistemas Integrados eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_respsi',v_parametros.id_respsi::varchar);
              
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