CREATE OR REPLACE FUNCTION ssom.ft_tipo_norma_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_tipo_norma_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.ttipo_norma'
 AUTOR: 		 (szambrana)
 FECHA:	        02-07-2019 20:54:21
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				02-07-2019 20:54:21								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.ttipo_norma'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_tipo_norma	integer;
			    
BEGIN

    v_nombre_funcion = 'ssom.ft_tipo_norma_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_TIPNOR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-07-2019 20:54:21
	***********************************/

	if(p_transaccion='SSOM_TIPNOR_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ssom.ttipo_norma(
			descrip_tipo_norma,
			estado_reg,
			nombre_tipo_norma,
			id_usuario_ai,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.descrip_tipo_norma,
			'activo',
			v_parametros.nombre_tipo_norma,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_tipo_norma into v_id_tipo_norma;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Norma almacenado(a) con exito (id_tipo_norma'||v_id_tipo_norma||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_norma',v_id_tipo_norma::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_TIPNOR_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-07-2019 20:54:21
	***********************************/

	elsif(p_transaccion='SSOM_TIPNOR_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.ttipo_norma set
			descrip_tipo_norma = v_parametros.descrip_tipo_norma,
			nombre_tipo_norma = v_parametros.nombre_tipo_norma,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tipo_norma=v_parametros.id_tipo_norma;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Norma modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_norma',v_parametros.id_tipo_norma::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_TIPNOR_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-07-2019 20:54:21
	***********************************/

	elsif(p_transaccion='SSOM_TIPNOR_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.ttipo_norma
            where id_tipo_norma=v_parametros.id_tipo_norma;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Norma eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_norma',v_parametros.id_tipo_norma::varchar);
              
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