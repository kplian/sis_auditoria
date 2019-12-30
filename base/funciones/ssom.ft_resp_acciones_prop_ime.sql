CREATE OR REPLACE FUNCTION ssom.ft_resp_acciones_prop_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_resp_acciones_prop_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tresp_acciones_prop'
 AUTOR: 		 (szambrana)
 FECHA:	        17-09-2019 14:35:45
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				17-09-2019 14:35:45								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tresp_acciones_prop'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_respap	integer;
			    
BEGIN

    v_nombre_funcion = 'ssom.ft_resp_acciones_prop_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_RESAP_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		17-09-2019 14:35:45
	***********************************/

	if(p_transaccion='SSOM_RESAP_INS')then
					
        begin
        
        	--validamos que no se inserten duplicados
            if exists (  select 1
                          from ssom.tresp_acciones_prop rap
                          where  rap.id_ap = v_parametros.id_ap and rap.id_funcionario = v_parametros.id_funcionario)then
                          raise exception 'El funcionario responsable ya existe';
            end if;
                    
        	--Sentencia de la insercion
        	insert into ssom.tresp_acciones_prop(
			estado_reg,
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
			v_parametros.id_ap,
			v_parametros.id_funcionario,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_respap into v_id_respap;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Responsables de  almacenado(a) con exito (id_respap'||v_id_respap||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_respap',v_id_respap::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_RESAP_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		17-09-2019 14:35:45
	***********************************/

	elsif(p_transaccion='SSOM_RESAP_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tresp_acciones_prop set
			id_ap = v_parametros.id_ap,
			id_funcionario = v_parametros.id_funcionario,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_respap=v_parametros.id_respap;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Responsables de  modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_respap',v_parametros.id_respap::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_RESAP_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		17-09-2019 14:35:45
	***********************************/

	elsif(p_transaccion='SSOM_RESAP_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tresp_acciones_prop
            where id_respap=v_parametros.id_respap;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Responsables de  eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_respap',v_parametros.id_respap::varchar);
              
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