CREATE OR REPLACE FUNCTION ssom.f_id_estado_sigue (
  p_id_proceso_wf integer,
  p_operacion varchar,
  p_id_usuario integer
)
RETURNS integer AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.f_id_estado_sigue
 DESCRIPCION:   Funcion nos devuelve el id del estado siguiente, usado en el paso de varios registros a un estado determinado 
 AUTOR: 		SAZP
 FECHA:	        20-12-2019 16:36:51
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
 #ISSUE				FECHA				AUTOR				DESCRIPCION


 ***************************************************************************/
DECLARE
	v_resp                      varchar;
   	v_nombre_funcion            text;
   	v_registros     			record;
   	v_res_validacion    		text;
   	v_documentos        		record;
   	v_num_estados 				integer;
   	v_num_funcionarios 			bigint;
   	v_num_deptos 				integer;
   
    va_id_tipo_estado 			integer [];
    va_codigo_estado 			varchar [];
    va_disparador 				varchar [];
    va_regla 					varchar [];
    va_prioridad 				integer [];
    va_id_depto 				integer [];
    v_id_depto_estado 			integer;


BEGIN
          v_nombre_funcion = 'ssom.f_id_estado_sigue';
          select
                  pw.id_proceso_wf,
                  ew.id_estado_wf,
                  te.codigo,
                  pw.fecha_ini,
                  te.id_tipo_estado,
                  te.pedir_obs,
                  pw.nro_tramite
                into 
                  v_registros
          from wf.tproceso_wf pw
          inner join wf.testado_wf ew  on ew.id_proceso_wf = pw.id_proceso_wf and ew.estado_reg = 'activo'
          inner join wf.ttipo_estado te on ew.id_tipo_estado = te.id_tipo_estado
          where pw.id_proceso_wf = p_id_proceso_wf;          

          v_res_validacion = wf.f_valida_cambio_estado(v_registros.id_estado_wf,NULL,NULL,p_id_usuario);
          raise notice 'v_res_validacion %',v_res_validacion;
          
          if  (v_res_validacion IS NOT NULL AND v_res_validacion != '') then
          		raise exception  'Es necesario registrar los siguientes campos en el formulario: %',v_res_validacion;
          end if;
          
          --validacion de documentos           
          for v_documentos in (
              	select
                    dwf.id_documento_wf,                    
                    dwf.id_tipo_documento,
                    wf.f_priorizar_documento(p_id_proceso_wf , p_id_usuario
                         ,dwf.id_tipo_documento,'ASC' ) as priorizacion
                from wf.tdocumento_wf dwf
                inner join wf.tproceso_wf pw on pw.id_proceso_wf = dwf.id_proceso_wf
                where  pw.nro_tramite = COALESCE(v_registros.nro_tramite,'--')) loop
                
                if (v_documentos.priorizacion in (0,9)) then
                   raise exception 'Es necesario subir algun(os) documento(s) antes de pasar al siguiente estado';
                end if;
          
          end loop;
         ------------------------------------------------------------------------------------------------------- 
         -- Verifica  los posibles estados sigueintes para que desde la interfaz se tome la decision si es necesario
         ------------------------------------------------------------------------------------------------------
          IF  p_operacion = 'verificar' THEN
          
                  v_num_estados=0;
                  v_num_funcionarios=0;
                  v_num_deptos=0;
                  
                  --------------------------------- 
              
                 SELECT  
                     ps_id_tipo_estado,
                     ps_codigo_estado,
                     ps_disparador,
                     ps_regla,
                     ps_prioridad
                 into
                    va_id_tipo_estado,
                    va_codigo_estado,
                    va_disparador,
                    va_regla,
                    va_prioridad
                
                FROM wf.f_obtener_estado_wf(
                v_registros.id_proceso_wf,
                 NULL,
                 v_registros.id_tipo_estado,
                 'siguiente',
                 p_id_usuario); 
         
                raise notice 'verifica';
                
                v_num_estados= array_length(va_id_tipo_estado, 1);
          
                 raise notice 'verificamos el numero de deptos';
                 raise notice 'va_id_tipo_estado[1] %', va_id_tipo_estado[1]; 
                                            
                  SELECT 
                  *
                  into
                    v_num_deptos 
                 FROM wf.f_depto_wf_sel(
                     p_id_usuario, 
                     va_id_tipo_estado[1], 
                     v_registros.fecha_ini,
                     v_registros.id_estado_wf,
                     TRUE) AS (total bigint);

                --recupera el depto   
                IF v_num_deptos >= 1 THEN
                  
                  SELECT 
                       id_depto
                         into
                       v_id_depto_estado
                  FROM wf.f_depto_wf_sel(
                       p_id_usuario, 
                       va_id_tipo_estado[1], 
                       v_registros.fecha_ini,
                       v_registros.id_estado_wf,
                       FALSE) 
                       AS (id_depto integer,
                         codigo_depto varchar,
                         nombre_corto_depto varchar,
                         nombre_depto varchar,
                         prioridad integer,
                         subsistema varchar);
               
                END IF;
                 -- si solo hay un estado,  verificamos si tiene mas de un funcionario por este estado
                 raise notice ' si solo hay un estado';
                 --RAISE EXCEPTION 'xxxxsssshollllllllllll  %',v_parametros;
                   SELECT 
                   *
                    into
                   v_num_funcionarios 
                   FROM wf.f_funcionario_wf_sel(
                       p_id_usuario, 
                       va_id_tipo_estado[1], 
                       v_registros.fecha_ini,
                       v_registros.id_estado_wf,
                       TRUE,1,0,'0=0', COALESCE(v_id_depto_estado,0)) AS (total bigint);              
                                             ---raise exception 'entra';

                  
           END IF;
                             
          --Devuelve la respuesta
            return va_id_tipo_estado[1];

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
STABLE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;