CREATE OR REPLACE FUNCTION ssom.ft_no_conformidad_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_no_conformidad_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tno_conformidad'
 AUTOR: 		 (szambrana)
 FECHA:	        04-07-2019 19:53:16
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				04-07-2019 19:53:16								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tno_conformidad'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
    v_id_parametro 		integer;
    v_filtro			varchar;
    v_id_uo				integer;
			    
BEGIN

	v_nombre_funcion = 'ssom.ft_no_conformidad_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_NOCONF_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana	
 	#FECHA:		04-07-2019 19:53:16
	***********************************/

	if(p_transaccion='SSOM_NOCONF_SEL')then
     				
    	begin
                  

    
    		--Sentencia de la consulta
            
            ---raise exception '%',v_parametros.tipo_interfaz;
            v_filtro = '';
         	if v_parametros.tipo_interfaz = 'registroNoConformidad' then
            		--filtro por admin ve todo los registros de los usuarios
                     
                     v_filtro = 'noconf.estado_wf = ''propuesta''and';
                     
                     --filtro por usuario solo puede ver sus propios registros
             		if  p_administrador <> 1 then
                    	 v_filtro = 'noconf.estado_wf = ''propuesto''and usu1.cuenta = '||p_id_usuario||'and';
                    end if;
            end if;
            
			v_consulta:='select
                        noconf.id_nc,
                        noconf.obs_consultor,
                        noconf.estado_reg,
                        noconf.evidencia,
                        noconf.id_funcionario,
                        noconf.id_uo,
                        noconf.descrip_nc,
                        noconf.id_parametro,
                        noconf.obs_resp_area,
                        noconf.id_aom,
                        noconf.fecha_reg,
                        noconf.usuario_ai,
                        noconf.id_usuario_reg,
                        noconf.id_usuario_ai,
                        noconf.id_usuario_mod,
                        noconf.fecha_mod,
                        noconf.id_uo_adicional,
			    		noconf.id_proceso_wf,	--integrar con wf new
						noconf.id_estado_wf, 	--integrar con wf new
						noconf.nro_tramite, 	--integrar con wf new
						noconf.estado_wf, 		--integrar con wf new
                        noconf.codigo_nc,
                        noconf.id_funcionario_nc,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod	,
                        aom1.descrip_aom1 as nombreAom,
                        param.valor_parametro,
                        unorg1.nombre_unidad as gerencia_uo1, 
                        unorg2.nombre_unidad as gerencia_uo2,      
                        ofunc.desc_funcionario1 as funcionario_uo,
                        (select count(*)
                               from unnest(id_tipo_estado_wfs) elemento
                               where elemento = ew.id_tipo_estado)::integer  as contador_estados,
                               rfun.desc_funcionario1 as funcionario_resp
                        from ssom.tno_conformidad noconf
                        inner join segu.tusuario usu1 on usu1.id_usuario = noconf.id_usuario_reg
                        left join segu.tusuario usu2 on usu2.id_usuario = noconf.id_usuario_mod
                        left join ssom.tauditoria_oportunidad_mejora aom1 on aom1.id_aom = noconf.id_aom
                        join ssom.tparametro param on param.id_parametro = noconf.id_parametro
                        inner join orga.tuo unorg1 on unorg1.id_uo = noconf.id_uo
                        left join orga.tuo unorg2 on unorg2.id_uo = noconf.id_uo_adicional --aumentado                        
                        join orga.vfuncionario ofunc on ofunc.id_funcionario = noconf.id_funcionario
                        left join wf.tproceso_wf pw on pw.id_proceso_wf = noconf.id_proceso_wf  	--borrar
                        left join wf.testado_wf ew on ew.id_estado_wf = noconf.id_estado_wf 		--para integrar con nuevo wf
                        left join orga.vfuncionario rfun on rfun.id_funcionario = noconf.id_funcionario_nc
				        where  '||v_filtro;
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_NOCONF_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana	
 	#FECHA:		04-07-2019 19:53:16
	***********************************/

	elsif(p_transaccion='SSOM_NOCONF_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
            v_filtro = '';
         	if v_parametros.tipo_interfaz = 'registroNoConformidad' then
                   v_filtro = 'noconf.estado_wf = ''propuesta''and';
             		if  p_administrador <> 1then
                    	 v_filtro = 'noconf.estado_wf = ''propuesto''and usu1.cuenta = '||p_id_usuario||'and';
                    end if;
            end if;
			v_consulta:='select count(id_nc)
                        from ssom.tno_conformidad noconf
                        inner join segu.tusuario usu1 on usu1.id_usuario = noconf.id_usuario_reg
                        left join segu.tusuario usu2 on usu2.id_usuario = noconf.id_usuario_mod
                        left join ssom.tauditoria_oportunidad_mejora aom1 on aom1.id_aom = noconf.id_aom
                        join ssom.tparametro param on param.id_parametro = noconf.id_parametro
                        left join orga.tuo unorg on unorg.id_uo = noconf.id_uo
                        join orga.vfuncionario ofunc on ofunc.id_funcionario = noconf.id_funcionario
                        left join wf.tproceso_wf pw on pw.id_proceso_wf = noconf.id_proceso_wf
                        left join wf.testado_wf ew on ew.id_estado_wf = noconf.id_estado_wf
                        left join orga.vfuncionario rfun on rfun.id_funcionario = noconf.id_funcionario_nc
					    where '||v_filtro;
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
	
    /*********Vamos a meter una linea SSS****/
    
    /*********************************    
 	#TRANSACCION:  'SSOM_USU_SEL'
 	#DESCRIPCION:	sel de registros
 	#AUTOR:		szambrana	
 	#FECHA:		04-07-2019 19:53:16
	***********************************/
    elsif(p_transaccion='SSOM_USU_SEL')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='SELECT 
                          ofunc.id_uo_funcionario,
                          ofunc.id_funcionario,
                          ofunc.desc_funcionario1,
                          ofunc.desc_funcionario2,
                          ofunc.id_uo,
                          ofunc.nombre_cargo,
                          ofunc.fecha_asignacion,
                          ofunc.fecha_finalizacion,
                          ofunc.num_doc,
                          ofunc.ci,
                          ofunc.codigo,
                          ofunc.email_empresa,
                          ofunc.estado_reg_fun,
                          ofunc.estado_reg_asi,
                          ofunc.id_cargo,
                          ofunc.descripcion_cargo,
                          ofunc.cargo_codigo,
                          ofunc.nombre_unidad
                          FROM orga.vfuncionario_cargo ofunc
					      WHERE ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;
	/*********************************    
 	#TRANSACCION:  'SSOM_USU_CONT'
 	#DESCRIPCION:	sel de registros
 	#AUTOR:		szambrana	
 	#FECHA:		04-07-2019 19:53:16
	***********************************/
    elsif(p_transaccion='SSOM_USU_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='SELECT 
            				count(ofunc.id_funcionario)
                         FROM orga.vfuncionario_cargo ofunc
					      where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
	
    
	/*********************************    
 	#TRANSACCION:  'SSOM_RPT_NOCONF'
 	#DESCRIPCION:	reporte de registros
 	#AUTOR:		szambrana	
 	#FECHA:		27-09-2019 19:53:16
	***********************************/
    elsif(p_transaccion='SSOM_RPT_NOCONF')then

		begin
            select mw.id_parametro into v_id_parametro
            from ssom.tdestinatario mw
            inner join ssom.tparametro pa on pa.id_parametro = mw.id_parametro
            where mw.id_aom = v_parametros.id_aom and  pa.valor_parametro = 'Responsable';
            v_consulta:= 'SELECT 
                            aom.id_aom,
                            aom.nombre_aom1,
                            aom.nro_tramite_wf,
                            vfu1.desc_funcionario1 as auditor,
                            vfu1.nombre_unidad as nombre_uo,
                            vfu2.desc_funcionario1 as destinatario,
                            par2.valor_parametro as tipo_miembro,
                            nc.id_nc,
                            par1.valor_parametro as tipo_no_conf,
                            nc.descrip_nc,
                            nc.evidencia,
                            nc.obs_resp_area,
                            nc.obs_consultor,
                            vfu3.desc_funcionario1 as resp_area_no_conf,
                            nc.id_uo_adicional
                            FROM ssom.tauditoria_oportunidad_mejora aom
                            INNER JOIN ssom.tno_conformidad nc ON aom.id_aom = nc.id_aom
                            LEFT JOIN ssom.tdestinatario des ON aom.id_aom = des.id_aom
                            INNER JOIN ssom.tparametro par1 ON nc.id_parametro = par1.id_parametro
                            INNER JOIN ssom.tparametro par2 ON des.id_parametro = par2.id_parametro
                            INNER JOIN orga.vfuncionario_cargo vfu1 ON aom.id_funcionario = vfu1.id_funcionario
                            LEFT JOIN orga.vfuncionario_cargo vfu2 ON des.id_funcionario = vfu2.id_funcionario
                            INNER JOIN orga.vfuncionario_cargo vfu3 ON nc.id_funcionario = vfu3.id_funcionario
                            WHERE des.id_parametro = '||v_id_parametro||' ';

			--Devuelve la respuesta
			return v_consulta;

		end;
    
    
    /*********************************    
 	#TRANSACCION:  'SSOM_FUO_SEL'
 	#DESCRIPCION:	sel de registros
 	#AUTOR:		szambrana	
 	#FECHA:		04-12-2019 19:53:16
	***********************************/
    elsif(p_transaccion='SSOM_FUO_SEL')then

		begin
        
        	--listado de funcionarios de una UO
			v_consulta:='WITH RECURSIVE uo_mas_subordinados(id_uo_hijo,id_uo_padre) AS (
                                   SELECT
                                      euo.id_uo_hijo,	--id
                                      id_uo_padre		---padre
                                   FROM orga.testructura_uo euo
                                   WHERE euo.id_uo_hijo = '||v_parametros.id_uo||' and euo.estado_reg = ''activo''
                                   UNION
                                      SELECT
                                         e.id_uo_hijo,
                                         e.id_uo_padre
                                      FROM
                                         orga.testructura_uo e
                                      INNER JOIN uo_mas_subordinados s ON s.id_uo_hijo = e.id_uo_padre and e.estado_reg = ''activo'')
                                SELECT                         
                                    vfc.id_funcionario,
                                    vfc.desc_funcionario1 as desc_funcionario
                                FROM uo_mas_subordinados ss
                                inner join orga.vfuncionario_cargo vfc on ss.id_uo_hijo = vfc.id_uo
                                where( vfc.fecha_finalizacion is null or vfc.fecha_finalizacion >= now()::date) and ';
         
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--Devuelve la respuesta
			return v_consulta;

		end;	
        /*********************************    
        #TRANSACCION:  'SSOM_FUO_CONT'
        #DESCRIPCION:	sel de registros
        #AUTOR:		szambrana	
        #FECHA:		04-07-2019 19:53:16
        ***********************************/
    elsif(p_transaccion='SSOM_FUO_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='WITH RECURSIVE uo_mas_subordinados(id_uo_hijo,id_uo_padre) AS (
                                   SELECT
                                      euo.id_uo_hijo,	--id
                                      id_uo_padre		---padre
                                   FROM orga.testructura_uo euo
                                   WHERE euo.id_uo_hijo = '||v_parametros.id_uo||' and euo.estado_reg = ''activo''
                                   UNION
                                      SELECT
                                         e.id_uo_hijo,
                                         e.id_uo_padre
                                      FROM
                                         orga.testructura_uo e
                                      INNER JOIN uo_mas_subordinados s ON s.id_uo_hijo = e.id_uo_padre and e.estado_reg = ''activo'')
                                SELECT                         
                                    count(vfc.id_funcionario)
                                FROM uo_mas_subordinados ss
                                inner join orga.vfuncionario_cargo vfc on ss.id_uo_hijo = vfc.id_uo
                                where( vfc.fecha_finalizacion is null or vfc.fecha_finalizacion >= now()::date) and ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;
			--Devuelve la respuesta
			return v_consulta;

		end;				
	else
					     
		raise exception 'Transaccion inexistente';
					         
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