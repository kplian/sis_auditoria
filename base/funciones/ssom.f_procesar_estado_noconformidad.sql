CREATE OR REPLACE FUNCTION ssom.f_procesar_estado_noconformidad (
  p_id_usuario integer,
  p_id_usuario_ai integer,
  p_usuario_ai varchar,
  p_id_estado_wf integer,
  p_id_proceso_wf integer,
  p_codigo_estado varchar
)
RETURNS boolean AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.f_procesar_estado_noconformidad
 DESCRIPCION:   Funcion que devuelve conjuntos de registros sobre los estados de la 'ssom.tno_conformidad'
 AUTOR: 		SAZP
 FECHA:	        13-09-2019 13:52:11
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 
 ***************************************************************************/
DECLARE
  	v_nombre_funcion   	 			text;
    v_resp    			 			varchar;
    v_mensaje 			 			varchar;
	v_record						record;
    v_nro_registros_ap				integer;
    v_nro_ap_finalizado				integer;
    v_nro_ap_no_finalizados			integer;

BEGIN
  v_nombre_funcion = 'ssom.f_procesar_estado_noconformidad';
	
  	select  nc.id_nc,
    		nc.id_aom,
            nc.id_funcionario,
            nc.id_uo
            into
            v_record
    from ssom.tno_conformidad nc
    where nc.id_proceso_wf = p_id_proceso_wf;

  	if p_codigo_estado = 'vbnoconformidad' then
      	update ssom.tno_conformidad  set
            id_estado_wf = p_id_estado_wf,
            estado_wf = p_codigo_estado,
            id_usuario_mod = p_id_usuario,
            id_usuario_ai = p_id_usuario,
            usuario_ai = p_usuario_ai,
            fecha_mod = now()
        where id_proceso_wf = p_id_proceso_wf;
    elsif p_codigo_estado = 'correccion' then
        update ssom.tno_conformidad  set
            id_estado_wf = p_id_estado_wf,
            estado_wf = p_codigo_estado,
            id_usuario_mod = p_id_usuario,
            id_usuario_ai = p_id_usuario,
            usuario_ai = p_usuario_ai,
            fecha_mod = now()
        where id_proceso_wf = p_id_proceso_wf;
          
    elsif p_codigo_estado = 'finalizado' then    
    --li
        select count(cc.id_ap) into v_nro_registros_ap
        from ssom.taccion_propuesta cc
        where cc.id_nc = v_record.id_nc; 

        -- si no hay ap
    	if v_nro_registros_ap = 0 then
        	raise exception 'No introdujo acciones propuestas,...por lo menos debe haber una';
        end if;		
                
        --fin si no hay ap
        
        select count(cc.id_ap) into v_nro_ap_finalizado
        from ssom.taccion_propuesta cc
        where cc.id_nc = v_record.id_nc
        and cc.estado_wf = 'finalizado';
    
    
     	select count(cc.id_ap) into v_nro_ap_no_finalizados
        from ssom.taccion_propuesta cc
        where cc.id_nc = v_record.id_nc
        and cc.estado_wf != 'finalizado';
        
    	if v_nro_registros_ap != v_nro_ap_finalizado then
        	raise exception 'Tiene (%) Acciones pendientes',v_nro_ap_no_finalizados;
        end if;
    --lf
    	update ssom.tno_conformidad  set
            id_estado_wf = p_id_estado_wf,
            estado_wf = p_codigo_estado,
            id_usuario_mod = p_id_usuario,
            id_usuario_ai = p_id_usuario,
            usuario_ai = p_usuario_ai,
            fecha_mod = now()
        where id_proceso_wf = p_id_proceso_wf;
   	end if;
   
   
   
   
  return true;
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