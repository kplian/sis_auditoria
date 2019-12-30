CREATE OR REPLACE FUNCTION ssom.ft_si_noconformidad_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_si_noconformidad_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tsi_noconformidad'
 AUTOR: 		 (szambrana)
 FECHA:	        09-08-2019 15:16:47
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				09-08-2019 15:16:47								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tsi_noconformidad'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_sinc	integer;
			    
BEGIN

    v_nombre_funcion = 'ssom.ft_si_noconformidad_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_SINOCONF_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		09-08-2019 15:16:47
	***********************************/

	if(p_transaccion='SSOM_SINOCONF_INS')then
					
        begin
        	--validamos que no se inserten duplicados

            if exists (  select 1
                          from ssom.tsi_noconformidad si
                          where  si.id_nc = v_parametros.id_nc and si.id_si = v_parametros.id_si)then
                          raise exception 'El Sistema integrado ya existe';
            end if;
			        
        	--Sentencia de la insercion
        	insert into ssom.tsi_noconformidad(
			estado_reg,
			id_nc,
			id_si,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.id_nc,
			v_parametros.id_si,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_sinc into v_id_sinc;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sist. Integrados para no conformidades almacenado(a) con exito (id_sinc'||v_id_sinc||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sinc',v_id_sinc::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_SINOCONF_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		09-08-2019 15:16:47
	***********************************/

	elsif(p_transaccion='SSOM_SINOCONF_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tsi_noconformidad set
			id_nc = v_parametros.id_nc,
			id_si = v_parametros.id_si,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_sinc=v_parametros.id_sinc;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sist. Integrados para no conformidades modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sinc',v_parametros.id_sinc::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_SINOCONF_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		09-08-2019 15:16:47
	***********************************/

	elsif(p_transaccion='SSOM_SINOCONF_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tsi_noconformidad
            where id_sinc=v_parametros.id_sinc;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sist. Integrados para no conformidades eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sinc',v_parametros.id_sinc::varchar);
              
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