CREATE OR REPLACE FUNCTION ssom.ft_pregunta_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_pregunta_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tpregunta'
 AUTOR: 		 (szambrana)
 FECHA:	        01-07-2019 19:04:06
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				01-07-2019 19:04:06								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tpregunta'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_pregunta	integer;
			    
BEGIN

    v_nombre_funcion = 'ssom.ft_pregunta_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_PRPTNOR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		01-07-2019 19:04:06
	***********************************/

	if(p_transaccion='SSOM_PRPTNOR_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ssom.tpregunta(
			nro_pregunta,
			descrip_pregunta,
			estado_reg,
			id_pn,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.nro_pregunta,
			v_parametros.descrip_pregunta,
			'activo',
			v_parametros.id_pn,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_pregunta into v_id_pregunta;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Preguntas para los Puntos de Norma almacenado(a) con exito (id_pregunta'||v_id_pregunta||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pregunta',v_id_pregunta::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_PRPTNOR_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		01-07-2019 19:04:06
	***********************************/

	elsif(p_transaccion='SSOM_PRPTNOR_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tpregunta set
			nro_pregunta = v_parametros.nro_pregunta,
			descrip_pregunta = v_parametros.descrip_pregunta,
			id_pn = v_parametros.id_pn,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_pregunta=v_parametros.id_pregunta;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Preguntas para los Puntos de Norma modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pregunta',v_parametros.id_pregunta::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_PRPTNOR_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		szambrana	
 	#FECHA:		01-07-2019 19:04:06
	***********************************/

	elsif(p_transaccion='SSOM_PRPTNOR_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tpregunta
            where id_pregunta=v_parametros.id_pregunta;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Preguntas para los Puntos de Norma eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pregunta',v_parametros.id_pregunta::varchar);
              
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