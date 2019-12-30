CREATE OR REPLACE FUNCTION ssom.ft_resp_sist_integrados_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_resp_sist_integrados_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tresp_sist_integrados'
 AUTOR: 		 (szambrana)
 FECHA:	        02-08-2019 13:18:19
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				02-08-2019 13:18:19								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tresp_sist_integrados'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ssom.ft_resp_sist_integrados_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_RESSI_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana	
 	#FECHA:		02-08-2019 13:18:19
	***********************************/

	if(p_transaccion='SSOM_RESSI_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						ressi.id_respsi,
						ressi.descrip_func,
						ressi.estado_reg,
						ressi.id_funcionario,
                        ressi.id_si,
						ressi.id_usuario_ai,
						ressi.usuario_ai,
						ressi.fecha_reg,
						ressi.id_usuario_reg,
						ressi.id_usuario_mod,
						ressi.fecha_mod,
                        usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        vfu.desc_funcionario1
						from ssom.tresp_sist_integrados ressi
						inner join segu.tusuario usu1 on usu1.id_usuario = ressi.id_usuario_reg
                        inner join orga.vfuncionario_cargo vfu on vfu.id_funcionario = ressi.id_funcionario
						left join segu.tusuario usu2 on usu2.id_usuario = ressi.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_RESSI_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-08-2019 13:18:19
	***********************************/

	elsif(p_transaccion='SSOM_RESSI_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_respsi)
					    from ssom.tresp_sist_integrados ressi
						inner join segu.tusuario usu1 on usu1.id_usuario = ressi.id_usuario_reg
                        inner join orga.vfuncionario_cargo vfu on vfu.id_funcionario = ressi.id_funcionario
						left join segu.tusuario usu2 on usu2.id_usuario = ressi.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

	--AQUI VAMOS ADICIONAR UN MACROPROCESO PARA FUNCIONARUSUARIOS
    
    /*********************************    
 	#TRANSACCION:  'SSOM_USUSI_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana	
 	#FECHA:		02-08-2019 11:18:19
	***********************************/

	elsif(p_transaccion='SSOM_USUSI_SEL')then
     				
    	begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='SELECT 
                          ofusi.id_uo_funcionario,
                          ofusi.id_funcionario,
                          ofusi.desc_funcionario1,
                          ofusi.desc_funcionario2,
                          ofusi.id_uo,
                          ofusi.nombre_cargo,
                          ofusi.fecha_asignacion,
                          ofusi.fecha_finalizacion,
                          ofusi.num_doc,
                          ofusi.ci,
                          ofusi.codigo,
                          ofusi.email_empresa,
                          ofusi.estado_reg_fun,
                          ofusi.estado_reg_asi,
                          ofusi.id_cargo,
                          ofusi.descripcion_cargo,
                          ofusi.cargo_codigo,
                          ofusi.nombre_unidad
                          FROM orga.vfuncionario_cargo ofusi
					      where ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
		end;
    /*********************************    
 	#TRANSACCION:  'SSOM_USUSI_CONT'
 	#DESCRIPCION:	Cuenta los registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-08-2019 11:17:16
	***********************************/
    elsif(p_transaccion='SSOM_USUSI_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='SELECT 
            				count(ofusi.id_funcionario)
                         FROM orga.vfuncionario_cargo ofusi
					      where ';
			
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