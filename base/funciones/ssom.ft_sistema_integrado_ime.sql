CREATE OR REPLACE FUNCTION ssom.ft_sistema_integrado_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_sistema_integrado_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tsistema_integrado'
 AUTOR: 		 (szambrana)
 FECHA:	        24-07-2019 21:09:26
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				24-07-2019 21:09:26								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tsistema_integrado'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_si	integer;
			    
BEGIN

    v_nombre_funcion = 'ssom.ft_sistema_integrado_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_SISINT_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		24-07-2019 21:09:26
	***********************************/

	if(p_transaccion='SSOM_SISINT_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ssom.tsistema_integrado(
			estado_reg,
			nombre_si,
			descrip_si,
			id_usuario_reg,
			fecha_reg,
			id_usuario_ai,
			usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.nombre_si,
			v_parametros.descrip_si,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_si into v_id_si;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sistemas Integrados almacenado(a) con exito (id_si'||v_id_si||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_si',v_id_si::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_SISINT_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		24-07-2019 21:09:26
	***********************************/

	elsif(p_transaccion='SSOM_SISINT_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tsistema_integrado set
			nombre_si = v_parametros.nombre_si,
			descrip_si = v_parametros.descrip_si,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_si=v_parametros.id_si;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sistemas Integrados modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_si',v_parametros.id_si::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_SISINT_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		24-07-2019 21:09:26
	***********************************/

	elsif(p_transaccion='SSOM_SISINT_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tsistema_integrado
            where id_si=v_parametros.id_si;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sistemas Integrados eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_si',v_parametros.id_si::varchar);
              
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